<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCheckin;
use App\Models\MeetupRequest;
use Illuminate\Http\Request;

class KeTemuController extends Controller
{
    // Halaman utama Srawung Ketemu
    public function index()
    {
        $user      = auth()->user();
        $checkin   = $user->activeCheckin();
        $pending   = MeetupRequest::with('requester')
                        ->where('target_id', $user->id)
                        ->where('status', 'pending')
                        ->latest()->get();
        $accepted  = MeetupRequest::with(['requester','target'])
                        ->where(fn($q) => $q->where('requester_id',$user->id)->orWhere('target_id',$user->id))
                        ->where('status','accepted')
                        ->latest()->take(5)->get();

        $nearby = collect();
        if ($checkin) {
            $nearby = $this->getNearbyUsers($checkin, $user->id);
        }

        return view('ketemu.index', compact('checkin','pending','accepted','nearby'));
    }

    // User check-in lokasi (aktif 2 jam)
    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude'   => 'required|numeric',
            'longitude'  => 'required|numeric',
            'area_label' => 'nullable|string|max:100',
        ]);

        $user = auth()->user();

        // Nonaktifkan checkin lama
        UserCheckin::where('user_id', $user->id)->update(['is_active' => false]);

        UserCheckin::create([
            'user_id'    => $user->id,
            'latitude'   => $request->latitude,
            'longitude'  => $request->longitude,
            'area_label' => $request->area_label ?? 'Area saya',
            'is_active'  => true,
            'expires_at' => now()->addHours(2),
        ]);

        // Update koordinat user
        $user->update([
            'latitude'        => $request->latitude,
            'longitude'       => $request->longitude,
            'last_active_at'  => now(),
        ]);

        return back()->with('success','Lokasimu aktif selama 2 jam! Warga sekitar bisa melihatmu.');
    }

    // Kirim request ketemu
    public function request(Request $request, User $user)
    {
        abort_if(auth()->id() === $user->id, 403);

        $request->validate([
            'message'          => 'nullable|string|max:200',
            'place_suggestion' => 'nullable|string|max:200',
        ]);

        // Cek apakah sudah ada pending request
        $exists = MeetupRequest::where('requester_id', auth()->id())
                               ->where('target_id', $user->id)
                               ->where('status','pending')
                               ->exists();

        if ($exists) return back()->with('info','Sudah ada request yang menunggu respons.');

        MeetupRequest::create([
            'requester_id'     => auth()->id(),
            'target_id'        => $user->id,
            'message'          => $request->message,
            'place_suggestion' => $request->place_suggestion,
            'latitude'         => auth()->user()->latitude,
            'longitude'        => auth()->user()->longitude,
        ]);

        return back()->with('success','Request ketemu terkirim ke '.$user->name.'!');
    }

    // Respons request (accept/decline)
    public function respond(Request $request, MeetupRequest $meetup)
    {
        abort_unless(auth()->id() === $meetup->target_id, 403);
        $request->validate(['action' => 'required|in:accepted,declined']);

        $meetup->update(['status' => $request->action]);

        $msg = $request->action === 'accepted'
            ? 'Kamu menerima ajakan ketemu! Hubungi lewat Pesan.'
            : 'Permintaan ketemu ditolak.';

        return back()->with('success', $msg);
    }

    // AJAX: user yang aktif di sekitar
    public function nearby(Request $request)
    {
        $lat = $request->query('lat');
        $lng = $request->query('lng');

        if (!$lat || !$lng) return response()->json(['users' => []]);

        $checkin = UserCheckin::firstOrNew([
            'user_id' => auth()->id()
        ]);

        $users = $this->getNearbyUsers(
            (object)['latitude' => $lat, 'longitude' => $lng],
            auth()->id()
        );

        return response()->json(['users' => $users->map(fn($u) => [
            'id'     => $u->id,
            'name'   => $u->name,
            'avatar' => $u->avatarSrc(),
            'area'   => $u->activeCheckin()?->area_label ?? '',
            'url'    => route('profil', $u),
        ])]);
    }

    private function getNearbyUsers(object $checkin, int $excludeId, float $radius = 10): \Illuminate\Support\Collection
    {
        $actives = UserCheckin::with('user')
                     ->where('is_active', true)
                     ->where('expires_at', '>', now())
                     ->where('user_id', '!=', $excludeId)
                     ->get();

        return $actives->filter(function($c) use ($checkin, $radius) {
            return $c->distanceTo((float)$checkin->latitude, (float)$checkin->longitude) <= $radius;
        })->map(fn($c) => $c->user)->filter()->values();
    }
}

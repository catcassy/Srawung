<?php
namespace App\Http\Controllers;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $kategori  = $request->query('kategori', 'semua');
        $query     = Location::with('user')->latest();

        if ($kategori !== 'semua') {
            $query->where('kategori', $kategori);
        }

        $locations = $query->paginate(12)->withQueryString();
        return view('locations.index', compact('locations','kategori'));
    }

    public function create() { return view('locations.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:100',
            'alamat'    => 'required|string|max:200',
            'deskripsi' => 'nullable|string|max:600',
            'foto'      => 'nullable|image|max:4096',
            'kategori'  => 'required|in:kuliner,wisata,kesehatan,pendidikan,umum',
            'latitude' => 'nullable|numeric',
'longitude' => 'nullable|numeric',
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('locations','public');
        }

       Location::create([
    'user_id'   => auth()->id(),
    'nama'      => $request->nama,
    'alamat'    => $request->alamat,
    'deskripsi' => $request->deskripsi,
    'foto'      => $foto,
    'kategori'  => $request->kategori,

    'latitude'  => $request->latitude,
    'longitude' => $request->longitude,
]);

        return redirect()->route('lokasi.index')->with('success','Lokasi berhasil ditambahkan!');
    }

    public function show(Location $location)
    {
        return view('locations.show', compact('location'));
    }
}

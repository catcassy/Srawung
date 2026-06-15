@extends('layouts.app')
@section('title','Srawung Ketemu — Srawung')
@section('content')
<div class="sticky bg-white/95 backdrop-blur border-b border-purple-100 px-4 py-3 z-40" style="top: 56px;">
  <h2 class="font-black text-gray-900">🤝 Srawung Ketemu</h2>
  <p class="text-xs text-gray-400">Temukan warga Jember yang online di sekitarmu — ajak ngopi!</p>
</div>

{{-- Check-in lokasi --}}
<div class="mx-4 my-4 rounded-2xl overflow-hidden border border-purple-100">
  @if($checkin && $checkin->expires_at > now())
  <div class="bg-gradient-to-br from-emerald-500 to-teal-400 p-4 text-white">
    <div class="flex items-center gap-2 mb-1">
      <span class="w-2 h-2 bg-white rounded-full" style="animation:pulse 2s infinite"></span>
      <span class="font-bold text-sm">Lokasimu Aktif</span>
    </div>
    <p class="text-xs text-emerald-100 mb-3">📍 {{ $checkin->area_label }} · Aktif hingga {{ $checkin->expires_at->format('H:i') }}</p>
    <form action="{{ route('ketemu.checkin') }}" method="POST">
      @csrf
      <input type="hidden" name="latitude" id="lat-h">
      <input type="hidden" name="longitude" id="lng-h">
      <input type="hidden" name="area_label" value="{{ $checkin->area_label }}">
      <button type="button" onclick="doCheckin()" class="bg-white/20 hover:bg-white/30 text-white text-xs font-bold px-4 py-1.5 rounded-lg transition">Perbarui Lokasi</button>
    </form>
  </div>
  @else
  <div class="bg-gradient-to-br from-violet-600 to-purple-500 p-5 text-white">
    <div class="text-2xl mb-2">📡</div>
    <p class="font-black text-base mb-1">Aktifkan Lokasimu</p>
    <p class="text-xs text-purple-200 mb-4">Agar warga sekitar bisa menemukan dan mengajakmu ngopi bareng! Aktif selama 2 jam.</p>
    <div class="flex gap-2">
      <input type="text" id="area-label" placeholder="Nama area (cth: Kaliwates)"
             class="flex-1 bg-white/20 text-white placeholder-white/50 text-sm px-3 py-2 rounded-xl focus:outline-none focus:bg-white/30 border border-white/20">
      <button onclick="doCheckin()" class="bg-white text-purple-700 font-black text-sm px-4 py-2 rounded-xl hover:bg-purple-50 transition shadow-sm whitespace-nowrap">
        Check In 📍
      </button>
    </div>
    <form id="checkin-form" action="{{ route('ketemu.checkin') }}" method="POST" class="hidden">
      @csrf
      <input type="hidden" name="latitude" id="lat-f">
      <input type="hidden" name="longitude" id="lng-f">
      <input type="hidden" name="area_label" id="area-f">
    </form>
  </div>
  @endif
</div>

{{-- Request masuk --}}
@if($pending->count() > 0)
<div class="mx-4 mb-4">
  <h3 class="font-black text-sm text-gray-900 mb-2 flex items-center gap-2">
    <span class="w-5 h-5 bg-orange-400 text-white text-xs rounded-full flex items-center justify-center font-black">{{ $pending->count() }}</span>
    Permintaan Ketemu Masuk
  </h3>
  <div class="space-y-2">
    @foreach($pending as $req)
    <div class="bg-orange-50 border border-orange-200 rounded-2xl p-4">
      <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('profil',$req->requester) }}">
          <img src="{{ $req->requester->avatarSrc() }}" class="w-10 h-10 rounded-xl object-cover shadow-sm" alt="">
        </a>
        <div class="flex-1">
          <a href="{{ route('profil',$req->requester) }}" class="font-bold text-sm text-gray-900 hover:text-purple-700">{{ $req->requester->name }}</a>
          <div class="text-xs text-gray-500">{{ $req->created_at->diffForHumans() }}</div>
        </div>
      </div>
      @if($req->message)<p class="text-sm text-gray-700 mb-1">💬 "{{ $req->message }}"</p>@endif
      @if($req->place_suggestion)<p class="text-xs text-gray-500 mb-3">📍 Saran tempat: {{ $req->place_suggestion }}</p>@endif
      <div class="flex gap-2">
        <form action="{{ route('ketemu.respond',$req) }}" method="POST" class="flex-1">
          @csrf
          <input type="hidden" name="action" value="accepted">
          <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold py-2 rounded-xl transition">✅ Terima</button>
        </form>
        <form action="{{ route('ketemu.respond',$req) }}" method="POST" class="flex-1">
          @csrf
          <input type="hidden" name="action" value="declined">
          <button type="submit" class="w-full border border-gray-200 text-gray-500 hover:bg-gray-50 text-sm font-semibold py-2 rounded-xl transition">❌ Tolak</button>
        </form>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endif

{{-- Warga di sekitar --}}
<div class="px-4 pb-20">
  <h3 class="font-black text-sm text-gray-900 mb-3 flex items-center gap-2">
    🟢 Warga Online di Sekitarmu
    @if(!$checkin || $checkin->expires_at <= now())
    <span class="text-xs text-gray-400 font-normal">(Aktifkan lokasi dulu)</span>
    @endif
  </h3>

  @if($nearby->isEmpty())
  <div class="bg-purple-50 rounded-2xl p-6 text-center">
    <div class="text-4xl mb-2">🌐</div>
    <p class="font-bold text-gray-700 text-sm">Belum ada warga online di sekitarmu</p>
    <p class="text-xs text-gray-400 mt-1">Coba lagi nanti atau perluas areamu</p>
  </div>
  @else
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
    @foreach($nearby as $u)
    <div class="bg-white border border-purple-100 rounded-2xl p-4 flex items-center gap-3 shadow-sm">
      <div class="relative flex-shrink-0">
        <a href="{{ route('profil',$u) }}">
          <img src="{{ $u->avatarSrc() }}" class="w-12 h-12 rounded-xl object-cover shadow-sm" alt="">
        </a>
        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 rounded-full border-2 border-white"></span>
      </div>
      <div class="flex-1 min-w-0">
        <a href="{{ route('profil',$u) }}" class="block font-bold text-sm text-gray-900 hover:text-purple-700 transition truncate">{{ $u->name }}</a>
        <div class="text-xs text-gray-400">📍 {{ $u->activeCheckin()?->area_label ?? 'Sekitar Jember' }}</div>
      </div>
      <button onclick="openKetemu({{ $u->id }}, '{{ $u->name }}')"
              class="bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold px-3 py-2 rounded-xl transition shadow-sm whitespace-nowrap">
        Ajak 🤝
      </button>
    </div>
    @endforeach
  </div>
  @endif

  {{-- Riwayat ketemu diterima --}}
  @if($accepted->count() > 0)
  <div class="mt-6">
    <h3 class="font-black text-sm text-gray-900 mb-3">✅ Riwayat Ketemu</h3>
    <div class="space-y-2">
      @foreach($accepted as $acc)
      @php $other = $acc->requester_id===auth()->id() ? $acc->target : $acc->requester; @endphp
      <div class="flex items-center gap-3 bg-white border border-purple-100 rounded-2xl p-3 shadow-sm">
        <a href="{{ route('profil',$other) }}">
          <img src="{{ $other->avatarSrc() }}" class="w-10 h-10 rounded-xl object-cover" alt="">
        </a>
        <div class="flex-1">
          <a href="{{ route('profil',$other) }}" class="font-bold text-sm text-gray-900 hover:text-purple-700">{{ $other->name }}</a>
          <div class="text-xs text-gray-400">{{ $acc->created_at->diffForHumans() }}</div>
        </div>
        <a href="{{ route('pesan.show',$other) }}" class="text-xs text-purple-600 font-semibold hover:underline">DM →</a>
      </div>
      @endforeach
    </div>
  </div>
  @endif
</div>

{{-- Modal Ketemu --}}
<div id="ketemu-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-end md:items-center justify-center px-4 pb-20 md:pb-4">
  <div class="bg-white rounded-2xl p-5 w-full max-w-sm shadow-xl">
    <h3 class="font-black text-gray-900 mb-1">🤝 Ajak Ketemu</h3>
    <p id="modal-name" class="text-sm text-purple-600 font-semibold mb-4"></p>
    <form id="ketemu-form" method="POST" class="space-y-3">
      @csrf
      <div>
        <label class="block text-xs font-bold text-gray-600 mb-1">Pesan (opsional)</label>
        <input type="text" name="message" maxlength="200"
               class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="cth: Ngopi bareng yuk!">
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-600 mb-1">Saran Tempat (opsional)</label>
        <input type="text" name="place_suggestion" maxlength="200"
               class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400" placeholder="cth: Warung Kopi Patrang">
      </div>
      <div class="flex gap-2 pt-1">
        <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 rounded-xl text-sm transition">Kirim Ajakan 🤝</button>
        <button type="button" onclick="closeModal()" class="px-4 border border-gray-200 text-gray-500 rounded-xl text-sm font-semibold hover:bg-gray-50 transition">Batal</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
function doCheckin(){
  if(!navigator.geolocation){alert('Browser tidak support GPS');return;}
  navigator.geolocation.getCurrentPosition(function(pos){
    const lat=pos.coords.latitude, lng=pos.coords.longitude;
    const area=document.getElementById('area-label')?.value||'Sekitar Jember';
    const lf=document.getElementById('lat-f'),lnf=document.getElementById('lng-f'),af=document.getElementById('area-f');
    if(lf&&lnf&&af){lf.value=lat;lnf.value=lng;af.value=area;document.getElementById('checkin-form').submit();}
    else{document.getElementById('lat-h').value=lat;document.getElementById('lng-h').value=lng;document.querySelector('#checkin-form').submit();}
  },()=>alert('Gagal mendapatkan lokasi. Pastikan GPS aktif.'));
}

function openKetemu(id, name){
  document.getElementById('ketemu-modal').classList.remove('hidden');
  document.getElementById('modal-name').textContent='Mengirim ajakan ke: '+name;
  document.getElementById('ketemu-form').action=`{{ route('ketemu.request', '') }}`.slice(0, -1)+id;
}

function closeModal(){ 
  document.getElementById('ketemu-modal').classList.add('hidden'); 
}

document.getElementById('ketemu-modal').addEventListener('click',function(e){
  if(e.target===this)closeModal();
});
</script>
<style>@keyframes pulse{0%,100%{opacity:1}50%{opacity:.4}}</style>
@endpush
@endsection

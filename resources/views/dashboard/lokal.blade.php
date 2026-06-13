@extends('layouts.app')
@section('title','Thread Lokal — Srawung')
@section('content')
<div class="sticky top-0 bg-white/95 backdrop-blur border-b border-purple-100 px-4 py-3 z-10">
  <h2 class="font-black text-gray-900">📍 Thread Lokal</h2>
  <p class="text-xs text-gray-400">Post yang hanya bisa dibaca warga di area yang sama</p>
</div>

{{-- GPS Panel --}}
<div class="mx-4 my-4 rounded-2xl overflow-hidden border border-purple-100" id="gps-panel">
  @if(!$lat || !$lng)
  <div class="bg-gradient-to-br from-violet-600 to-purple-500 p-5 text-white">
    <div class="flex items-start gap-3">
      <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0 text-xl">📍</div>
      <div class="flex-1">
        <p class="font-bold mb-1">Aktifkan Lokasi</p>
        <p class="text-xs text-purple-100 mb-3">Izinkan akses lokasi agar bisa melihat Thread Lokal di sekitarmu. Lokasi tidak disimpan permanen.</p>
        <button onclick="getLocation()" id="loc-btn"
                class="bg-white text-purple-700 font-bold text-sm px-5 py-2 rounded-xl transition hover:bg-purple-50 shadow-sm">
          📡 Bagikan Lokasimu
        </button>
      </div>
    </div>
  </div>
  @else
  <div class="bg-purple-50 border border-purple-100 px-4 py-3 flex items-center gap-2">
    <span class="w-2 h-2 bg-green-400 rounded-full" style="animation:pulse 2s infinite"></span>
    <span class="text-xs font-semibold text-purple-700">Lokasi aktif — menampilkan thread di sekitarmu</span>
    <button onclick="getLocation()" class="ml-auto text-xs text-purple-500 hover:underline">Perbarui</button>
  </div>
  @endif
</div>

<div class="px-4 mb-3">
  <a href="{{ route('post.create',['local'=>1]) }}"
     class="flex items-center gap-2 border-2 border-dashed border-purple-200 rounded-xl px-4 py-3 text-sm text-purple-500 hover:bg-purple-50 transition font-semibold">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Buat Thread Lokal baru
  </a>
</div>

@if($localPosts->isEmpty())
<div class="text-center py-16 text-gray-300 px-4">
  <div class="text-5xl mb-3">🗺️</div>
  <p class="font-bold text-gray-500">Belum ada Thread Lokal di areamu</p>
  <p class="text-xs mt-1 text-gray-400">Aktifkan lokasi atau jadilah yang pertama posting!</p>
</div>
@else
@foreach($localPosts as $post)
  @include('posts._card',['post'=>$post])
@endforeach
@endif

@push('scripts')
<script>
function getLocation(){
  const btn=document.getElementById('loc-btn');
  if(btn){btn.textContent='Mencari lokasi...';btn.disabled=true;}
  if(!navigator.geolocation){alert('Browser tidak mendukung GPS');return;}
  navigator.geolocation.getCurrentPosition(
    pos=>{ window.location.href='{{ route("lokal") }}?lat='+pos.coords.latitude+'&lng='+pos.coords.longitude; },
    ()=>{ if(btn){btn.textContent='Gagal — Coba lagi';btn.disabled=false;} }
  );
}
</script>
<style>@keyframes pulse{0%,100%{opacity:1}50%{opacity:.4}}</style>
@endpush
@endsection

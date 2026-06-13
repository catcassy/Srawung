@extends('layouts.app')
@section('title','Buat Post — Srawung')
@section('content')
<div class="sticky top-0 bg-white/95 backdrop-blur border-b border-purple-100 px-4 py-3 flex items-center justify-between z-10">
  <div class="flex items-center gap-3">
    <a href="{{ route('dashboard') }}" class="p-1.5 rounded-xl hover:bg-gray-100 transition">
      <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </a>
    <span class="font-black text-gray-900">Buat Post</span>
  </div>
  <button form="post-form" type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-1.5 rounded-xl text-sm font-bold transition shadow-sm">
    Post
  </button>
</div>

<form id="post-form" action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" class="px-4 py-4">
  @csrf
  <div class="flex gap-3">
    <img src="{{ auth()->user()->avatarSrc() }}" class="w-10 h-10 rounded-xl object-cover flex-shrink-0 shadow-sm" alt="">
    <div class="flex-1">
      {{-- Mode toggle --}}
      <div class="flex gap-2 mb-3">
        <label class="cursor-pointer">
          <input type="radio" name="mode_post" value="publik" class="sr-only peer" {{ auth()->user()->mode==='publik'?'checked':'' }}>
          <div class="text-xs border border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 peer-checked:text-purple-700 text-gray-400 px-3 py-1.5 rounded-lg transition font-semibold">👤 Publik</div>
        </label>
        <label class="cursor-pointer">
          <input type="radio" name="mode_post" value="anonim" class="sr-only peer" {{ auth()->user()->mode==='anonim'?'checked':'' }}>
          <div class="text-xs border border-gray-200 peer-checked:border-gray-500 peer-checked:bg-gray-100 peer-checked:text-gray-700 text-gray-400 px-3 py-1.5 rounded-lg transition font-semibold">🕵️ Anonim</div>
        </label>
      </div>

      <textarea name="content" id="content" rows="5" required maxlength="500" autofocus
                class="w-full text-base placeholder-gray-300 outline-none resize-none bg-transparent leading-relaxed text-gray-900"
                placeholder="Ada cerita dari Jember hari ini?">{{ old('content') }}</textarea>

      <div id="img-preview" class="hidden mt-3 rounded-xl overflow-hidden border border-purple-100 relative">
        <img id="preview-img" src="" alt="" class="w-full max-h-56 object-cover">
        <button type="button" onclick="removeImg()" class="absolute top-2 right-2 bg-black/40 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold">✕</button>
      </div>

      {{-- Thread Lokal --}}
      <div class="mt-4 p-3 bg-purple-50 rounded-xl border border-purple-100">
        <label class="flex items-center gap-2 cursor-pointer mb-1">
          <input type="checkbox" name="is_local_thread" id="is-local" value="1"
                 {{ request('local') ? 'checked' : '' }}
                 class="rounded accent-purple-600" onchange="toggleLocal()">
          <span class="text-sm font-bold text-purple-700">📍 Jadikan Thread Lokal</span>
        </label>
        <p class="text-xs text-purple-400 mb-2">Post hanya tampil untuk warga di sekitar area ini.</p>
        <div id="local-fields" class="{{ request('local') ? '' : 'hidden' }} space-y-2">
          <input type="text" name="area_label" value="{{ old('area_label') }}"
                 class="w-full border border-purple-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300 bg-white"
                 placeholder="Nama area (cth: Kaliwates, Patrang)">
          <div class="grid grid-cols-2 gap-2">
            <input type="number" name="latitude" id="lat-input" step="any" value="{{ old('latitude') }}"
                   class="border border-purple-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-purple-300 bg-white" placeholder="Latitude">
            <input type="number" name="longitude" id="lng-input" step="any" value="{{ old('longitude') }}"
                   class="border border-purple-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:ring-2 focus:ring-purple-300 bg-white" placeholder="Longitude">
          </div>
          <button type="button" onclick="autoLoc()" class="text-xs text-purple-600 font-semibold hover:underline">📌 Gunakan lokasiku sekarang</button>
          <select name="radius_km" class="w-full border border-purple-200 rounded-lg px-3 py-1.5 text-xs bg-white focus:outline-none focus:ring-2 focus:ring-purple-300">
            <option value="2">Radius 2 km</option>
            <option value="5" selected>Radius 5 km</option>
            <option value="10">Radius 10 km</option>
            <option value="20">Seluruh Jember</option>
          </select>
        </div>
      </div>

      <div class="flex items-center justify-between mt-3 pt-3 border-t border-purple-50">
        <label class="cursor-pointer p-2 rounded-xl hover:bg-purple-50 text-purple-400 transition">
          <input type="file" name="image" id="img-input" accept="image/*" class="hidden" onchange="previewImg(this)">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </label>
        <span id="char-count" class="text-xs text-gray-300">0 / 500</span>
      </div>
    </div>
  </div>
</form>
@push('scripts')
<script>
document.getElementById('content').addEventListener('input',function(){
  const n=this.value.length,el=document.getElementById('char-count');
  el.textContent=n+' / 500';
  el.className='text-xs '+(n>450?'text-red-500':'text-gray-300');
});
function previewImg(i){if(i.files&&i.files[0]){document.getElementById('preview-img').src=URL.createObjectURL(i.files[0]);document.getElementById('img-preview').classList.remove('hidden');}}
function removeImg(){document.getElementById('img-input').value='';document.getElementById('img-preview').classList.add('hidden');}
function toggleLocal(){document.getElementById('local-fields').classList.toggle('hidden',!document.getElementById('is-local').checked);}
function autoLoc(){navigator.geolocation.getCurrentPosition(p=>{document.getElementById('lat-input').value=p.coords.latitude.toFixed(7);document.getElementById('lng-input').value=p.coords.longitude.toFixed(7);});}
</script>
@endpush
@endsection

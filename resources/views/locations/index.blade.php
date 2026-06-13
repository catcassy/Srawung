@extends('layouts.app')
@section('title','Hidden Gem — Srawung')
@section('content')

<div class="sticky top-0 bg-white/95 backdrop-blur border-b border-purple-100 px-4 py-3 flex items-center justify-between z-10 md:top-0 top-14">
  <div>
    <h2 class="font-black text-gray-900">✨ Hidden Gem</h2>
    <p class="text-xs text-gray-400">Rekomendasi tempat dari warga Jember</p>
  </div>
  <a href="{{ route('lokasi.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition shadow-sm">+ Tambah</a>
</div>

{{-- Filter kategori — berfungsi via URL query --}}
<div class="flex gap-2 px-4 py-3 overflow-x-auto no-scroll border-b border-purple-50">
  @foreach(['semua'=>'Semua','kuliner'=>'🍜 Kuliner','wisata'=>'🌄 Wisata','kesehatan'=>'🏥 Kesehatan','pendidikan'=>'📚 Pendidikan','umum'=>'📍 Umum'] as $val=>$label)
  <a href="{{ route('lokasi.index', ['kategori'=>$val]) }}"
     class="flex-shrink-0 text-xs font-semibold px-4 py-1.5 rounded-full border transition whitespace-nowrap
            {{ $kategori===$val ? 'bg-purple-600 text-white border-purple-600 shadow-sm' : 'border-gray-200 text-gray-600 hover:border-purple-300 hover:text-purple-600' }}">
    {{ $label }}
  </a>
  @endforeach
</div>

@if($locations->isEmpty())
<div class="text-center py-20 text-gray-400">
  <div class="text-5xl mb-3">🗺️</div>
  <p class="font-medium text-gray-600">Belum ada lokasi{{ $kategori!=='semua' ? ' kategori ini' : '' }}</p>
  <a href="{{ route('lokasi.create') }}" class="text-purple-600 text-sm hover:underline mt-1 inline-block">Tambahkan yang pertama →</a>
</div>
@else
<div class="grid grid-cols-1 sm:grid-cols-2 gap-0 divide-y divide-purple-50 sm:divide-y-0 sm:gap-4 sm:p-4">
  @foreach($locations as $loc)
  <a href="{{ route('lokasi.show', $loc) }}" class="group block sm:rounded-2xl sm:border sm:border-purple-100 overflow-hidden hover:shadow-lg transition-shadow bg-white">
    <div class="relative h-40 bg-purple-50 overflow-hidden">
      @if($loc->foto)
      <img src="{{ asset('storage/'.$loc->foto) }}" alt="{{ $loc->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
      @else
      <div class="w-full h-full flex items-center justify-center text-5xl bg-gradient-to-br from-purple-50 to-violet-100">{{ $loc->kategoriIcon() }}</div>
      @endif
      <span class="absolute top-2 right-2 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded-lg text-gray-700 shadow-sm">{{ $loc->kategoriIcon() }} {{ ucfirst($loc->kategori) }}</span>
    </div>
    <div class="px-4 py-3 sm:px-3">
      <h3 class="font-bold text-sm text-gray-900 group-hover:text-purple-700 transition mb-0.5">{{ $loc->nama }}</h3>
      <p class="text-xs text-gray-400 flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/></svg>{{ $loc->alamat }}</p>
      @if($loc->deskripsi)<p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $loc->deskripsi }}</p>@endif
      <p class="text-xs text-gray-300 mt-2">oleh {{ $loc->user->name }}</p>
    </div>
  </a>
  @endforeach
</div>
<div class="px-4 py-4 mb-16 md:mb-0">{{ $locations->links() }}</div>
@endif
@endsection

@extends('layouts.app')
@section('title', $q ? "\"$q\" — Srawung" : 'Cari — Srawung')
@section('content')

<div class="sticky top-0 bg-white/95 backdrop-blur border-b border-purple-100 px-4 py-3 z-10">
    <h2 class="font-black text-gray-900 mb-2">🔍 Pencarian</h2>
    <form action="{{ route('search') }}" method="GET">
        <div class="relative">
            <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="q" value="{{ $q }}" autofocus
                   placeholder="Cari user, username, atau topik..."
                   class="w-full pl-10 pr-4 py-2.5 bg-purple-50 border border-purple-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 focus:bg-white transition">
        </div>
    </form>
</div>

@if($q === '')
<div class="text-center py-16 text-gray-400">
    <div class="text-5xl mb-3">🔍</div>
    <p class="font-medium text-gray-500">Ketik sesuatu untuk mencari</p>
    <p class="text-sm mt-1">Cari berdasarkan nama, username, atau isi post</p>
</div>

@elseif($users->isEmpty() && $posts->isEmpty())
<div class="text-center py-16 text-gray-400">
    <div class="text-5xl mb-3">😔</div>
    <p class="font-medium text-gray-500">Tidak ada hasil untuk <strong>"{{ $q }}"</strong></p>
    <p class="text-sm mt-1">Coba kata kunci yang berbeda</p>
</div>

@else

{{-- Hasil User --}}
@if($users->isNotEmpty())
<div class="px-4 pt-4 pb-2">
    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Pengguna ({{ $users->count() }})</h3>
    <div class="space-y-2">
        @foreach($users as $u)
        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-purple-50 transition">
            <a href="{{ route('profil', $u) }}">
                <img src="{{ $u->avatarSrc() }}" class="w-11 h-11 rounded-xl object-cover shadow-sm" alt="">
            </a>
            <div class="flex-1 min-w-0">
                <a href="{{ route('profil', $u) }}" class="block font-bold text-sm text-gray-900 hover:text-purple-700 transition">{{ $u->name }}</a>
                <div class="text-xs text-gray-400">{{ $u->username }} · {{ $u->kota }}</div>
                @if($u->bio)
                <div class="text-xs text-gray-500 truncate mt-0.5">{{ $u->bio }}</div>
                @endif
            </div>
            <div class="flex gap-2">
                @if(!auth()->user()->isFollowing($u))
                <form action="{{ route('follow.toggle', $u) }}" method="POST">
                    @csrf
                    <button class="text-xs font-semibold text-purple-600 border border-purple-200 px-3 py-1.5 rounded-lg hover:bg-purple-50 transition">Ikuti</button>
                </form>
                @else
                <span class="text-xs text-gray-400 font-medium px-3 py-1.5">Diikuti ✓</span>
                @endif
                <a href="{{ route('pesan.show', $u) }}" class="text-xs font-semibold text-gray-500 border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-50 transition">Pesan</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
<div class="border-t border-purple-50 my-2"></div>
@endif

{{-- Hasil Post --}}
@if($posts->isNotEmpty())
<div class="px-4 py-2">
    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Post ({{ $posts->count() }})</h3>
</div>
@foreach($posts as $post)
    @include('posts._card', ['post' => $post])
@endforeach
@endif

@endif

@endsection

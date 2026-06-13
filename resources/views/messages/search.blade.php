@extends('layouts.app')
@section('title','Cari untuk kirim pesan — Srawung')
@section('content')

<div class="sticky top-0 bg-white/95 backdrop-blur border-b border-purple-100 px-4 py-3 flex items-center gap-3 z-10">
    <a href="{{ route('pesan.index') }}" class="p-1.5 rounded-xl hover:bg-gray-100 transition">
        <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <form action="{{ route('pesan.search') }}" method="GET" class="flex-1">
        <div class="relative">
            <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="q" value="{{ $q }}" autofocus
                   placeholder="Cari nama atau username..."
                   class="w-full pl-9 pr-4 py-2 bg-purple-50 border border-purple-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 focus:bg-white transition">
        </div>
    </form>
</div>

@if($q === '')
<div class="text-center py-16 text-gray-400">
    <div class="text-5xl mb-3">💬</div>
    <p class="font-medium text-gray-500">Cari pengguna untuk diajak ngobrol</p>
    <p class="text-sm mt-1">Ketik nama atau username</p>
</div>
@elseif($users->isEmpty())
<div class="text-center py-16 text-gray-400">
    <div class="text-4xl mb-3">🤷</div>
    <p class="font-medium">Tidak ada pengguna dengan nama <strong>"{{ $q }}"</strong></p>
</div>
@else
<div class="divide-y divide-purple-50">
    @foreach($users as $u)
    <a href="{{ route('pesan.show', $u) }}" class="flex items-center gap-3 px-4 py-3.5 hover:bg-purple-50 transition">
        <img src="{{ $u->avatarSrc() }}" class="w-12 h-12 rounded-xl object-cover shadow-sm flex-shrink-0" alt="">
        <div class="flex-1 min-w-0">
            <div class="font-bold text-sm text-gray-900">{{ $u->name }}</div>
            <div class="text-xs text-gray-400">{{ $u->username }} · {{ $u->kota }}</div>
            @if($u->bio)<div class="text-xs text-gray-500 truncate mt-0.5">{{ $u->bio }}</div>@endif
        </div>
        <div class="w-8 h-8 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
        </div>
    </a>
    @endforeach
</div>
@endif

@endsection

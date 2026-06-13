@extends('layouts.app')
@section('title',$title.' — '.$user->name)
@section('content')
<div class="sticky top-0 bg-white/95 backdrop-blur border-b border-purple-100 px-4 py-3 flex items-center gap-3 z-10">
  <a href="{{ route('profil',$user) }}" class="p-1.5 rounded-xl hover:bg-gray-100 transition">
    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
  </a>
  <div>
    <div class="font-black text-gray-900">{{ $title }}</div>
    <div class="text-xs text-gray-400">{{ $user->username }}</div>
  </div>
</div>

@if($list->isEmpty())
<div class="text-center py-16 text-gray-300">
  <div class="text-4xl mb-2">👥</div>
  <p class="text-sm font-medium text-gray-400">Belum ada {{ strtolower($title) }}.</p>
</div>
@else
<div class="divide-y divide-purple-50">
  @foreach($list as $u)
  <div class="flex items-center gap-3 px-4 py-3.5 hover:bg-purple-50/50 transition">
    <a href="{{ route('profil',$u) }}" class="flex-shrink-0">
      <img src="{{ $u->avatarSrc() }}" class="w-12 h-12 rounded-xl object-cover shadow-sm" alt="{{ $u->name }}">
    </a>
    <div class="flex-1 min-w-0">
      <a href="{{ route('profil',$u) }}" class="block font-bold text-sm text-gray-900 hover:text-purple-700 transition truncate">{{ $u->name }}</a>
      <div class="text-xs text-gray-400">{{ $u->username }}</div>
      @if($u->bio)<p class="text-xs text-gray-500 truncate mt-0.5">{{ $u->bio }}</p>@endif
    </div>
    @if($u->id !== auth()->id())
      @if(!auth()->user()->isFollowing($u))
      <form action="{{ route('follow.toggle',$u) }}" method="POST">
        @csrf
        <button class="text-xs font-bold text-purple-600 border border-purple-200 px-3 py-1.5 rounded-xl hover:bg-purple-50 transition whitespace-nowrap">Ikuti</button>
      </form>
      @else
      <form action="{{ route('follow.toggle',$u) }}" method="POST">
        @csrf
        <button class="text-xs font-semibold text-gray-400 border border-gray-200 px-3 py-1.5 rounded-xl hover:border-red-200 hover:text-red-400 transition whitespace-nowrap">Diikuti ✓</button>
      </form>
      @endif
    @endif
  </div>
  @endforeach
</div>
<div class="px-4 py-4">{{ $list->links() }}</div>
@endif
@endsection

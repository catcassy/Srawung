@extends('layouts.app')
@section('title','Pesan — Srawung')
@section('content')

<div class="sticky top-0 bg-white/95 backdrop-blur border-b border-purple-100 px-4 py-3 flex items-center justify-between z-10 md:top-0 top-14">
  <h2 class="font-black text-gray-900">Pesan</h2>
  <a href="{{ route('pesan.search') }}" class="flex items-center gap-1.5 text-sm font-semibold text-purple-600 border border-purple-200 px-3 py-1.5 rounded-xl hover:bg-purple-50 transition">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    Pesan Baru
  </a>
</div>

@if($conversations->isEmpty())
<div class="text-center py-20 text-gray-400">
  <div class="text-5xl mb-3">💬</div>
  <p class="font-medium text-gray-600">Belum ada percakapan</p>
  <a href="{{ route('pesan.search') }}" class="mt-3 inline-block bg-purple-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl hover:bg-purple-700 transition">Mulai percakapan</a>
</div>
@else
<div class="divide-y divide-purple-50">
  @foreach($conversations as $userId => $msg)
  @php $other = $msg->sender_id === auth()->id() ? $msg->receiver : $msg->sender; @endphp
  <a href="{{ route('pesan.show', $other) }}" class="flex items-center gap-3 px-4 py-3.5 hover:bg-purple-50 transition">
    <div class="relative flex-shrink-0">
      <img src="{{ $other->avatarSrc() }}" class="w-12 h-12 rounded-xl object-cover shadow-sm" alt="">
      @if(!$msg->is_read && $msg->receiver_id === auth()->id())
      <span class="absolute top-0 right-0 w-3 h-3 bg-purple-500 rounded-full border-2 border-white"></span>
      @endif
    </div>
    <div class="flex-1 min-w-0">
      <div class="flex justify-between items-baseline mb-0.5">
        <span class="font-bold text-sm text-gray-900">{{ $other->name }}</span>
        <span class="text-xs text-gray-400 flex-shrink-0 ml-2">{{ $msg->created_at->diffForHumans() }}</span>
      </div>
      <p class="text-xs text-gray-500 truncate">
        @if($msg->sender_id === auth()->id())<span class="text-gray-400">Kamu: </span>@endif{{ $msg->body }}
      </p>
    </div>
  </a>
  @endforeach
</div>
@endif
@endsection

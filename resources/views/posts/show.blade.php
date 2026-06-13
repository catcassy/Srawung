@extends('layouts.app')
@section('title','Post — Srawung')
@section('content')
<div class="sticky top-0 bg-white/95 backdrop-blur border-b border-purple-100 px-4 py-3 flex items-center gap-3 z-10">
  <a href="javascript:history.back()" class="p-1.5 rounded-xl hover:bg-gray-100 transition">
    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
  </a>
  <span class="font-black text-gray-900">Post</span>
</div>

<div class="px-4 py-4 border-b border-purple-50">
  <div class="flex items-center gap-3 mb-3">
    @if($post->mode_post==='anonim')
    <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center text-gray-400 font-black">?</div>
    @else
    <a href="{{ route('profil',$post->user) }}">
      <img src="{{ $post->user->avatarSrc() }}" class="w-12 h-12 rounded-xl object-cover shadow-sm" alt="">
    </a>
    @endif
    <div class="flex-1">
      @if($post->mode_post==='publik')
      <a href="{{ route('profil',$post->user) }}" class="font-bold text-gray-900 hover:text-purple-700">{{ $post->user->name }}</a>
      <div class="text-xs text-gray-400">{{ $post->user->username }}</div>
      @else
      <span class="font-bold text-gray-500">Anonim 🕵️</span>
      @endif
    </div>
    @if(auth()->id()===$post->user_id)
    <form action="{{ route('post.destroy',$post) }}" method="POST" onsubmit="return confirm('Hapus?')">
      @csrf @method('DELETE')
      <button class="text-gray-300 hover:text-red-400 p-2 rounded-xl hover:bg-red-50 transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
      </button>
    </form>
    @endif
  </div>
  <p class="text-base text-gray-900 leading-relaxed mb-3">{{ $post->content }}</p>
  @if($post->image)
  <div class="rounded-2xl overflow-hidden border border-purple-50 mb-3">
    <img src="{{ Storage::url($post->image) }}" alt="" class="w-full">
  </div>
  @endif
  <div class="text-xs text-gray-400 mb-3">{{ $post->created_at->format('j M Y · H:i') }}</div>
  <div class="flex gap-5 text-sm border-y border-purple-50 py-3 mb-3">
    <span><strong class="text-gray-900">{{ $post->reposts->count() }}</strong> <span class="text-gray-400">Repost</span></span>
    <span><strong class="text-gray-900">{{ $post->likes->count() }}</strong> <span class="text-gray-400">Suka</span></span>
    <span><strong class="text-gray-900">{{ $post->comments->count() }}</strong> <span class="text-gray-400">Komentar</span></span>
  </div>
  <div class="flex gap-2">
    <form action="{{ route('like.toggle',$post) }}" method="POST">
      @csrf
      <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition {{ $post->isLikedBy(auth()->user()) ? 'bg-rose-50 text-rose-500' : 'bg-gray-50 text-gray-500 hover:bg-rose-50 hover:text-rose-500' }}">
        <svg class="w-4 h-4" fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
        {{ $post->isLikedBy(auth()->user()) ? 'Disukai' : 'Suka' }}
      </button>
    </form>
    <form action="{{ route('post.repost',$post) }}" method="POST">
      @csrf
      <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold bg-gray-50 text-gray-500 hover:bg-emerald-50 hover:text-emerald-600 transition">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
        Repost
      </button>
    </form>
  </div>
</div>

<div class="flex gap-3 px-4 py-3 border-b border-purple-50 bg-purple-50/30">
  <img src="{{ auth()->user()->avatarSrc() }}" class="w-9 h-9 rounded-xl object-cover flex-shrink-0" alt="">
  <form action="{{ route('comment.store',$post) }}" method="POST" class="flex-1 flex gap-2">
    @csrf
    <input type="text" name="body" required maxlength="300"
           class="flex-1 bg-white border border-purple-200 rounded-xl px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300 transition"
           placeholder="Tulis komentarmu...">
    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition">Kirim</button>
  </form>
</div>

@foreach($post->comments as $c)
<div class="flex gap-3 px-4 py-3 border-b border-purple-50 card-hover">
  <img src="{{ $c->user->avatarSrc() }}" class="w-9 h-9 rounded-xl object-cover flex-shrink-0" alt="">
  <div class="flex-1">
    <div class="flex items-baseline gap-1.5 mb-0.5">
      <a href="{{ route('profil',$c->user) }}" class="text-sm font-bold text-gray-900 hover:text-purple-700">{{ $c->user->name }}</a>
      <span class="text-xs text-gray-400">· {{ $c->created_at->diffForHumans() }}</span>
    </div>
    <p class="text-sm text-gray-800">{{ $c->body }}</p>
  </div>
  @if(auth()->id()===$c->user_id)
  <form action="{{ route('comment.destroy',$c) }}" method="POST">
    @csrf @method('DELETE')
    <button class="text-gray-200 hover:text-red-400 text-xs p-1 transition">✕</button>
  </form>
  @endif
</div>
@endforeach
@endsection

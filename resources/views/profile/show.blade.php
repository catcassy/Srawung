@extends('layouts.app')
@section('title', $user->name . ' — Srawung')
@section('content')

<div
class="h-28 relative"
style="background: {{ $user->header_color ?? '#6366f1' }}">
  <a href="javascript:history.back()" class="absolute top-3 left-3 bg-black/20 hover:bg-black/40 text-white rounded-xl p-1.5 transition backdrop-blur-sm">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
  </a>
</div>

<div class="px-4 pb-4 border-b border-purple-100">
  <div class="flex justify-between items-end -mt-7 mb-3">
    <div class="relative">
      <img src="{{ $user->avatarSrc() }}" class="w-16 h-16 rounded-2xl object-cover border-4 border-white shadow-sm" alt="">
      <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white {{ $user->mode==='publik' ? 'bg-emerald-400' : 'bg-gray-400' }}"></span>
    </div>
    <div class="flex gap-2 mb-1">
      @if(!$isSelf)
        @if(auth()->user()->mode === 'publik')
        <a href="{{ route('pesan.show', $user) }}" class="border border-gray-200 hover:bg-gray-50 text-gray-700 px-4 py-1.5 rounded-xl text-sm font-medium transition">Pesan</a>
        <form action="{{ route('follow.toggle', $user) }}" method="POST">@csrf
          <button class="{{ $isFollowing ? 'border border-gray-200 text-gray-700 hover:border-red-300 hover:text-red-500' : 'bg-purple-600 text-white hover:bg-purple-700' }} px-4 py-1.5 rounded-xl text-sm font-semibold transition">
            {{ $isFollowing ? 'Diikuti' : 'Ikuti' }}
          </button>
        </form>
        @endif
      @else
        <a href="{{ route('profile.edit') }}" class="border border-gray-200 hover:bg-gray-50 text-gray-700 px-4 py-1.5 rounded-xl text-sm font-medium transition">Edit Profil</a>
      @endif
    </div>
  </div> 

  <h2 class="text-lg font-black text-gray-900">{{ $user->name }}</h2>
  <p class="text-sm text-gray-400 mb-1">{{ $user->username }}</p>
  @if($user->bio)<p class="text-sm text-gray-700 mb-2">{{ $user->bio }}</p>@endif
  <div class="flex items-center gap-1 text-xs text-gray-400 mb-3">
    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/></svg>
    {{ $user->kota }}
  </div>

  {{-- Klik mengikuti/pengikut buka list --}}
  <div class="flex gap-4 text-sm">
    <a href="{{ route('profil.following', $user) }}" class="hover:text-purple-700 transition">
      <strong class="text-gray-900 font-bold">{{ $user->following->count() }}</strong>
      <span class="text-gray-400"> Mengikuti</span>
    </a>
    <a href="{{ route('profil.followers', $user) }}" class="hover:text-purple-700 transition">
      <strong class="text-gray-900 font-bold">{{ $user->followers->count() }}</strong>
      <span class="text-gray-400"> Pengikut</span>
    </a>
    <span>
      <strong class="text-gray-900 font-bold">{{ $user->publicPostsCount() }}</strong>
      <span class="text-gray-400"> Post</span>
    </span>
  </div>

  @if($isSelf)
  <div class="mt-3 flex gap-2">
    <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $user->mode==='anonim' ? 'bg-gray-100 text-gray-600' : 'bg-purple-50 text-purple-600' }}">
      {{ $user->mode==='anonim' ? '🕵️ Anonim' : '👤 Publik' }}
    </span>
    <form action="{{ route('profile.mode') }}" method="POST">@csrf
      <input type="hidden" name="mode" value="{{ $user->mode==='publik' ? 'anonim' : 'publik' }}">
      <button class="text-xs text-gray-400 hover:text-purple-600 px-2.5 py-1 rounded-full border border-gray-200 hover:border-purple-300 transition">
        Ganti ke {{ $user->mode==='publik' ? 'Anonim' : 'Publik' }}
      </button>
    </form>
  </div>
  @endif
</div>

<div class="border-b border-purple-50 px-4 py-2.5">
  <span class="text-sm font-semibold text-gray-900 border-b-2 border-purple-500 pb-2">Post Publik</span>
  <span class="text-xs text-gray-400 ml-2">(post anonim tidak ditampilkan)</span>
</div>

@forelse($posts as $post)
  @include('posts._card', ['post'=>$post])
@empty
  <div class="text-center py-14 text-gray-400"><div class="text-4xl mb-2">✏️</div><p class="text-sm">Belum ada post publik.</p></div>
@endforelse

<div class="px-4 py-4 mb-16 md:mb-0">{{ $posts->links() }}</div>
@endsection

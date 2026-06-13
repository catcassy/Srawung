@extends('layouts.app')
@section('title','Edit Profil — Srawung')
@section('content')
<div class="sticky top-0 bg-white/95 backdrop-blur border-b border-purple-100 px-4 py-3 flex items-center gap-3 z-10">
  <a href="{{ route('profil',auth()->user()) }}" class="p-1.5 rounded-xl hover:bg-gray-100 transition">
    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
  </a>
  <span class="font-black text-gray-900">Edit Profil</span>
</div>
<div class="max-w-lg mx-auto px-4 py-6 space-y-5">
  @if(session('success'))
  <div class="bg-purple-50 border border-purple-100 text-purple-700 text-sm rounded-xl px-4 py-3 flex items-center gap-2">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
  </div>
  @endif

  <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    {{-- Avatar --}}
    <div class="flex items-center gap-4">
      <div class="relative flex-shrink-0">
        <img src="{{ $user->avatarSrc() }}" id="av-preview" class="w-20 h-20 rounded-2xl object-cover border-2 border-purple-100 shadow-sm" alt="">
        <label class="absolute inset-0 flex items-center justify-center bg-black/30 rounded-2xl opacity-0 hover:opacity-100 transition cursor-pointer">
          <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
          <input type="file" name="avatar" accept="image/*" class="hidden" onchange="prevAv(this)">
        </label>
      </div>
      <div>
        <p class="text-sm font-bold text-gray-900">Foto Profil</p>
        <p class="text-xs text-gray-400">Klik foto untuk mengubah. Maks 2MB.</p>
      </div>
    </div>
    <div>
      <label class="block text-xs font-bold text-gray-600 mb-1.5">Nama Lengkap</label>
      <input type="text" name="name" value="{{ old('name',$user->name) }}" required
             class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 transition">
    </div>

    <div>
    <label class="block text-xs font-bold text-gray-600 mb-1.5">
        Username
    </label>

    <input
        type="text"
        name="username"
        value="{{ old('username',$user->username) }}"
        class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 transition">
</div>
    <div>
      <label class="block text-xs font-bold text-gray-600 mb-1.5">Bio</label>
      <textarea name="bio" rows="3" maxlength="200"
                class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 transition resize-none"
                placeholder="Ceritakan sedikit tentang kamu...">{{ old('bio',$user->bio) }}</textarea>
    </div>
    <div>
      <label class="block text-xs font-bold text-gray-600 mb-1.5">Kota</label>
      <input type="text" name="kota" value="{{ old('kota',$user->kota) }}"
             class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 transition" placeholder="Jember">
    </div>

    <div>
    <label class="block text-xs font-bold text-gray-600 mb-1.5">
        Warna Header Profil
    </label>

    <input
        type="color"
        name="header_color"
        value="{{ old('header_color',$user->header_color ?? '#6366f1') }}"
        class="w-20 h-12">
</div>
    @if($errors->any())
    <div class="bg-red-50 text-red-600 text-xs rounded-xl p-3">
      @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
    </div>
    @endif
    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-xl font-bold text-sm transition shadow-sm">Simpan Perubahan</button>
  </form>

  <div class="p-4 border border-purple-100 rounded-2xl">
    <h3 class="font-bold text-sm text-gray-900 mb-1">Mode Tampil</h3>
    <p class="text-xs text-gray-400 mb-3">Mode saat ini: <strong class="text-purple-600">{{ ucfirst($user->mode) }}</strong></p>
    <form action="{{ route('profile.mode') }}" method="POST">
      @csrf
      <input type="hidden" name="mode" value="{{ $user->mode==='publik' ? 'anonim' : 'publik' }}">
      <button class="text-sm border border-gray-200 hover:bg-gray-50 text-gray-600 px-4 py-2 rounded-xl transition font-medium">
        Ganti ke {{ $user->mode==='publik' ? 'Anonim 🕵️' : 'Publik 👤' }}
      </button>
    </form>
  </div>

  <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button class="w-full text-sm text-red-400 hover:text-red-600 border border-red-100 hover:border-red-300 py-2.5 rounded-xl transition font-semibold">Keluar dari Srawung</button>
  </form>
</div>
@push('scripts')
<script>function prevAv(i){if(i.files&&i.files[0])document.getElementById('av-preview').src=URL.createObjectURL(i.files[0]);}</script>
@endpush
@endsection

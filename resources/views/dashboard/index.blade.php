@extends('layouts.app')
@section('title','Beranda — Srawung')

@section('content')

{{-- Welcome Banner --}}

<div class="p-4">
    <div class="rounded-3xl overflow-hidden shadow-lg">


    <div class="bg-gradient-to-r from-violet-600 via-purple-500 to-fuchsia-500 p-6 text-white">

        <div class="flex items-center justify-between">

            <div>
                <h1 class="text-2xl font-black">
                    Halo, {{ auth()->user()->name }} 👋
                </h1>

                <p class="text-purple-100 mt-2">
                    Selamat datang di Srawung. Temukan cerita, teman, komunitas, dan rekomendasi terbaik di Jember.
                </p>
            </div>

            <div class="hidden md:block text-6xl opacity-20">
                🚀
            </div>

        </div>

    </div>

</div>


</div>

{{-- Tab Navigation --}}

<div class="sticky top-0 bg-white/95 backdrop-blur border-b border-purple-100 z-10">
    <div class="flex px-4 pt-3 gap-1">


    <a href="{{ route('dashboard') }}"
       class="text-sm font-bold pb-3 px-3 border-b-2 transition {{ $tab==='untukmu' ? 'border-purple-500 text-purple-700' : 'border-transparent text-gray-400 hover:text-gray-700' }}">
        Untuk Kamu
    </a>

    <a href="{{ route('dashboard',['tab'=>'following']) }}"
       class="text-sm font-bold pb-3 px-3 border-b-2 transition {{ $tab==='following' ? 'border-purple-500 text-purple-700' : 'border-transparent text-gray-400 hover:text-gray-700' }}">
        Following
    </a>

</div>


</div>

{{-- Compose Box --}}

<div class="px-4 py-4 border-b border-purple-50 flex gap-3">


<img
    src="{{ auth()->user()->avatarSrc() }}"
    class="w-10 h-10 rounded-xl object-cover flex-shrink-0 shadow-sm"
    alt="">

<a href="{{ route('post.create') }}"
   class="flex-1 bg-purple-50 border border-purple-100 rounded-2xl px-4 py-3 text-sm text-gray-400 hover:border-purple-300 hover:bg-purple-100 transition cursor-pointer font-medium">
    Ada cerita dari Jember hari ini?
</a>


</div>

{{-- Feed --}}
@forelse($posts as $post)


@include('posts._card', ['post'=>$post])


@empty

<div class="text-center py-20 text-gray-300">


<div class="text-6xl mb-4">
    ✉️
</div>

<p class="font-bold text-gray-500 text-lg">
    Belum ada post
</p>

<p class="text-sm text-gray-400 mt-1">
    Jadilah orang pertama yang membagikan cerita hari ini.
</p>

<a href="{{ route('post.create') }}"
   class="inline-flex items-center mt-4 bg-gradient-to-r from-violet-600 to-fuchsia-500 text-white px-5 py-2 rounded-xl text-sm font-semibold shadow-md hover:shadow-lg transition">
    Buat Post Pertama →
</a>

</div>

@endforelse

{{-- Pagination --}}

<div class="px-4 py-5 mb-16 md:mb-0">
    {{ $posts->links() }}
</div>

@endsection

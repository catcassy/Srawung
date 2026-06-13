<article class="px-4 py-4 border-b border-purple-50 hover:bg-purple-50/40 transition-all duration-200">


@if($post->repost_of)
<div class="flex items-center gap-1.5 text-xs text-gray-400 mb-3 ml-12">
    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
    </svg>
    Repost dari {{ $post->original?->authorName() ?? 'post yang dihapus' }}
</div>
@endif

@if($post->is_local_thread)
<div class="flex items-center gap-1.5 text-xs font-bold text-purple-500 mb-3 ml-12">
    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
    </svg>

    Thread Lokal{{ $post->area_label ? ' · '.$post->area_label : '' }}
</div>
@endif

<div class="flex gap-3">

    {{-- Avatar --}}
    <div class="flex-shrink-0">

        @if($post->mode_post==='anonim')

        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-400 font-black shadow-sm">
            ?
        </div>

        @else

        <a href="{{ route('profil',$post->user) }}">
            <img
                src="{{ $post->user->avatarSrc() }}"
                class="w-11 h-11 rounded-2xl object-cover shadow-md hover:scale-105 transition"
                alt="">
        </a>

        @endif

    </div>

    {{-- Content --}}
    <div class="flex-1 min-w-0">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-2 mb-2">

            <div class="min-w-0">

                @if($post->mode_post==='publik')

                <a href="{{ route('profil',$post->user) }}"
                   class="font-bold text-sm text-gray-900 hover:text-purple-700 transition">

                    {{ $post->user->name }}

                </a>

                <span class="text-xs text-gray-400 ml-1">
                    · {{ $post->created_at->diffForHumans() }}
                </span>

                @else

                <span class="font-bold text-sm text-gray-500">
                    Anonim
                </span>

                <span class="ml-1 text-[10px] px-2 py-1 rounded-full bg-slate-100 text-slate-500">
                    🕵️ anonim
                </span>

                <span class="text-xs text-gray-400 ml-1">
                    · {{ $post->created_at->diffForHumans() }}
                </span>

                @endif

            </div>

            @if(auth()->id()===$post->user_id)

            <form action="{{ route('post.destroy',$post) }}"
                  method="POST"
                  onsubmit="return confirm('Hapus post?')">

                @csrf
                @method('DELETE')

                <button class="text-gray-300 hover:text-red-500 transition p-2 rounded-xl hover:bg-red-50">

                    <svg class="w-4 h-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>

                    </svg>

                </button>

            </form>

            @endif

        </div>

        {{-- Post Content --}}
        <a href="{{ route('post.show',$post) }}" class="block">

            <p class="text-[15px] text-gray-800 leading-relaxed whitespace-pre-line">
                {{ $post->content }}
            </p>

            @if($post->image)

            <div class="mt-3 rounded-2xl overflow-hidden border border-purple-100 shadow-sm">

                <img
                    src="{{ Storage::url($post->image) }}"
                    class="w-full max-h-[450px] object-cover hover:scale-[1.02] transition duration-300"
                    alt="">

            </div>

            @endif

        </a>

        {{-- Action Bar --}}
        <div class="flex items-center gap-6 mt-4">

            {{-- Comment --}}
            <a href="{{ route('post.show',$post) }}"
               class="flex items-center gap-1.5 text-xs text-gray-500 hover:text-purple-600 group transition">

                <span class="w-8 h-8 rounded-xl group-hover:bg-purple-100 flex items-center justify-center transition">

                    <svg class="w-4 h-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>

                    </svg>

                </span>

                {{ $post->comments->count() }}

            </a>

            {{-- Repost --}}
            <form action="{{ route('post.repost',$post) }}" method="POST">

                @csrf

                <button class="flex items-center gap-1.5 text-xs text-gray-500 hover:text-emerald-600 group transition">

                    <span class="w-8 h-8 rounded-xl group-hover:bg-emerald-100 flex items-center justify-center transition">

                        🔄

                    </span>

                    {{ $post->reposts->count() }}

                </button>

            </form>

            {{-- Like --}}
            <form action="{{ route('like.toggle',$post) }}" method="POST">

                @csrf

                <button class="flex items-center gap-1.5 text-xs transition {{ $post->isLikedBy(auth()->user()) ? 'text-rose-500' : 'text-gray-500 hover:text-rose-500' }}">

                    <span class="w-8 h-8 rounded-xl hover:bg-rose-100 flex items-center justify-center transition">

                        ❤️

                    </span>

                    {{ $post->likes->count() }}

                </button>

            </form>

        </div>

    </div>

</div>


</article>

@extends('layouts.app')
@section('title','Chat — Srawung')
@section('content')
<div class="sticky top-0 bg-white/95 backdrop-blur border-b border-purple-100 px-4 py-3 flex items-center gap-3 z-10">
  <a href="{{ route('pesan.index') }}" class="p-1.5 rounded-xl hover:bg-gray-100 transition">
    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
  </a>
  <a href="{{ route('profil',$user) }}" class="flex items-center gap-2.5">
    <img src="{{ $user->avatarSrc() }}" class="w-9 h-9 rounded-xl object-cover shadow-sm" alt="">
    <div>
      <div class="font-bold text-sm text-gray-900">{{ $user->name }}</div>
      <div class="text-xs text-gray-400">{{ $user->username }}</div>
    </div>
  </a>
</div>

<div class="flex flex-col gap-3 px-4 py-4 pb-24 md:pb-4 min-h-96" id="chat-area">
  @forelse($messages as $msg)
  @php $mine = $msg->sender_id===auth()->id(); @endphp
  <div class="flex {{ $mine ? 'justify-end' : 'justify-start' }} items-end gap-2">
    @if(!$mine)<img src="{{ $user->avatarSrc() }}" class="w-7 h-7 rounded-lg object-cover flex-shrink-0 mb-1" alt="">@endif
    <div class="max-w-xs xl:max-w-sm">
      <div class="px-4 py-2.5 rounded-2xl text-sm leading-relaxed shadow-sm
          {{ $mine ? 'bg-purple-600 text-white rounded-br-sm' : 'bg-gray-100 text-gray-900 rounded-bl-sm' }}">
        {{ $msg->body }}
      </div>
      <div class="text-xs mt-1 {{ $mine ? 'text-right' : 'text-left' }} text-gray-400 px-1">{{ $msg->created_at->format('H:i') }}</div>
    </div>
  </div>
  @empty
  <div class="flex flex-col items-center justify-center py-16 text-center">
    <img src="{{ $user->avatarSrc() }}" class="w-16 h-16 rounded-2xl object-cover mb-3 shadow-md" alt="">
    <p class="font-black text-gray-900">{{ $user->name }}</p>
    <p class="text-xs text-gray-400 mt-1">Mulai percakapan dengan {{ $user->name }}</p>
  </div>
  @endforelse
</div>

<div class="sticky bottom-14 md:bottom-0 bg-white border-t border-purple-100 px-4 py-3">
  <form action="{{ route('pesan.send',$user) }}" method="POST" class="flex items-end gap-2" id="msg-form">
    @csrf
    <div class="flex-1 bg-purple-50 border border-purple-100 rounded-2xl px-4 py-2.5 focus-within:ring-2 focus-within:ring-purple-300 transition">
      <textarea name="body" id="msg-inp" required maxlength="500" rows="1"
                class="w-full bg-transparent text-sm text-gray-900 placeholder-gray-300 outline-none resize-none leading-relaxed"
                placeholder="Tulis pesan..." onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();document.getElementById('msg-form').submit();}"></textarea>
    </div>
    <button type="submit" class="w-10 h-10 bg-purple-600 hover:bg-purple-700 text-white rounded-2xl flex items-center justify-center transition flex-shrink-0 shadow-sm">
      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
    </button>
  </form>
</div>
@push('scripts')
<script>
const ca=document.getElementById('chat-area');if(ca)ca.scrollTop=ca.scrollHeight;
const ta=document.getElementById('msg-inp');if(ta)ta.addEventListener('input',function(){this.style.height='auto';this.style.height=Math.min(this.scrollHeight,100)+'px';});
</script>
@endpush
@endsection

<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title><?php echo $__env->yieldContent('title','Srawung'); ?></title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
body{font-family:'Segoe UI',system-ui,-apple-system,sans-serif;background:#faf8ff}
.card{background:white;border-radius:16px;border:1px solid #ede9fe}
.card-hover:hover{background:#fdf6ff}
.no-scroll::-webkit-scrollbar{display:none}
.no-scroll{-ms-overflow-style:none;scrollbar-width:none}
.fade-up{animation:fadeUp .2s ease}
@keyframes fadeUp{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:none}}
.nav-link{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;transition:all .15s;font-size:14px;color:#6b7280}
.nav-link:hover{background:#f5f3ff;color:#7c3aed}
.nav-link.active{background:#ede9fe;color:#7c3aed;font-weight:600}
.btn-primary{background:#7c3aed;color:white;border-radius:12px;padding:10px 20px;font-weight:600;font-size:14px;transition:all .15s;display:flex;align-items:center;gap:8px}
.btn-primary:hover{background:#6d28d9}
.logo-hover{
    transition:all .3s ease;
}

.logo-hover:hover{
    transform:scale(1.05);
}
</style>
<?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="min-h-screen">

<div class="max-w-screen-xl mx-auto flex min-h-screen">

  
  <aside class="hidden md:flex flex-col w-16 lg:w-64 flex-shrink-0 sticky top-0 h-screen px-2 lg:px-4 py-5 border-r border-purple-100 bg-white overflow-y-auto no-scroll">

    
   <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-3 px-2 lg:px-3 mb-6">

    <img
        
src="<?php echo e(asset('images/srawung-logo.png')); ?>"
        alt="Srawung"
        class="w-12 h-12 object-contain flex-shrink-0">

    <div class="hidden lg:block">
        <div class="font-black text-gray-900 text-xl leading-none tracking-tight">
            Srawung
        </div>

        <div class="text-[11px] text-violet-500 font-semibold">
            Social Future Network
        </div>
    </div>

</a>
    
    <nav class="flex flex-col gap-1 flex-1">
      <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        <span class="hidden lg:block">Beranda</span>
      </a>
      <a href="<?php echo e(route('search')); ?>" class="nav-link <?php echo e(request()->routeIs('search') ? 'active' : ''); ?>">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <span class="hidden lg:block">Cari</span>
      </a>
      <a href="<?php echo e(route('lokal')); ?>" class="nav-link <?php echo e(request()->routeIs('lokal') ? 'active' : ''); ?>">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <span class="hidden lg:block">Thread Lokal</span>
      </a>
      <a href="<?php echo e(route('ketemu.index')); ?>" class="nav-link <?php echo e(request()->routeIs('ketemu.*') ? 'active' : ''); ?>">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <span class="hidden lg:block">Srawung Ketemu</span>
        <?php if(auth()->user()->pendingMeetups() > 0): ?>
        <span class="hidden lg:flex ml-auto w-5 h-5 rounded-full bg-orange-400 text-white text-xs items-center justify-center font-bold"><?php echo e(auth()->user()->pendingMeetups()); ?></span>
        <?php endif; ?>
      </a>
      <a href="<?php echo e(route('lokasi.index')); ?>" class="nav-link <?php echo e(request()->routeIs('lokasi.*') ? 'active' : ''); ?>">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
        <span class="hidden lg:block">Hidden Gem</span>
      </a>
      <a href="<?php echo e(route('pesan.index')); ?>" class="nav-link <?php echo e(request()->routeIs('pesan.*') ? 'active' : ''); ?>">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
        <span class="hidden lg:block">Pesan</span>
        <?php if(auth()->user()->unreadMessages() > 0): ?>
        <span class="hidden lg:flex ml-auto w-5 h-5 rounded-full bg-red-500 text-white text-xs items-center justify-center font-bold"><?php echo e(auth()->user()->unreadMessages()); ?></span>
        <?php endif; ?>
      </a>
      <a href="<?php echo e(route('profil', auth()->user())); ?>" class="nav-link <?php echo e(request()->routeIs('profil') && request()->route('user') && request()->route('user')->id === auth()->id() ? 'active' : ''); ?>">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        <span class="hidden lg:block">Profil</span>
      </a>

      <a href="<?php echo e(route('post.create')); ?>" class="btn-primary mt-3 justify-center lg:justify-start">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        <span class="hidden lg:block">Buat Post</span>
      </a>
    </nav>

    
    <div class="mt-auto pt-3 border-t border-purple-100">
      <a href="<?php echo e(route('profil', auth()->user())); ?>" class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-purple-50 transition">
        <img src="<?php echo e(auth()->user()->avatarSrc()); ?>" class="w-9 h-9 rounded-xl object-cover flex-shrink-0 shadow-sm" alt="">
        <div class="hidden lg:block min-w-0 flex-1">
          <div class="text-sm font-bold text-gray-900 truncate"><?php echo e(auth()->user()->name); ?></div>
          <div class="text-xs text-gray-400"><?php echo e(auth()->user()->username); ?></div>
        </div>
        <span class="hidden lg:block text-xs px-2 py-0.5 rounded-full <?php echo e(auth()->user()->mode==='anonim' ? 'bg-slate-100 text-slate-500' : 'bg-purple-100 text-purple-600'); ?>">
          <?php echo e(auth()->user()->mode); ?>

        </span>
      </a>
      <div class="hidden lg:flex justify-between px-2 pt-1">
        <a href="<?php echo e(route('profile.edit')); ?>" class="text-xs text-gray-400 hover:text-purple-600 transition">Pengaturan</a>
        <form action="<?php echo e(route('logout')); ?>" method="POST"><?php echo csrf_field(); ?>
          <button class="text-xs text-gray-400 hover:text-red-500 transition">Keluar</button>
        </form>
      </div>
    </div>
  </aside>

  
  <main class="flex-1 min-w-0 border-x border-purple-100 bg-white pb-16 md:pb-0">
    <?php if(session('success')): ?>
    <div class="bg-purple-50 border-b border-purple-100 text-purple-700 text-sm px-4 py-2.5 flex items-center gap-2 fade-up">
      <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
      <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>
    <?php if(session('info')): ?>
    <div class="bg-blue-50 border-b border-blue-100 text-blue-700 text-sm px-4 py-2.5">ℹ️ <?php echo e(session('info')); ?></div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
    <div class="bg-red-50 border-b border-red-100 text-red-600 text-sm px-4 py-2.5">
      <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div>• <?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
    <?php echo $__env->yieldContent('content'); ?>
  </main>

  
  <aside class="hidden xl:flex flex-col w-80 flex-shrink-0 px-4 py-5 sticky top-0 h-screen overflow-y-auto no-scroll gap-4">

    
    <form action="<?php echo e(route('search')); ?>" method="GET">
      <div class="relative">
        <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" name="q" placeholder="Cari pengguna atau topik…"
               class="w-full pl-10 pr-4 py-2.5 bg-purple-50 border border-purple-100 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-300 focus:bg-white transition placeholder-gray-300">
      </div>
    </form>

    
    <div class="card overflow-hidden">
      <div class="bg-gradient-to-br from-violet-600 to-purple-400 p-4 text-white">
        <div class="font-bold text-base mb-0.5">🤝 Srawung Ketemu</div>
        <p class="text-xs text-purple-100">Temukan warga yang lagi online di sekitarmu. Ajak ngopi!</p>
      </div>
      <div class="p-3">
        <a href="<?php echo e(route('ketemu.index')); ?>" class="block w-full text-center bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold py-2 rounded-lg transition">
          Lihat siapa yang ada di sekitar →
        </a>
      </div>
    </div>

    
    <div class="card p-4">
      <h3 class="font-bold text-gray-900 text-sm mb-3 flex items-center gap-1.5"><span>✨</span> Hidden Gem Terbaru</h3>
      <?php $__currentLoopData = \App\Models\Location::with('user')->latest()->take(4)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <a href="<?php echo e(route('lokasi.show', $loc)); ?>" class="flex items-center gap-3 py-2.5 border-b border-purple-50 last:border-0 hover:bg-purple-50 -mx-2 px-2 rounded-xl transition">
        <div class="w-10 h-10 rounded-xl overflow-hidden bg-purple-50 flex-shrink-0 flex items-center justify-center">
          <?php if($loc->foto): ?>
          <img src="<?php echo e(asset('storage/'.$loc->foto)); ?>" class="w-full h-full object-cover" alt="">
          <?php else: ?>
          <span class="text-lg"><?php echo e($loc->kategoriIcon()); ?></span>
          <?php endif; ?>
        </div>
        <div class="min-w-0 flex-1">
          <div class="text-xs font-bold text-gray-900 truncate"><?php echo e($loc->nama); ?></div>
          <div class="text-xs text-gray-400 truncate"><?php echo e($loc->alamat); ?></div>
        </div>
      </a>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <a href="<?php echo e(route('lokasi.index')); ?>" class="block text-xs text-purple-600 hover:underline mt-2 font-medium">Lihat semua →</a>
    </div>

    
    <div class="card p-4">
      <h3 class="font-bold text-gray-900 text-sm mb-3">Mungkin kamu kenal</h3>
      <?php $__currentLoopData = \App\Models\User::where('id','!=',auth()->id())->inRandomOrder()->take(4)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $su): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="flex items-center gap-2.5 py-2.5 border-b border-purple-50 last:border-0">
        <a href="<?php echo e(route('profil', $su)); ?>" class="flex-shrink-0">
          <img src="<?php echo e($su->avatarSrc()); ?>" class="w-9 h-9 rounded-xl object-cover hover:opacity-80 transition" alt="<?php echo e($su->name); ?>">
        </a>
        <div class="min-w-0 flex-1">
          <a href="<?php echo e(route('profil', $su)); ?>" class="block text-xs font-bold text-gray-900 hover:text-purple-700 transition truncate"><?php echo e($su->name); ?></a>
          <div class="text-xs text-gray-400"><?php echo e($su->username); ?></div>
        </div>
        <?php if(!auth()->user()->isFollowing($su)): ?>
        <form action="<?php echo e(route('follow.toggle', $su)); ?>" method="POST"><?php echo csrf_field(); ?>
          <button class="text-xs font-semibold text-purple-600 border border-purple-200 px-3 py-1 rounded-lg hover:bg-purple-50 transition whitespace-nowrap">Ikuti</button>
        </form>
        <?php else: ?>
        <span class="text-xs text-gray-400">Diikuti ✓</span>
        <?php endif; ?>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

  </aside>
</div>


<div class="md:hidden fixed top-0 left-0 right-0 bg-white border-b border-purple-100 z-50 flex items-center justify-between px-4 py-2.5">
  
  <div class="relative" id="mobile-profile-wrap">
    <button onclick="toggleMobileMenu()" class="flex items-center gap-2">
      <img src="<?php echo e(auth()->user()->avatarSrc()); ?>" class="w-8 h-8 rounded-xl object-cover shadow-sm" alt="">
    </button>
    
    <div id="mobile-menu" class="hidden absolute top-12 left-0 w-64 bg-white rounded-2xl shadow-xl border border-purple-100 z-50 overflow-hidden">
      <div class="px-4 py-3 border-b border-purple-50">
        <div class="font-bold text-gray-900"><?php echo e(auth()->user()->name); ?></div>
        <div class="text-xs text-gray-400"><?php echo e(auth()->user()->username); ?></div>
        <span class="text-xs px-2 py-0.5 rounded-full mt-1 inline-block <?php echo e(auth()->user()->mode==='anonim' ? 'bg-slate-100 text-slate-500' : 'bg-purple-100 text-purple-600'); ?>"><?php echo e(auth()->user()->mode); ?></span>
      </div>
      <nav class="py-1">
        <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-purple-50">
          <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg> Beranda
        </a>
        <a href="<?php echo e(route('profil', auth()->user())); ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-purple-50">
          <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg> Profil Saya
        </a>
        <a href="<?php echo e(route('ketemu.index')); ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-purple-50">
          <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Srawung Ketemu
        </a>
        <a href="<?php echo e(route('lokasi.index')); ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-purple-50">
          <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg> Hidden Gem
        </a>
        <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-purple-50">
          <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Pengaturan
        </a>
        <div class="border-t border-gray-100 mt-1">
          <form action="<?php echo e(route('logout')); ?>" method="POST" class="px-4 py-3"><?php echo csrf_field(); ?>
            <button class="flex items-center gap-3 text-sm text-red-500 w-full">
              <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg> Keluar
            </button>
          </form>
        </div>
      </nav>
    </div>
  </div>

  
 <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-2">

    <img
src="<?php echo e(asset('images/srawung-logo.png')); ?>"
class="logo-hover w-12 h-12 object-contain flex-shrink-0"
        alt="Srawung"
        class="w-8 h-8 object-contain">

    <span class="font-black text-gray-900 text-base">
        Srawung
    </span>

</a>

  
  <a href="<?php echo e(route('post.create')); ?>" class="w-8 h-8 rounded-xl bg-purple-600 flex items-center justify-center text-white">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
  </a>
</div>


<nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-purple-100 flex items-center justify-around px-1 py-2 z-50 shadow-lg">
  <a href="<?php echo e(route('dashboard')); ?>" class="flex flex-col items-center gap-0.5 p-1.5 <?php echo e(request()->routeIs('dashboard') ? 'text-purple-600' : 'text-gray-400'); ?>">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
    <span class="text-[10px]">Beranda</span>
  </a>
  <a href="<?php echo e(route('search')); ?>" class="flex flex-col items-center gap-0.5 p-1.5 <?php echo e(request()->routeIs('search') ? 'text-purple-600' : 'text-gray-400'); ?>">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    <span class="text-[10px]">Cari</span>
  </a>
  <a href="<?php echo e(route('lokal')); ?>" class="flex flex-col items-center gap-0.5 p-1.5 <?php echo e(request()->routeIs('lokal') ? 'text-purple-600' : 'text-gray-400'); ?>">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/></svg>
    <span class="text-[10px]">Lokal</span>
  </a>
  <a href="<?php echo e(route('pesan.index')); ?>" class="flex flex-col items-center gap-0.5 p-1.5 relative <?php echo e(request()->routeIs('pesan.*') ? 'text-purple-600' : 'text-gray-400'); ?>">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
    <?php if(auth()->user()->unreadMessages() > 0): ?>
    <span class="absolute top-0 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
    <?php endif; ?>
    <span class="text-[10px]">Pesan</span>
  </a>
  <a href="<?php echo e(route('ketemu.index')); ?>" class="flex flex-col items-center gap-0.5 p-1.5 relative <?php echo e(request()->routeIs('ketemu.*') ? 'text-purple-600' : 'text-gray-400'); ?>">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    <?php if(auth()->user()->pendingMeetups() > 0): ?>
    <span class="absolute top-0 right-0 w-2 h-2 bg-orange-400 rounded-full"></span>
    <?php endif; ?>
    <span class="text-[10px]">Ketemu</span>
  </a>
</nav>

<script>
function toggleMobileMenu() {
  const m = document.getElementById('mobile-menu');
  m.classList.toggle('hidden');
}
// Tutup menu jika klik di luar
document.addEventListener('click', function(e) {
  const wrap = document.getElementById('mobile-profile-wrap');
  if (wrap && !wrap.contains(e.target)) {
    document.getElementById('mobile-menu').classList.add('hidden');
  }
});
</script>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\srawungv3\resources\views/layouts/app.blade.php ENDPATH**/ ?>
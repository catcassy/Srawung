<?php $__env->startSection('title',$location->nama.' — Srawung'); ?>
<?php $__env->startSection('content'); ?>
<div class="sticky top-0 bg-white/95 backdrop-blur border-b border-purple-100 px-4 py-3 flex items-center gap-3 z-10">
  <a href="<?php echo e(route('lokasi.index')); ?>" class="p-1.5 rounded-xl hover:bg-gray-100 transition">
    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
  </a>
  <span class="font-black text-gray-900">Detail Lokasi</span>
</div>
<div class="relative h-52 bg-purple-50 overflow-hidden">
  <?php if($location->foto): ?>
  <img src="<?php echo e(asset('storage/'.$location->foto)); ?>" alt="<?php echo e($location->nama); ?>" class="w-full h-full object-cover">
  <?php else: ?>
  <div class="w-full h-full flex items-center justify-center text-6xl"><?php echo e($location->kategoriIcon()); ?></div>
  <?php endif; ?>
  <span class="absolute bottom-3 left-4 bg-white/90 text-xs font-bold px-3 py-1.5 rounded-xl text-gray-700"><?php echo e($location->kategoriIcon()); ?> <?php echo e(ucfirst($location->kategori)); ?></span>
</div>
<div class="px-4 py-5">
  <h2 class="text-xl font-black text-gray-900 mb-1"><?php echo e($location->nama); ?></h2>
  <p class="text-sm text-gray-500 flex items-center gap-1.5 mb-3">
    <svg class="w-4 h-4 text-purple-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/></svg>
    <?php echo e($location->alamat); ?>

  </p>
  <?php if($location->deskripsi): ?><p class="text-sm text-gray-700 leading-relaxed mb-4"><?php echo e($location->deskripsi); ?></p><?php endif; ?>

  <?php if($location->latitude && $location->longitude): ?>

<div class="mb-5">

    <h3 class="font-bold text-gray-900 mb-3">
        📍 Lokasi Tempat
    </h3>

    <iframe
    width="100%"
    height="280"
    style="border:0;border-radius:16px;"
    loading="lazy"
    src="https://www.openstreetmap.org/export/embed.html?bbox=<?php echo e($location->longitude - 0.01); ?>,<?php echo e($location->latitude - 0.01); ?>,<?php echo e($location->longitude + 0.01); ?>,<?php echo e($location->latitude + 0.01); ?>&layer=mapnik&marker=<?php echo e($location->latitude); ?>,<?php echo e($location->longitude); ?>">
</iframe>

    <a
        href="https://www.google.com/maps?q=<?php echo e($location->latitude); ?>,<?php echo e($location->longitude); ?>"
        target="_blank"
        class="mt-3 inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">

        📍 Buka di Google Maps

    </a>

</div>

<?php endif; ?>
  <div class="pt-4 border-t border-purple-50 flex items-center gap-2.5">
    <img src="<?php echo e($location->user->avatarSrc()); ?>" class="w-9 h-9 rounded-xl object-cover" alt="">
    <div>
      <span class="text-xs text-gray-400">Direkomendasikan oleh</span>
      <a href="<?php echo e(route('profil',$location->user)); ?>" class="block text-sm font-bold text-gray-900 hover:text-purple-700"><?php echo e($location->user->name); ?></a>
    </div>
    <span class="ml-auto text-xs text-gray-400"><?php echo e($location->created_at->diffForHumans()); ?></span>
  </div>
</div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\srawungv3\resources\views/locations/show.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title','Hidden Gem — Srawung'); ?>
<?php $__env->startSection('content'); ?>

<div class="sticky top-0 bg-white/95 backdrop-blur border-b border-purple-100 px-4 py-3 flex items-center justify-between z-10 md:top-0 top-14">
  <div>
    <h2 class="font-black text-gray-900">✨ Hidden Gem</h2>
    <p class="text-xs text-gray-400">Rekomendasi tempat dari warga Jember</p>
  </div>
  <a href="<?php echo e(route('lokasi.create')); ?>" class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition shadow-sm">+ Tambah</a>
</div>


<div class="flex gap-2 px-4 py-3 overflow-x-auto no-scroll border-b border-purple-50">
  <?php $__currentLoopData = ['semua'=>'Semua','kuliner'=>'🍜 Kuliner','wisata'=>'🌄 Wisata','kesehatan'=>'🏥 Kesehatan','pendidikan'=>'📚 Pendidikan','umum'=>'📍 Umum']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <a href="<?php echo e(route('lokasi.index', ['kategori'=>$val])); ?>"
     class="flex-shrink-0 text-xs font-semibold px-4 py-1.5 rounded-full border transition whitespace-nowrap
            <?php echo e($kategori===$val ? 'bg-purple-600 text-white border-purple-600 shadow-sm' : 'border-gray-200 text-gray-600 hover:border-purple-300 hover:text-purple-600'); ?>">
    <?php echo e($label); ?>

  </a>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php if($locations->isEmpty()): ?>
<div class="text-center py-20 text-gray-400">
  <div class="text-5xl mb-3">🗺️</div>
  <p class="font-medium text-gray-600">Belum ada lokasi<?php echo e($kategori!=='semua' ? ' kategori ini' : ''); ?></p>
  <a href="<?php echo e(route('lokasi.create')); ?>" class="text-purple-600 text-sm hover:underline mt-1 inline-block">Tambahkan yang pertama →</a>
</div>
<?php else: ?>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-0 divide-y divide-purple-50 sm:divide-y-0 sm:gap-4 sm:p-4">
  <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <a href="<?php echo e(route('lokasi.show', $loc)); ?>" class="group block sm:rounded-2xl sm:border sm:border-purple-100 overflow-hidden hover:shadow-lg transition-shadow bg-white">
    <div class="relative h-40 bg-purple-50 overflow-hidden">
      <?php if($loc->foto): ?>
      <img src="<?php echo e(asset('storage/'.$loc->foto)); ?>" alt="<?php echo e($loc->nama); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
      <?php else: ?>
      <div class="w-full h-full flex items-center justify-center text-5xl bg-gradient-to-br from-purple-50 to-violet-100"><?php echo e($loc->kategoriIcon()); ?></div>
      <?php endif; ?>
      <span class="absolute top-2 right-2 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded-lg text-gray-700 shadow-sm"><?php echo e($loc->kategoriIcon()); ?> <?php echo e(ucfirst($loc->kategori)); ?></span>
    </div>
    <div class="px-4 py-3 sm:px-3">
      <h3 class="font-bold text-sm text-gray-900 group-hover:text-purple-700 transition mb-0.5"><?php echo e($loc->nama); ?></h3>
      <p class="text-xs text-gray-400 flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/></svg><?php echo e($loc->alamat); ?></p>
      <?php if($loc->deskripsi): ?><p class="text-xs text-gray-500 mt-1 line-clamp-2"><?php echo e($loc->deskripsi); ?></p><?php endif; ?>
      <p class="text-xs text-gray-300 mt-2">oleh <?php echo e($loc->user->name); ?></p>
    </div>
  </a>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<div class="px-4 py-4 mb-16 md:mb-0"><?php echo e($locations->links()); ?></div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\srawungv3\resources\views/locations/index.blade.php ENDPATH**/ ?>
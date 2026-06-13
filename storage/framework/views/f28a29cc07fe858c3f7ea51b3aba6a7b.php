<?php $__env->startSection('title','Tambah Hidden Gem — Srawung'); ?>
<?php $__env->startSection('content'); ?>
<div class="sticky top-0 bg-white/95 backdrop-blur border-b border-purple-100 px-4 py-3 flex items-center gap-3 z-10">
  <a href="<?php echo e(route('lokasi.index')); ?>" class="p-1.5 rounded-xl hover:bg-gray-100 transition">
    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
  </a>
  <span class="font-black text-gray-900">Tambah Hidden Gem</span>
</div>
<div class="max-w-lg mx-auto px-4 py-6">
  <form action="<?php echo e(route('lokasi.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
    <?php echo csrf_field(); ?>
    <div>
      <label class="block text-xs font-bold text-gray-600 mb-1.5">Foto Tempat</label>
      <label class="block cursor-pointer">
        <div id="foto-ph" class="w-full h-44 bg-purple-50 border-2 border-dashed border-purple-200 rounded-2xl flex flex-col items-center justify-center hover:border-purple-400 hover:bg-purple-50 transition">
          <svg class="w-8 h-8 text-purple-200 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          <span class="text-sm font-semibold text-purple-400">Klik untuk upload foto</span>
          <span class="text-xs text-gray-300 mt-1">JPG/PNG — maks 4MB</span>
        </div>
        <img id="foto-prev" src="" alt="" class="hidden w-full h-44 object-cover rounded-2xl border border-purple-100">
        <input type="file" name="foto" accept="image/*" class="hidden" onchange="prevFoto(this)">
      </label>
    </div>
    <div>
      <label class="block text-xs font-bold text-gray-600 mb-1.5">Nama Tempat *</label>
      <input type="text" name="nama" value="<?php echo e(old('nama')); ?>" required maxlength="100"
             class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 transition" placeholder="cth: Warung Kopi Pak Bejo">
    </div>
    <div>
      <label class="block text-xs font-bold text-gray-600 mb-1.5">Kategori *</label>
      <select name="kategori" class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 transition bg-white">
        <option value="kuliner">🍜 Kuliner</option>
        <option value="wisata">🌄 Wisata</option>
        <option value="kesehatan">🏥 Kesehatan</option>
        <option value="pendidikan">📚 Pendidikan</option>
        <option value="umum">📍 Umum</option>
      </select>
    </div>
    <div>
      <label class="block text-xs font-bold text-gray-600 mb-1.5">Alamat Lengkap *</label>
      <input type="text" name="alamat" value="<?php echo e(old('alamat')); ?>" required maxlength="200"
             class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 transition" placeholder="Jl. Ahmad Yani No. 10, Jember">
    </div>
    <div>
      <label class="block text-xs font-bold text-gray-600 mb-1.5">Deskripsi</label>
      <textarea name="deskripsi" rows="3" maxlength="600"
                class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 transition resize-none"
                placeholder="Ceritakan kenapa tempat ini istimewa..."><?php echo e(old('deskripsi')); ?></textarea>
    </div>
    <?php if($errors->any()): ?>
    <div class="bg-red-50 text-red-600 text-xs rounded-xl p-3">
      <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div>• <?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <div>
    <label class="block text-xs font-bold text-gray-600 mb-1.5">
        Lokasi Tempat
    </label>

    <button
        type="button"
        onclick="ambilLokasi()"
        class="w-full border border-purple-300 text-purple-600 py-2 rounded-xl hover:bg-purple-50">

        📍 Ambil Lokasi Saya

    </button>

    <p id="lokasi-text" class="text-xs text-gray-500 mt-2">
        Belum ada lokasi dipilih
    </p>

    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">
</div>
    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-xl font-bold text-sm transition shadow-sm">Simpan Hidden Gem ✨</button>
  </form>
</div>
<?php $__env->startPush('scripts'); ?>
<script>

function prevFoto(i)
{
    if(i.files && i.files[0])
    {
        document.getElementById('foto-prev').src =
            URL.createObjectURL(i.files[0]);

        document.getElementById('foto-prev')
            .classList.remove('hidden');

        document.getElementById('foto-ph')
            .classList.add('hidden');
    }
}

function ambilLokasi()
{
     if(!navigator.geolocation)
    {
        alert('Browser tidak mendukung GPS');
        return;
    }

    navigator.geolocation.getCurrentPosition(

        function(position)
        {
            let lat = position.coords.latitude;
            let lng = position.coords.longitude;

            console.log('Latitude:', lat);
            console.log('Longitude:', lng);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            document.getElementById('lokasi-text').innerHTML =
                "✅ Lokasi berhasil diambil<br>" +
                lat + ", " + lng;
        },

        function(error)
        {
            console.log(error);

            alert(
                'Gagal mengambil lokasi. Pastikan browser mengizinkan akses lokasi.'
            );
        }

    );
}

</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\srawungv3\resources\views/locations/create.blade.php ENDPATH**/ ?>
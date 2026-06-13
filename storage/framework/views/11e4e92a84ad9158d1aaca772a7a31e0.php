<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Masuk — Srawung</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>body{font-family:'Segoe UI',system-ui,sans-serif;background:#faf8ff}</style>
</head>
<body class="min-h-screen flex items-center justify-center px-4 py-10">
<div class="w-full max-w-sm">
  <div class="text-center mb-8">
    <a href="<?php echo e(route('landing')); ?>" class="inline-flex flex-col items-center gap-1">
      <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-violet-600 to-purple-400 flex items-center justify-center text-white font-black text-lg shadow-lg">S</div>
      <span class="font-black text-gray-900 text-xl">Srawung</span>
      <span class="text-xs text-purple-400">Komunitas Jember</span>
    </a>
    <h2 class="text-xl font-black text-gray-900 mt-4">Selamat datang kembali!</h2>
    <p class="text-sm text-gray-400 mt-1">Masuk dan srawung bareng warga Jember</p>
  </div>

  <div class="bg-white rounded-2xl shadow-sm border border-purple-100 p-6">
    <a href="<?php echo e(route('auth.google')); ?>"
       class="flex items-center justify-center gap-2.5 w-full border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold text-sm py-2.5 rounded-xl transition mb-4 shadow-sm">
      <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
      Masuk dengan Google
    </a>
    <div class="flex items-center gap-3 mb-4"><div class="flex-1 h-px bg-gray-100"></div><span class="text-xs text-gray-300">atau</span><div class="flex-1 h-px bg-gray-100"></div></div>

    <?php if($errors->any()): ?>
    <div class="bg-red-50 text-red-600 text-xs rounded-xl p-3 mb-4">
      <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div>• <?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <form action="<?php echo e(route('login')); ?>" method="POST" class="space-y-3">
      <?php echo csrf_field(); ?>
      <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1">Email</label>
        <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
               class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 transition"
               placeholder="nama@email.com">
      </div>
      <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1">Password</label>
        <input type="password" name="password" required
               class="w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400 transition"
               placeholder="••••••">
      </div>
      <label class="flex items-center gap-2 cursor-pointer">
        <input type="checkbox" name="remember" class="rounded accent-purple-600">
        <span class="text-xs text-gray-500">Ingat saya</span>
      </label>
      <button type="submit"
              class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 rounded-xl text-sm transition shadow-sm hover:shadow-purple-200">
        Masuk ke Srawung
      </button>
    </form>
  </div>
  <p class="text-center text-sm text-gray-400 mt-5">
    Belum punya akun? <a href="<?php echo e(route('register')); ?>" class="text-purple-600 font-bold hover:underline">Daftar gratis</a>
  </p>
</div>
</body>
</html>
<?php /**PATH C:\laragon\www\srawungv3\resources\views/auth/login.blade.php ENDPATH**/ ?>
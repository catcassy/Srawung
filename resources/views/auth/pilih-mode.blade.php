<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Pilih Mode — Srawung</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>body{font-family:'Segoe UI',system-ui,sans-serif;background:#faf8ff}</style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">
<div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-purple-100 p-8 text-center">
  <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-600 to-purple-400 flex items-center justify-center text-white font-black text-xl mx-auto mb-4 shadow-lg">S</div>
  <h2 class="text-2xl font-black text-gray-900 mb-1">Halo, {{ auth()->user()->name }}! 👋</h2>
  <p class="text-gray-400 text-sm mb-7">Pilih cara kamu tampil di Srawung. Bisa diganti kapan saja.</p>
  <form action="{{ route('pilih.mode.set') }}" method="POST">
    @csrf
    <div class="grid grid-cols-2 gap-3 mb-6">
      <label class="cursor-pointer">
        <input type="radio" name="mode" value="publik" class="sr-only peer" checked>
        <div class="border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 rounded-2xl p-5 transition-all text-left">
          <div class="text-3xl mb-2">👤</div>
          <div class="font-bold text-sm text-gray-900 mb-1">Publik</div>
          <div class="text-xs text-gray-400 leading-relaxed">Nama & profilmu terlihat. Bisa follow, DM, dan Srawung Ketemu.</div>
        </div>
      </label>
      <label class="cursor-pointer">
        <input type="radio" name="mode" value="anonim" class="sr-only peer">
        <div class="border-2 border-gray-200 peer-checked:border-gray-400 peer-checked:bg-gray-50 rounded-2xl p-5 transition-all text-left">
          <div class="text-3xl mb-2">🕵️</div>
          <div class="font-bold text-sm text-gray-900 mb-1">Anonim</div>
          <div class="text-xs text-gray-400 leading-relaxed">Post tanpa nama. Tidak tampil di profil. Privasi terjaga.</div>
        </div>
      </label>
    </div>
    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-xl font-bold text-sm transition shadow-sm">
      Masuk ke Srawung →
    </button>
  </form>
</div>
</body>
</html>

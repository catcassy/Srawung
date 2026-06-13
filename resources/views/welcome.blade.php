<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Srawung — Komunitas Lokal Jember</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #faf8ff; }
        .glow { background: radial-gradient(ellipse 80% 50% at 50% 0%, rgba(124,58,237,.12), transparent); }
    </style>
</head>
<body class="min-h-screen glow">
<header class="max-w-5xl mx-auto px-6 py-5 flex justify-between items-center">
    <div class="flex items-center gap-2.5">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-600 to-purple-400 flex items-center justify-center text-white font-black text-sm shadow-md">S</div>
        <div>
            <div class="font-black text-gray-900 text-lg leading-none">Srawung</div>
            <div class="text-xs text-purple-400">Komunitas Jember</div>
        </div>
    </div>
    <div class="flex gap-3 items-center">
        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-purple-700 px-4 py-2 transition">Masuk</a>
        <a href="{{ route('register') }}" class="text-sm font-bold bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-xl transition shadow-sm">Daftar Gratis</a>
    </div>
</header>

<main class="max-w-5xl mx-auto px-6 py-12 flex flex-col lg:flex-row gap-14 items-center">
    <div class="flex-1 text-center lg:text-left">
        <div class="inline-flex items-center gap-2 bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1.5 rounded-full mb-5">
            <span class="w-1.5 h-1.5 bg-purple-500 rounded-full pulse-dot" style="animation:pulse 2s infinite"></span>
            Platform #1 komunitas lokal Jember
        </div>
        <h1 class="text-5xl lg:text-6xl font-black text-gray-900 mb-4 leading-tight">
            Ngobrol,<br>
            <span style="background:linear-gradient(135deg,#7c3aed,#a855f7);-webkit-background-clip:text;-webkit-text-fill-color:transparent">Terhubung</span>,<br>
            Ketemu.
        </h1>
        <p class="text-gray-500 text-lg mb-8 max-w-md mx-auto lg:mx-0">Platform komunitas warga Jember. Berbagi cerita, temukan hidden gem, dan <strong>ketemu langsung</strong> dengan warga sekitar.</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
            <a href="{{ route('register') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold px-8 py-3.5 rounded-xl text-sm transition shadow-lg hover:shadow-purple-200 hover:-translate-y-0.5">
                Mulai Srawung — Gratis
            </a>
            <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-2.5 border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-semibold px-6 py-3.5 rounded-xl text-sm transition shadow-sm">
                <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                Lanjut dengan Google
            </a>
        </div>
    </div>
    <div class="flex-1 grid grid-cols-2 gap-3 max-w-sm w-full">
        @foreach([
            ['🤝','Srawung Ketemu','Ajak ngopi warga yang lagi online di sekitarmu — fitur unik yang hanya ada di Srawung!','from-orange-400 to-amber-300'],
            ['📍','Thread Lokal','Post yang hanya bisa dibaca warga di area yang sama — cerita tetap di komunitas lokal','from-violet-500 to-purple-400'],
            ['🕵️','Mode Anonim','Berbagi tanpa identitas. Post anonim tidak muncul di profilmu.','from-slate-500 to-gray-400'],
            ['✨','Hidden Gem','Temukan tempat tersembunyi di Jember yang direkomendasikan warga asli.','from-yellow-400 to-orange-300'],
        ] as [$icon,$title,$desc,$grad])
        <div class="bg-white rounded-2xl p-4 border border-purple-100 shadow-sm hover:shadow-md transition">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $grad }} flex items-center justify-center text-xl mb-2.5 shadow-sm">{{ $icon }}</div>
            <div class="font-bold text-sm text-gray-900 mb-1">{{ $title }}</div>
            <div class="text-xs text-gray-500 leading-relaxed">{{ $desc }}</div>
        </div>
        @endforeach
    </div>
</main>
<footer class="text-center text-xs text-gray-300 py-6">© 2024 Srawung · Dibuat untuk warga Jember</footer>
<style>
@keyframes pulse { 0%,100%{opacity:1}50%{opacity:.4} }
</style>
</body>
</html>

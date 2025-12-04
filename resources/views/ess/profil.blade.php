<!DOCTYPE html>
<html lang="en">

<head>
    <title>ESS | Profil</title>
    @include('ess.layout.head')

    <style>
        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .animate-marquee {
            display: inline-block;
            animation: marquee 15s linear infinite;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans w-full md:max-w-sm mx-auto">

    <!-- HEADER -->
    <div class="bg-sky-800 p-5 rounded-b-3xl shadow-md">
        <div class="flex justify-between items-center">
            <div class="space-y-4">
                <div>
                    <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                        <i class="fas fa-building text-white"></i>
                        {{ $employee->compani->company }}
                    </h1>
                </div>
                <div>
                    <p class="text-lg text-white/80">Hi, {{ auth()->user()->name }}</p>
                    <p class="text-sm text-white/80">{{ auth()->user()->position }}</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="bg-white p-2 rounded-lg shadow hover:bg-gray-100 transition">
                    <i class="material-icons text-black rotate-180">logout</i>
                </button>
            </form>
        </div>
    </div>

    <!-- ANNOUNCEMENT -->

    <div class="p-2">
        <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 rounded-xl p-3 shadow-sm overflow-hidden">
            <div class="animate-marquee whitespace-nowrap text-sm font-semibold">
                📢 Pengumuman: Gajian bulan Desember akan dipercepat menjadi tanggal 27.
                • Libur Natal dimulai tanggal 24–26 Desember.
                • Meeting bulanan akan diadakan tanggal 15 pukul 09.00 WIB.
                • Mohon lengkapi approval lembur sebelum tanggal 10.
            </div>
        </div>
    </div>

    <!-- PROFIL -->
    <div class="p-2">
        <!-- Back Button -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-5">
            <!-- Table Section -->
            <h2 class="text-lg font-bold text-gray-800 mb-3">Profil</h2>
            <div class="overflow-auto">

            </div>
        </div>
    </div>

    <!-- BOTTOM BAR -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg md:max-w-sm mx-auto">
        <div class="grid grid-cols-3 text-center py-2">

            <!-- Home -->
            <a href="{{ route('ess-home') }}"
                class="flex flex-col items-center {{ request()->routeIs('ess-home') ? 'text-sky-600' : 'text-gray-600 hover:text-sky-600' }}">
                <i class="fas fa-home text-xl"></i>
                <span class="text-xs font-semibold mt-1">Home</span>
            </a>

            <!-- Attendance (ACTIVE) -->
            <a href="{{ route('ess-absen') }}"
                class="flex flex-col items-center {{ request()->routeIs('ess-absen') ? 'text-sky-600' : 'text-gray-600 hover:text-sky-600' }}">
                <i class="fas fa-fingerprint text-xl"></i>
                <span class="text-xs font-semibold mt-1">Absen</span>
            </a>

            <!-- Profile -->
            <a href="{{ route('ess-profil') }}"
                class="flex flex-col items-center {{ request()->routeIs('ess-profil') ? 'text-sky-600' : 'text-gray-600 hover:text-sky-600' }}">
                <i class="fas fa-user text-xl"></i>
                <span class="text-xs font-semibold mt-1">Profile</span>
            </a>

        </div>
    </div>

</body>

</html>

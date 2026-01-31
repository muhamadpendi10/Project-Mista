<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    {{-- ================= SIDEBAR ================= --}}
    <aside class="w-64 bg-gradient-to-b from-blue-600 to-green-500
                  text-white flex flex-col">

        <div class="h-16 flex items-center px-6 border-b border-white/20">
            <span class="text-lg font-bold tracking-wide">
                MISTA
            </span>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
            <a href="#"
               class="block rounded-md px-4 py-2 bg-white/20">
                Dashboard
            </a>

            @if (auth()->user()->role === 'admin')
                <a href="/admin/devices?status=pending"
                   class="block rounded-md px-4 py-2 hover:bg-white/10 transition">
                    Device Management
                </a>
            @endif

            <a href="#"
               class="block rounded-md px-4 py-2 hover:bg-white/10 transition">
                History Upload
            </a>

            <a href="/upload"
               class="block rounded-md px-4 py-2 hover:bg-white/10 transition">
                Upload Data
            </a>
        </nav>

        <div class="px-4 py-3 text-xs text-white/70 border-t border-white/20">
            Internal System
        </div>
    </aside>

    {{-- ================= MAIN ================= --}}
    <div class="flex-1 flex flex-col">

        {{-- ================= TOPBAR ================= --}}
        <header
            class="h-16 bg-gradient-to-r from-blue-600 to-green-500
                   text-white flex items-center justify-between
                   px-6 border-b border-white/20">

            <h1 class="text-base font-semibold">
                @yield('page-title', 'Dashboard')
            </h1>

            {{-- USER MENU --}}
            <div x-data="{ open: false }" class="relative">

                {{-- AVATAR --}}
                <button
                    @click="open = !open"
                    class="w-9 h-9 rounded-full bg-white/20
                           flex items-center justify-center
                           hover:bg-white/30 transition"
                >
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5"
                         fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5.121 17.804A13.937 13.937 0 0112 15
                                 c2.5 0 4.847.655 6.879 1.804
                                 M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </button>

                {{-- DROPDOWN --}}
                <div
                    x-show="open"
                    @click.outside="open = false"
                    x-transition
                    class="absolute right-0 mt-2 w-56
                           bg-white text-slate-700
                           rounded-xl shadow-lg overflow-hidden"
                >
                    {{-- USER INFO --}}
                    <div class="px-4 py-3 border-b">
                        <p class="text-sm font-semibold">
                            {{ auth()->user()->email }}
                        </p>
                        <p class="text-xs text-slate-500 capitalize">
                            {{ auth()->user()->role }}
                        </p>
                    </div>

                    {{-- LOGOUT BUTTON --}}
                    <form method="POST" action="/logout" class="p-3">
                        @csrf

                        {{-- OPTION 1 (DEFAULT) --}}
                        <button
                            type="submit"
                            class="w-full flex items-center justify-center gap-2
                                   bg-red-50 text-red-600
                                   border border-red-200
                                   rounded-lg py-2
                                   hover:bg-red-100 hover:text-red-700
                                   transition font-medium"
                        >
                            {{-- ICON LOGOUT --}}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-4 h-4"
                                 fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7
                                         m6 4v1a2 2 0 01-2 2H5
                                         a2 2 0 01-2-2V7
                                         a2 2 0 012-2h6a2 2 0 012 2v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        {{-- ================= CONTENT ================= --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>

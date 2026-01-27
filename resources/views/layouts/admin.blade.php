<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
    <body class="bg-slate-100">

        <div class="flex min-h-screen">

            {{-- SIDEBAR --}}
            <aside class="w-64 bg-slate-900 text-slate-100 flex flex-col">
                <div class="px-6 py-4 text-lg font-semibold border-b border-slate-700">
                    MISTA
                </div>

                <nav class="flex-1 px-4 py-4 space-y-2 text-sm">
                    <a href="#"
                    class="block rounded-md px-4 py-2 hover:bg-slate-700 transition">
                        Dashboard
                    </a>

                    @if (auth()->user()->role === 'admin')
                            <a href="/admin/devices?status=pending"
                                class="block rounded-md px-4 py-2 hover:bg-slate-700 transition">
                                    Device Management
                            </a>
                        </li>
                    @endif


                    <a href="#"
                        class="block rounded-md px-4 py-2 hover:bg-slate-700 transition">
                            History Upload
                    </a>

                    <a href="/upload"
                        class="block rounded-md px-4 py-2 hover:bg-slate-700 transition">
                            Upload Data
                    </a>

                </nav>
            </aside>

            {{-- MAIN CONTENT --}}
            <div class="flex-1 flex flex-col">

                {{-- TOPBAR --}}
                <header class="bg-white border-b px-6 py-4 flex justify-between items-center">
                    <h1 class="text-lg font-semibold text-slate-800">
                        @yield('page-title', 'Dashboard')
                    </h1>

                    <div class="text-sm text-slate-600">
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>

                    </div>
                </header>

                {{-- PAGE CONTENT --}}
                <main class="flex-1 p-6">
                    @yield('content')
                </main>

            </div>

        </div>

</body>
</html>

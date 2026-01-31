<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex bg-white">

    {{-- ===== FLOATING ALERT LOGIN ===== --}}
    @if ($errors->any() || session('success'))
        <div
            id="toast-alert"
            class="
                fixed top-8 left-1/2 -translate-x-1/2
                px-6 py-3 rounded-xl shadow-lg
                text-center font-medium
                opacity-0 -translate-y-4
                transition-all duration-500
                z-50
                {{ $errors->any()
                    ? 'bg-red-500 text-white'
                    : 'bg-gradient-to-r from-blue-600 to-green-500 text-white' }}
            "
        >
            {{ $errors->first() ?? session('success') }}
        </div>
    @endif
    {{-- =============================== --}}

    <!-- LEFT: BRANDING -->
    <div class="hidden md:flex w-1/2 bg-white items-center justify-center">
        <div class="text-center px-10">
            <img
                src="{{ asset('images/login.png') }}"
                alt="Company Logo"
                class="w-72 mx-auto mb-8"
            >

            <h1 class="text-2xl font-extrabold mb-2
                bg-gradient-to-r from-blue-500 to-green-500
                bg-clip-text text-transparent">
                Internal Data Processing System
            </h1>
        </div>
    </div>

    <!-- RIGHT: LOGIN FORM -->
    <div class="w-full md:w-1/2 flex items-center justify-center bg-white">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                Login Admin
            </h2>

            <form method="POST" action="/login" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Email"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Password"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-green-500
                           text-white py-2 rounded-lg font-semibold
                           hover:opacity-90 transition"
                >
                    Login
                </button>
            </form>

            <p class="text-center text-xs text-gray-400 mt-6">
                Internal System • Admin Only
            </p>
        </div>
    </div>

    {{-- ===== TOAST SCRIPT ===== --}}
    @if ($errors->any() || session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('toast-alert');
            if (!toast) return;

            setTimeout(() => {
                toast.classList.remove('opacity-0', '-translate-y-4');
                toast.classList.add('opacity-100', 'translate-y-0');
            }, 100);

            setTimeout(() => {
                toast.classList.add('opacity-0', '-translate-y-4');
            }, 3000);

            setTimeout(() => {
                toast.remove();
            }, 3500);
        });
    </script>
    @endif

</body>
</html>

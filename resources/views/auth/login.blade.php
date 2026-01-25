<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex">

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

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

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
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition"
                >
                    Login
                </button>
            </form>

            <p class="text-center text-xs text-gray-400 mt-6">
                Internal System • Admin Only
            </p>
        </div>
    </div>

</body>
</html>

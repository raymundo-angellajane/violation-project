<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violation App - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-lg w-96 border-t-8 border-maroon-700">
        <!-- App Title -->
        <h1 class="text-3xl font-bold text-center mb-2 text-maroon-700">Violation App</h1>
        <p class="text-center text-gray-600 mb-6">Login to your account</p>

        <!-- Error Message -->
        @if ($errors->any())
            <div class="mb-4 text-red-600 text-sm bg-red-100 p-2 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">Email</label>
                <input type="email" name="email" 
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-maroon-600" 
                       required>
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block mb-1 font-medium text-gray-700">Password</label>
                <input type="password" name="password" 
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-maroon-600" 
                       required>
            </div>

            <!-- Submit Button -->
            <button class="w-full bg-maroon-700 text-white py-2 rounded-lg hover:bg-maroon-800 transition font-semibold">
                Login
            </button>
        </form>
    </div>

    <style>
        /* Define custom maroon color */
        .text-maroon-700 { color: #800000; }
        .bg-maroon-700 { background-color: #800000; }
        .hover\:bg-maroon-800:hover { background-color: #660000; }
        .focus\:ring-maroon-600:focus { --tw-ring-color: #990000; }
        .border-maroon-700 { border-color: #800000; }
    </style>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Violation System') }}</title>

    {{-- ✅ Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- ✅ Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- ✅ Custom Tailwind Config (Optional) --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 700: '#7A0000' },
                    },
                    borderRadius: { '2xl': '1rem' }
                }
            }
        }
    </script>
</head>
<body class="bg-neutral-50 text-neutral-800 antialiased">

    {{-- Navbar --}}
    <nav class="bg-brand-700 text-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold">Violation System</a>

            <div class="flex gap-4 items-center">
                @if(session('user_role') === 'faculty')
                    <a href="{{ route('faculty.violations.index') }}" class="hover:underline">Violations</a>
                    <a href="{{ route('faculty.appeals.index') }}" class="hover:underline">Appeals</a>
                @elseif(session('user_role') === 'student')
                    <a href="{{ route('student.violations.index') }}" class="hover:underline">My Violations</a>
                @endif

                @if(session('user_id'))
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-sm">
                            Logout
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    <div class="max-w-7xl mx-auto px-6 mt-4">
        @if(session('success'))
            <div id="successMessage" class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 rounded-lg bg-red-100 border border-red-300 text-red-800 px-4 py-3">
                {{ $errors->first() }}
            </div>
        @endif
    </div>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-6 py-8">
        @yield('content')
    </main>

    {{-- Init Lucide --}}
    <script>
        lucide.createIcons();
    </script>
</body>
</html>

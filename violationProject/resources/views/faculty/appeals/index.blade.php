<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appeals List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <!-- Header -->
    <div class="max-w-6xl mx-auto px-6 py-6">
        <div class="flex items-center justify-between mb-4">
            <!-- Back Button -->
            <a href="{{ route('faculty.violations.index') }}" 
               class="inline-flex items-center gap-2 text-[#7A0000] hover:text-red-800 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                     viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                           d="M15 19l-7-7 7-7" />
                </svg>
                Back to Violations
            </a>

            <!-- Page Title -->
            <h2 class="text-3xl font-bold text-[#7A0000]">Appeals</h2>
        </div>

        @if(session('success'))
            <div class="mt-2 rounded-lg bg-green-100 border border-green-200 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <!-- Appeals Table -->
    <div class="max-w-6xl mx-auto px-6">
        <div class="overflow-hidden bg-white shadow-lg rounded-2xl border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#7A0000] text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wide">Appeal ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wide">Student</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold uppercase tracking-wide">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($appeals as $appeal)
                        @php
                            $studentAppeal = $appeal->studentAppeals->first();
                            $studentName = $studentAppeal && $studentAppeal->student
                                ? $studentAppeal->student->first_name . ' ' . $studentAppeal->student->last_name
                                : 'N/A';
                            $status = $studentAppeal->status ?? 'Pending';
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $appeal->appeal_id }}</td>
                            <td class="px-6 py-4">{{ $studentName }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $status === 'Approved' ? 'bg-green-100 text-green-700' :
                                       ($status === 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('faculty.appeals.review', $appeal->appeal_id) }}" 
                                   class="inline-block px-4 py-2 bg-[#7A0000] text-white rounded-lg shadow hover:bg-red-800 transition">
                                    Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">No appeals found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>

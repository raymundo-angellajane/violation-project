<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appeal Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <div class="max-w-2xl mx-auto px-6 py-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('faculty.appeals.index') }}" 
               class="inline-flex items-center gap-2 text-[#7A0000] hover:text-red-800 font-medium">
                <!-- Left arrow -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                     viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                           d="M15 19l-7-7 7-7" />
                </svg>
                Back to Appeals
            </a>
        </div>

        <!-- Card -->
        <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200">
            <h2 class="text-2xl font-bold text-[#7A0000] mb-4">Appeal #{{ $appeal->appeal_id }}</h2>

            @php
                $studentAppeal = $appeal->studentAppeals->first();
                $studentName = $studentAppeal && $studentAppeal->student
                    ? $studentAppeal->student->first_name . ' ' . $studentAppeal->student->last_name
                    : 'N/A';
                $status = $studentAppeal->status ?? 'Pending';
            @endphp

            <div class="space-y-3">
                <p><span class="font-semibold">Student:</span> {{ $studentName }}</p>
                <p><span class="font-semibold">Appeal Message:</span> 
                    {{ $appeal->appeal_text ?? 'No appeal text provided.' }}
                </p>
                <p><span class="font-semibold">Status:</span> 
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $status === 'Approved' ? 'bg-green-100 text-green-700' :
                           ($status === 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                        {{ $status }}
                    </span>
                </p>
            </div>
        </div>
    </div>

</body>
</html>

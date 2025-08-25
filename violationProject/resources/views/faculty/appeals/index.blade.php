@extends('layouts.app')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-6">Appeals List</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b">Appeal ID</th>
                    <th class="py-2 px-4 border-b">Student</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appeals as $appeal)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $appeal->id }}</td>
                    <td class="py-2 px-4 border-b">
                        {{ optional($appeal->studentAppeals->first()->student)->name ?? 'N/A' }}
                    </td>
                    <td class="py-2 px-4 border-b">
                        {{ $appeal->studentAppeals->first()->status ?? 'Pending' }}
                    </td>
                    <td class="py-2 px-4 border-b text-right">
                        <a href="{{ route('faculty.appeals.review', $appeal->id) }}" 
                           class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Review
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">No appeals found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

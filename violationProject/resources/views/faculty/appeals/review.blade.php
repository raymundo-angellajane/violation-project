@extends('layouts.app')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Review Appeal #{{ $appeal->appeal_id }}</h2>

    <div class="bg-white shadow rounded-lg p-4 mb-6">
        <p><strong>Student:</strong> 
            {{ optional($appeal->studentAppeals->first()->student)->name ?? 'N/A' }}
        </p>
        <p><strong>Appeal Text:</strong> {{ $appeal->text ?? 'No appeal text provided.' }}</p>
        <p><strong>Status:</strong> 
            {{ $appeal->studentAppeals->first()->status ?? 'Pending' }}
        </p>
    </div>

    <form action="{{ route('faculty.appeals.update', $appeal->appeal_id) }}" method="POST" class="flex gap-3">
        @csrf
        @method('PUT')

        <input type="hidden" name="status" id="status-input" value="">

        <button type="submit" onclick="document.getElementById('status-input').value='Approved'"
            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            Approve
        </button>
        <button type="submit" onclick="document.getElementById('status-input').value='Rejected'"
            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
            Reject
        </button>
    </form>
</div>
@endsection

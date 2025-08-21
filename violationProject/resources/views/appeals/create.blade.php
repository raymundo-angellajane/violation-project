@extends('layouts.app') {{-- or your main layout --}}

@section('content')
<div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-2xl shadow">
  <h2 class="text-xl font-bold mb-4">Submit Appeal</h2>
  <form action="{{ route('appeals.store') }}" method="POST">
    @csrf
    <input type="hidden" name="violation_id" value="{{ $violation->id }}">

    <label class="block mb-2 font-semibold">Violation:</label>
    <p class="mb-4">{{ $violation->type }} - {{ $violation->details }}</p>

    <label class="block mb-2 font-semibold" for="message">Appeal Message:</label>
    <textarea name="message" id="message" rows="5" class="w-full border rounded p-2" required></textarea>

    <div class="mt-4 text-right">
      <button type="submit" class="px-4 py-2 bg-brand-700 text-white rounded hover:bg-brand-800">Submit Appeal</button>
    </div>
  </form>
</div>
@endsection

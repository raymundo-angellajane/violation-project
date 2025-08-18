<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Violation</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-50 text-neutral-800">

  <div class="max-w-3xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold mb-8">Edit Violation</h1>

    <form action="{{ route('violations.update', $violation->id) }}" method="POST" class="bg-white p-8 rounded-2xl shadow">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-2 gap-6">
        {{-- Student No --}}
        <div>
          <label class="block text-sm font-semibold mb-1">Student No.</label>
          <input type="text" name="student_no" value="{{ old('student_no', $violation->student_no) }}" class="w-full border rounded-xl px-3 py-2" required>
          @error('student_no') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Name --}}
        <div>
          <label class="block text-sm font-semibold mb-1">Name</label>
          <input type="text" name="name" value="{{ old('name', $violation->name) }}" class="w-full border rounded-xl px-3 py-2" required>
          @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Course --}}
        <div>
          <label class="block text-sm font-semibold mb-1">Course</label>
          <input type="text" name="course" value="{{ old('course', $violation->course) }}" class="w-full border rounded-xl px-3 py-2" required>
          @error('course') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Year Level --}}
        <div>
          <label class="block text-sm font-semibold mb-1">Year Level</label>
          <input type="text" name="year_level" value="{{ old('year_level', $violation->year_level) }}" class="w-full border rounded-xl px-3 py-2" required>
          @error('year_level') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Type --}}
        <div>
          <label class="block text-sm font-semibold mb-1">Type</label>
          <select name="type" class="w-full border rounded-xl px-3 py-2" required>
            <option value="Minor" {{ old('type', $violation->type) == 'Minor' ? 'selected' : '' }}>Minor</option>
            <option value="Major" {{ old('type', $violation->type) == 'Major' ? 'selected' : '' }}>Major</option>
          </select>
          @error('type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Date --}}
        <div>
          <label class="block text-sm font-semibold mb-1">Date</label>
          <input type="date" name="date" value="{{ old('date', $violation->date) }}" class="w-full border rounded-xl px-3 py-2" required>
          @error('date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Details --}}
        <div class="col-span-2">
          <label class="block text-sm font-semibold mb-1">Details</label>
          <textarea name="details" rows="3" class="w-full border rounded-xl px-3 py-2">{{ old('details', $violation->details) }}</textarea>
          @error('details') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Penalty --}}
        <div>
          <label class="block text-sm font-semibold mb-1">Penalty</label>
          <input type="text" name="penalty" value="{{ old('penalty', $violation->penalty) }}" class="w-full border rounded-xl px-3 py-2" required>
          @error('penalty') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Status --}}
        <div>
          <label class="block text-sm font-semibold mb-1">Status</label>
          <select name="status" class="w-full border rounded-xl px-3 py-2">
            <option value="Pending" {{ old('status', $violation->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Settled" {{ old('status', $violation->status) == 'Settled' ? 'selected' : '' }}>Settled</option>
          </select>
          @error('status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="mt-8 flex gap-4">
        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl font-semibold">
          Update
        </button>
        <a href="{{ route('violations.index') }}" class="bg-neutral-200 hover:bg-neutral-300 text-neutral-800 px-6 py-2.5 rounded-xl font-semibold">
          Cancel
        </a>
      </div>
    </form>
  </div>

</body>
</html>

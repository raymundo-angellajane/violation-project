<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Violation</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-100 text-neutral-800">

  <div class="max-w-3xl mx-auto px-6 py-12">
    <h1 class="text-3xl font-extrabold mb-8 text-center text-[#7A0000]">Edit Violation</h1>

    <form action="{{ route('faculty.violations.update', $violation->violation_id) }}" method="POST" 
          class="bg-white p-8 rounded-2xl shadow-xl border border-neutral-200">
      @csrf
      @method('PUT')

      {{-- Grid Fields --}}
      <div class="grid grid-cols-2 gap-6">
        {{-- Student No --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Student No</label>
          <input type="text" name="student_no" 
                 value="{{ old('student_no', $violation->student->student_no ?? '') }}" 
                 class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" required>
          @error('student_no') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Course --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Course</label>
          <select name="course_id"
                  class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" 
                  required>
            @foreach($courses as $course)
              <option value="{{ $course->course_id }}" 
                {{ (old('course_id', $violation->course_id) == $course->course_id) ? 'selected' : '' }}>
                {{ $course->course_code }} - {{ $course->course_name }}
              </option>
            @endforeach
          </select>
          @error('course_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- First Name --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">First Name</label>
          <input type="text" name="first_name" 
                 value="{{ old('first_name', $violation->student->first_name ?? '') }}" 
                 class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" required>
          @error('first_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Last Name --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Last Name</label>
          <input type="text" name="last_name" 
                 value="{{ old('last_name', $violation->student->last_name ?? '') }}" 
                 class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" required>
          @error('last_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Year Level --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Year Level</label>
          <input type="text" name="year_level" 
                 value="{{ old('year_level', $violation->year_level) }}" 
                 class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" required>
          @error('year_level') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Type --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Violation Type</label>
          <select name="type" 
                  class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" required>
            <option value="Minor" {{ old('type', $violation->type) == 'Minor' ? 'selected' : '' }}>Minor</option>
            <option value="Major" {{ old('type', $violation->type) == 'Major' ? 'selected' : '' }}>Major</option>
          </select>
          @error('type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Date --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Date</label>
          <input type="date" name="violation_date" 
                 value="{{ old('violation_date', $violation->violation_date) }}" 
                 class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" required>
          @error('violation_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Details --}}
        <div class="col-span-2">
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Details</label>
          <textarea name="details" rows="3" 
                    class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]">{{ old('details', $violation->details) }}</textarea>
          @error('details') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Penalty --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Penalty</label>
          <input type="text" name="penalty" 
                 value="{{ old('penalty', $violation->penalty) }}" 
                 class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" required>
          @error('penalty') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Status --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Status</label>
          <select name="status"
                  class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]"
                  @if($violation->status == 'Cleared') disabled @endif>
              <option value="Pending" {{ old('status', $violation->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
              <option value="Disclosed" {{ old('status', $violation->status) == 'Disclosed' ? 'selected' : '' }}>Disclosed</option>
              <option value="Cleared" {{ old('status', $violation->status) == 'Cleared' ? 'selected' : '' }}>Cleared</option>
          </select>
          @if($violation->status == 'Cleared')
              <p class="text-sm text-green-600 mt-1">Status is locked because appeal was approved.</p>
          @endif
          @error('status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
      </div> {{-- END GRID --}}

      {{-- Buttons --}}
      <div class="mt-8 flex justify-center gap-4">
        <button type="submit" 
                class="bg-[#7A0000] hover:bg-[#600000] text-white px-6 py-2.5 rounded-xl font-semibold shadow-md">
          Update
        </button>
        <a href="{{ route('faculty.violations.index') }}" 
           class="bg-neutral-200 hover:bg-neutral-300 text-neutral-800 px-6 py-2.5 rounded-xl font-semibold shadow-md">
          Cancel
        </a>
      </div>
    </form>
  </div>

</body>
</html>

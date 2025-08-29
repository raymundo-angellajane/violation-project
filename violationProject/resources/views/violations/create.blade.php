<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Add Violation</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-100 text-neutral-800">

  <div class="max-w-3xl mx-auto px-6 py-12">
    <h1 class="text-3xl font-extrabold mb-8 text-center text-[#7A0000]">Add Violation</h1>

    <form action="{{ route('faculty.violations.store') }}" method="POST" 
          class="bg-white p-8 rounded-2xl shadow-xl border border-neutral-200">
      @csrf

      <div class="grid grid-cols-2 gap-6">

        {{-- Student Selection --}}
        <div class="col-span-2">
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Select Existing Student</label>
          <select id="student_select" name="student_id"
                  class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]">
            <option value="">-- Choose Student --</option>
            @foreach($students as $student)
              <option value="{{ $student->student_id }}"
                      data-first-name="{{ $student->first_name }}"
                      data-last-name="{{ $student->last_name }}"
                      data-student-no="{{ $student->student_no }}"
                      data-course="{{ $student->course_id }}"
                      data-year-level="{{ $student->year_level }}">
                {{ $student->student_no }} - {{ $student->first_name }} {{ $student->last_name }}
              </option>
            @endforeach
          </select>
          @error('student_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <p class="col-span-2 text-sm text-gray-500 mb-2">Or manually enter student info:</p>

        {{-- Manual Entry --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Student No</label>
          <input type="text" name="student_no" id="student_no" value="{{ old('student_no') }}" 
                 class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]">
          @error('student_no') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Course</label>
          <select name="course_id" id="course_id"
                  class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]">
            <option value="">-- Select Course --</option>
            @foreach($courses as $course)
              <option value="{{ $course->course_id }}" {{ old('course_id') == $course->course_id ? 'selected' : '' }}>
                {{ $course->course_name }}
              </option>
            @endforeach
          </select>
          @error('course_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">First Name</label>
          <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" 
                 class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]">
          @error('first_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Last Name</label>
          <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" 
                 class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]">
          @error('last_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Year Level</label>
          <input type="text" name="year_level" id="year_level" value="{{ old('year_level') }}" 
                 class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]">
          @error('year_level') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Violation Info --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Violation Type</label>
          <select name="type" class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]" required>
            <option value="Minor" {{ old('type') == 'Minor' ? 'selected' : '' }}>Minor</option>
            <option value="Major" {{ old('type') == 'Major' ? 'selected' : '' }}>Major</option>
          </select>
          @error('type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Date</label>
          <input type="date" name="violation_date" value="{{ old('violation_date') }}"
                 class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]" required>
          @error('violation_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="col-span-2">
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Details</label>
          <textarea name="details" rows="3" class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]">{{ old('details') }}</textarea>
          @error('details') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Penalty</label>
          <input type="text" name="penalty" value="{{ old('penalty') }}" 
                 class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]" required>
          @error('penalty') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Status</label>
          <select name="status" class="w-full border rounded-xl px-3 py-2">
            <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Disclosed" {{ old('status') == 'Disclosed' ? 'selected' : '' }}>Disclosed</option>
          </select>
          @error('status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

      </div>

      <div class="mt-8 flex justify-center gap-4">
        <button type="submit" class="bg-[#7A0000] hover:bg-[#600000] text-white px-6 py-2.5 rounded-xl font-semibold shadow-md">
          Save
        </button>
        <a href="{{ route('faculty.violations.index') }}" class="bg-neutral-200 hover:bg-neutral-300 text-neutral-800 px-6 py-2.5 rounded-xl font-semibold shadow-md">
          Cancel
        </a>
      </div>
    </form>
  </div>

  <script>
    const select = document.getElementById('student_select');
    select.addEventListener('change', function() {
      const option = this.options[this.selectedIndex];
      if (!option.value) return;

      document.getElementById('student_no').value   = option.getAttribute('data-student-no') || '';
      document.getElementById('first_name').value  = option.getAttribute('data-first-name') || '';
      document.getElementById('last_name').value   = option.getAttribute('data-last-name') || '';
      document.getElementById('course_id').value   = option.getAttribute('data-course') || '';
      document.getElementById('year_level').value  = option.getAttribute('data-year-level') || '';
    });
  </script>

</body>
</html>
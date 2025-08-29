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

    <form action="{{ route('faculty.violations.update', ['violation' => $violation->violation_id]) }}" method="POST"
          class="bg-white p-8 rounded-2xl shadow-xl border border-neutral-200">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-2 gap-6">

        {{-- Select Existing Student --}}
        <div class="col-span-2">
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Select Existing Student</label>
          <select id="student_select" name="student_id"
                  class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]" required>
            <option value="">-- Choose Student --</option>
            @foreach($students as $student)
              <option value="{{ $student->student_id }}"
                      data-first-name="{{ $student->first_name }}"
                      data-last-name="{{ $student->last_name }}"
                      data-student-no="{{ $student->student_no }}"
                      data-course="{{ $student->course_id }}"
                      data-year-level="{{ $student->year_level }}"
                      {{ old('student_id', $violation->student_id) == $student->student_id ? 'selected' : '' }}>
                {{ $student->student_no }} - {{ $student->first_name }} {{ $student->last_name }}
              </option>
            @endforeach
          </select>
        </div>

        <p class="col-span-2 text-sm text-gray-500 mb-2">Or manually edit student info:</p>

        {{-- Manual Student Info --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Student No</label>
          <input type="text" name="student_no" id="student_no" 
                 value="{{ old('student_no', $violation->student->student_no) }}" 
                 class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]">
        </div>

        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Course</label>
          <select name="course_id" id="course_id"
                  class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]">
            <option value="">-- Select Course --</option>
            @foreach($courses as $course)
              <option value="{{ $course->course_id }}" 
                      {{ old('course_id', $violation->course_id) == $course->course_id ? 'selected' : '' }}>
                {{ $course->course_name }}
              </option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">First Name</label>
          <input type="text" name="first_name" id="first_name" 
                 value="{{ old('first_name', $violation->student->first_name) }}" 
                 class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]">
        </div>

        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Last Name</label>
          <input type="text" name="last_name" id="last_name" 
                 value="{{ old('last_name', $violation->student->last_name) }}" 
                 class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]">
        </div>

        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Year Level</label>
          <input type="text" name="year_level" id="year_level" 
                 value="{{ old('year_level', $violation->student->year_level) }}" 
                 class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]">
        </div>

        {{-- Violation Info --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Violation Type</label>
          <select name="type" class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]" required>
            <option value="Minor" {{ old('type', $violation->type) == 'Minor' ? 'selected' : '' }}>Minor</option>
            <option value="Major" {{ old('type', $violation->type) == 'Major' ? 'selected' : '' }}>Major</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Violation Date</label>
          <input type="date" name="violation_date" 
                 value="{{ old('violation_date', $violation->violation_date) }}" 
                 class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]" required>
        </div>

        <div class="col-span-2">
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Details</label>
          <textarea name="details" rows="3" 
                    class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]">{{ old('details', $violation->details) }}</textarea>
        </div>

        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Penalty</label>
          <input type="text" name="penalty" 
                 value="{{ old('penalty', $violation->penalty) }}" 
                 class="w-full border rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000]" required>
        </div>

        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Status</label>
          <select name="status" class="w-full border rounded-xl px-3 py-2" 
                  @if($violation->status === 'Cleared') disabled @endif>
            <option value="Pending" {{ old('status', $violation->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Disclosed" {{ old('status', $violation->status) == 'Disclosed' ? 'selected' : '' }}>Disclosed</option>
            <option value="Cleared" {{ old('status', $violation->status) == 'Cleared' ? 'selected' : '' }}>Cleared</option>
          </select>
          @if($violation->status === 'Cleared')
            <p class="text-sm text-green-600 mt-1">Status is locked because appeal was approved.</p>
          @endif
        </div>

      </div>

      <div class="mt-8 flex justify-center gap-4">
        <button type="submit" class="bg-[#7A0000] hover:bg-[#600000] text-white px-6 py-2.5 rounded-xl font-semibold shadow-md">
          Update
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

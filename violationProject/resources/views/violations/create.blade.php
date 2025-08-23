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

    <form action="{{ route('violations.store') }}" method="POST" 
          class="bg-white p-8 rounded-2xl shadow-xl border border-neutral-200">
      @csrf

      <div class="grid grid-cols-2 gap-6">
        {{-- Student No --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Student No.</label>
          <input type="text" name="student_no" value="{{ old('student_no') }}" 
                 class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" required>
          @error('student_no') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- First Name --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">First Name</label>
          <input type="text" name="first_name" value="{{ old('first_name') }}" 
                 class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" required>
          @error('first_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Last Name --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Last Name</label>
          <input type="text" name="last_name" value="{{ old('last_name') }}" 
                 class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" required>
          @error('last_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Course --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Course</label>
          <input type="text" name="course_id" value="{{ old('course_id') }}" 
                 class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" required>
          @error('course_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Year Level --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Year Level</label>
          <input type="text" name="year_level" value="{{ old('year_level') }}" 
                 class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" required>
          @error('year_level') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Type --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Type</label>
          <select name="type" 
                  class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" required>
            <option value="Minor" {{ old('type')=='Minor' ? 'selected' : '' }}>Minor</option>
            <option value="Major" {{ old('type')=='Major' ? 'selected' : '' }}>Major</option>
          </select>
          @error('type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Date --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Date</label>
          <input type="date" name="violation_date" value="{{ old('violation_date') }}" 
                 class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" required>
          @error('violation_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Details --}}
        <div class="col-span-2">
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Details</label>
          <textarea name="details" rows="3" 
                    class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]">{{ old('details') }}</textarea>
          @error('details') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Penalty --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Penalty</label>
          <input type="text" name="penalty" value="{{ old('penalty') }}" 
                 class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]" required>
          @error('penalty') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Status --}}
        <div>
          <label class="block text-sm font-semibold text-[#7A0000] mb-1">Status</label>
          <select name="status" 
                  class="w-full border border-neutral-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-[#7A0000] focus:border-[#7A0000]">
            <option value="Pending" {{ old('status')=='Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Disclosed" {{ old('status')=='Disclosed' ? 'selected' : '' }}>Disclosed</option>
          </select>
          @error('status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="mt-8 flex justify-center gap-4">
        <button type="submit" 
                class="bg-[#7A0000] hover:bg-[#600000] text-white px-6 py-2.5 rounded-xl font-semibold shadow-md">
          Save
        </button>
        <a href="{{ route('violations.index') }}" 
           class="bg-neutral-200 hover:bg-neutral-300 text-neutral-800 px-6 py-2.5 rounded-xl font-semibold shadow-md">
          Cancel
        </a>
      </div>
    </form>
  </div>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Violation Entry</title>

  {{-- Tailwind CSS --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: { 700: '#7A0000' } // maroon header
          },
          borderRadius: { '2xl': '1rem' }
        }
      }
    }
  </script>
</head>

<body class="bg-neutral-50 text-neutral-800 antialiased">

  <div class="max-w-7xl mx-auto px-6 py-10">

    <!-- Title -->
    <h1 class="text-3xl font-bold tracking-tight mb-4">Violation Entry</h1>

    <!-- Controls: Search + Add + Export -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
      
      <!-- Search -->
      <div class="relative w-full sm:w-72">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l3.387 3.386a1 1 0 01-1.415 1.415l-3.386-3.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd"/>
          </svg>
        </span>
        <input type="text" id="searchInput" placeholder="Search Student No."
          class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-neutral-200 bg-white shadow focus:outline-none focus:ring-2 focus:ring-neutral-200" />
      </div>

      <!-- Buttons -->
      <div class="flex gap-3">
        <!-- Add Record -->
        <a href="{{ route('violations.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2.5 shadow transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
          </svg>
          Add Record
        </a>

        <!-- Export PDF -->
        <a href="{{ route('violations.exportPdf') }}"
          class="inline-flex items-center gap-2 rounded-xl bg-neutral-700 hover:bg-neutral-800 text-white font-semibold px-4 py-2.5 shadow transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V8l-6-6H6z"/>
            <path d="M9 12h2v4H9v-4zm0-4h2v2H9V8z"/>
          </svg>
          Export PDF
        </a>
      </div>
    </div>

    <!-- Table -->
    <div class="rounded-2xl bg-white shadow overflow-hidden">
      <!-- Header -->
      <div class="bg-brand-700 text-white">
        <div class="grid grid-cols-12 gap-4 px-6 py-3 text-sm font-semibold">
          <div class="col-span-2">Student No.</div>
          <div class="col-span-2">Name</div>
          <div class="col-span-2">Course</div>
          <div>Year</div>
          <div>Type</div>
          <div>Details</div>
          <div>Date</div>
          <div>Penalty</div>
          <div>Status</div>
          <div>Actions</div>
        </div>
      </div>

      <!-- Body -->
      <div id="tableBody" class="divide-y divide-neutral-100">
        @forelse($violations as $row)
          <div class="grid grid-cols-12 gap-4 px-6 py-3 hover:bg-neutral-50 transition violation-row">
            <div class="col-span-2 font-medium student-no">{{ $row->student_no }}</div>
            <div class="col-span-2">{{ $row->name }}</div>
            <div class="col-span-2">{{ $row->course }}</div>
            <div>{{ $row->year_level }}</div>
            <div>{{ $row->type }}</div>
            <div class="truncate" title="{{ $row->details }}">{{ $row->details }}</div>
            <div>{{ \Carbon\Carbon::parse($row->date)->format('M d, Y') }}</div>
            <div>{{ $row->penalty }}</div>
            <div>
              <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                {{ strtolower($row->status) == 'pending'
                   ? 'bg-amber-100 text-amber-800'
                   : 'bg-emerald-100 text-emerald-800' }}">
                {{ $row->status }}
              </span>
            </div>
            <div class="flex gap-2">
              <a href="{{ route('violations.edit', $row->id) }}"
                 class="text-blue-600 hover:underline text-sm">Edit</a>

              <form action="{{ route('violations.destroy', $row->id) }}" method="POST"
                    onsubmit="return confirm('Delete this record?')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
              </form>
            </div>
          </div>
        @empty
          <div class="px-6 py-10 text-center text-neutral-500">No records found</div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- Search script -->
  <script>
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function () {
      const term = this.value.toLowerCase();
      document.querySelectorAll('.violation-row').forEach(row => {
        const studentNo = row.querySelector('.student-no').textContent.toLowerCase();
        row.style.display = studentNo.includes(term) ? '' : 'none';
      });
    });
  </script>

</body>
</html>

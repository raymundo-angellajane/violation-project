<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My Violations</title>

  {{-- Tailwind CSS --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: { 700: '#7A0000' }
          },
          borderRadius: { '2xl': '1rem' }
        }
      }
    }
  </script>
</head>

<body class="bg-neutral-50 text-neutral-800 antialiased">
  <div class="max-w-6xl mx-auto px-6 py-10">

    <!-- Student Info -->
    <div class="bg-white rounded-2xl shadow border border-neutral-200 p-6 mb-8">
      <h1 class="text-2xl font-bold text-brand-700 mb-4">My Violation Records</h1>
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
        <p><strong>Student No:</strong> {{ $student->student_no }}</p>
        <p><strong>Name:</strong> {{ $student->name }}</p>
        <p><strong>Course:</strong> {{ $student->course }}</p>
        <p><strong>Year:</strong> {{ $student->year_level }}</p>
      </div>
    </div>

    <!-- Search + Filter -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
      <!-- Search -->
      <div class="relative w-full sm:w-72">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l3.387 3.386a1 1 0 01-1.415 1.415l-3.386-3.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd"/>
          </svg>
        </span>
        <input type="text" id="searchInput" placeholder="Search by type or details"
          class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-neutral-200 bg-white shadow focus:outline-none focus:ring-2 focus:ring-neutral-200" />
      </div>

      <!-- Status Filter -->
      <form method="GET" action="{{ route('student.violations') }}" class="flex gap-2">
        <select name="status" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl border border-neutral-200 bg-white shadow focus:outline-none">
          <option value="">All Status</option>
          <option value="Pending" {{ $status == 'Pending' ? 'selected' : '' }}>Pending</option>
          <option value="Disclosed" {{ $status == 'Disclosed' ? 'selected' : '' }}>Disclosed</option>
        </select>
      </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-2xl bg-white shadow border border-neutral-200">
      <div class="min-w-[1000px]">
        <div class="bg-brand-700 text-white border-b border-neutral-200">
          <div class="grid grid-cols-6 divide-x divide-neutral-300/30 px-6 py-3 text-sm font-semibold">
            <div class="text-center">Type</div>
            <div class="text-center">Details</div>
            <div class="text-center">Date</div>
            <div class="text-center">Penalty</div>
            <div class="text-center">Status</div>
            <div class="text-center">Action</div>
          </div>
        </div>

        <div id="tableBody" class="divide-y divide-neutral-200">
          @forelse($violations as $row)
            <div class="violation-row grid grid-cols-6 divide-x divide-neutral-200 px-6 py-3 hover:bg-neutral-50 transition text-sm items-center">
              <div class="text-center">{{ $row->type }}</div>
              <div class="truncate text-center" title="{{ $row->details }}">{{ $row->details }}</div>
              <div class="text-center">{{ \Carbon\Carbon::parse($row->date)->format('M d, Y') }}</div>
              <div class="text-center">{{ $row->penalty ?? 'N/A' }}</div>
              <div class="text-center">
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                  {{ strtolower($row->status) == 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                  {{ strtolower($row->status) == 'disclosed' ? 'bg-blue-100 text-blue-800' : '' }}">
                  {{ $row->status }}
                </span>
              </div>
              <div class="text-center">
                <button onclick="openDetailsModal(`{{ $row->type }}`, `{{ $row->details }}`, `{{ \Carbon\Carbon::parse($row->date)->format('M d, Y') }}`, `{{ $row->penalty ?? 'N/A' }}`, `{{ $row->appeal ?? 'N/A' }}`, `{{ $row->status }}`)" 
                  class="text-green-600 hover:text-green-800 transition" title="View details">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </button>
              </div>
            </div>
          @empty
            <div class="px-6 py-10 text-center text-neutral-500">No violation records found.</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <!-- Details Modal -->
  <div id="detailsModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6">
      <h2 class="text-xl font-bold mb-4">Violation Details</h2>
      <div id="modalContent" class="space-y-2 text-sm"></div>
      <div class="mt-6 text-right">
        <button onclick="closeDetailsModal()" class="px-4 py-2 rounded-lg bg-brand-700 text-white hover:bg-brand-700/90">Close</button>
      </div>
    </div>
  </div>

  <script>
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');

    function filterTable() {
      const term = searchInput.value.toLowerCase();
      const rows = tableBody.querySelectorAll('.violation-row');
      rows.forEach(row => {
        const type = row.querySelector('div:nth-child(1)').textContent.toLowerCase();
        const details = row.querySelector('div:nth-child(2)').textContent.toLowerCase();
        row.style.display = (type.includes(term) || details.includes(term)) ? '' : 'none';
      });
    }
    searchInput.addEventListener('input', filterTable);

    function openDetailsModal(type, details, date, penalty, appeal, status) {
      const modal = document.getElementById('detailsModal');
      const content = document.getElementById('modalContent');
      content.innerHTML = `
        <p><strong>Type:</strong> ${type}</p>
        <p><strong>Details:</strong> ${details}</p>
        <p><strong>Date:</strong> ${date}</p>
        <p><strong>Penalty:</strong> ${penalty}</p>
        <p><strong>Appeal:</strong> ${appeal}</p>
        <p><strong>Status:</strong> ${status}</p>
      `;
      modal.classList.remove('hidden');
    }

    function closeDetailsModal() {
      document.getElementById('detailsModal').classList.add('hidden');
    }
  </script>
</body>
</html>

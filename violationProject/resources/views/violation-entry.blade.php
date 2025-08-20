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
  <div class="max-w-[1400px] mx-auto px-6 py-10">

    <!-- Title -->
    <h1 class="text-3xl font-bold tracking-tight mb-4">Violation Entry</h1>

    <!-- Controls: Search + Sort + Add + Export -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

      <!-- Left: Search + Sort -->
      <div class="flex w-full sm:w-auto gap-3 items-center">
        <!-- Search -->
        <div class="relative w-full sm:w-72">
          <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-400" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l3.387 3.386a1 1 0 01-1.415 1.415l-3.386-3.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd"/>
            </svg>
          </span>
          <input type="text" id="searchInput" placeholder="Search Student No. / Name"
            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-neutral-200 bg-white shadow focus:outline-none focus:ring-2 focus:ring-neutral-200" />
        </div>

        <!-- Modern Sort Dropdown -->
        <div class="relative">
          <button id="sortButton" class="flex items-center gap-2 bg-white border border-neutral-200 px-4 py-2.5 rounded-xl shadow hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18M3 12h12M3 20h6"/>
            </svg>
            <span id="sortLabel">Sort By</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-neutral-400 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div id="sortMenu" class="hidden absolute right-0 mt-2 w-56 bg-white border border-neutral-200 rounded-xl shadow-lg z-10">
            <button data-value="date-asc" class="w-full text-left px-4 py-2 hover:bg-neutral-100 flex items-center gap-2">
              <svg class="h-4 w-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
              </svg> Oldest
            </button>
            <button data-value="date-desc" class="w-full text-left px-4 py-2 hover:bg-neutral-100 flex items-center gap-2">
              <svg class="h-4 w-4 text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 15l4 4 4-4m0-6l-4-4-4 4"/>
              </svg> Newest
            </button>
            <button data-value="type-asc" class="w-full text-left px-4 py-2 hover:bg-neutral-100 flex items-center gap-2">Name: Z→A</button>
            <button data-value="type-desc" class="w-full text-left px-4 py-2 hover:bg-neutral-100 flex items-center gap-2">Name: A→Z</button>
          </div>
        </div>
      </div>

      <!-- Right: Buttons -->
      <div class="flex gap-3">
        <a href="{{ route('violations.create') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-brand-700 hover:bg-brand-700/90 text-white font-semibold px-4 py-2.5 shadow transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
          </svg>
          Add Record
        </a>
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

    <!-- Table Wrapper -->
    <div class="overflow-x-auto rounded-2xl bg-white shadow border border-neutral-200">
      <div class="min-w-[1200px]">
        <!-- Header -->
        <div class="bg-brand-700 text-white border-b border-neutral-200">
          <div class="grid grid-cols-11 divide-x divide-neutral-300/30 px-6 py-3 text-sm font-semibold">
            <div class="text-center">Student No.</div>
            <div class="text-center">Name</div>
            <div class="text-center">Course</div>
            <div class="text-center">Year</div>
            <div class="text-center">Type</div>
            <div class="text-center">Details</div>
            <div class="text-center">Date</div>
            <div class="text-center">Penalty</div>
            <div class="text-center">Appeal</div>
            <div class="text-center">Status</div>
            <div class="text-center">Actions</div>
          </div>
        </div>

        <!-- Body -->
        <div id="tableBody" class="divide-y divide-neutral-200">
          @forelse($violations as $row)
            <div class="violation-row grid grid-cols-11 divide-x divide-neutral-200 px-6 py-3 hover:bg-neutral-50 transition text-sm items-center">
              <div class="font-medium text-center student-no" title="{{ $row->student_no }}">{{ $row->student_no }}</div>
              <div class="truncate text-center" title="{{ $row->name }}">{{ $row->name }}</div>
              <div class="truncate text-center" title="{{ $row->course }}">{{ $row->course }}</div>
              <div class="text-center">{{ $row->year_level }}</div>
              <div class="truncate text-center" title="{{ $row->type }}">{{ $row->type }}</div>
              <div class="truncate text-center" title="{{ $row->details }}">{{ $row->details }}</div>
              <div class="text-center">{{ \Carbon\Carbon::parse($row->date)->format('M d, Y') }}</div>
              <div class="truncate text-center" title="{{ $row->penalty }}">{{ $row->penalty }}</div>

              <div class="truncate text-center" title="{{ $row->appeal ?? 'N/A' }}">
                {{ $row->appeal ?? 'N/A' }}
              </div>

              <!-- Status -->
              <div class="text-center">
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                  {{ strtolower($row->status) == 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                  {{ strtolower($row->status) == 'disclosed' ? 'bg-blue-100 text-blue-800' : '' }} "
                  title="{{ ucfirst($row->status) }}">
                  {{ $row->status }}
                </span>
              </div>


              <!-- Actions -->
              <div class="flex items-center justify-center gap-3">

                <button onclick="openDetailsModal(`{{ $row->student_no }}`, `{{ $row->name }}`, `{{ $row->course }}`, `{{ $row->year_level }}`, `{{ $row->type }}`, `{{ $row->details }}`, `{{ \Carbon\Carbon::parse($row->date)->format('M d, Y') }}`, `{{ $row->penalty }}`, `{{ $row->status }}`)" 
                  class="text-green-600 hover:text-green-800 transition" title="View full details">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </button>

                <a href="{{ route('violations.edit', $row->id) }}" class="text-blue-600 hover:text-blue-800 transition" title="Edit record">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                      viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16.862 3.487a2.25 2.25 0 013.182 3.182L7.125 19.587l-4.182.637.637-4.182L16.862 3.487z"/>
                  </svg>
                </a>

                <form action="{{ route('violations.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Delete this record?')" class="inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-800 transition" title="Delete record">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" 
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h2a2 2 0 012 2v2"/>
                    </svg>
                  </button>
                </form>
              </div>

              
            </div>
          @empty
            <div class="px-6 py-10 text-center text-neutral-500">No records found</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <!-- Search + Sort Script -->
  <script>
    const searchInput = document.getElementById('searchInput');
    const sortSelect = { value: '' };
    const tableBody = document.getElementById('tableBody');

    const sortButton = document.getElementById('sortButton');
    const sortMenu = document.getElementById('sortMenu');
    const sortLabel = document.getElementById('sortLabel');

    // Toggle dropdown
    sortButton.addEventListener('click', () => sortMenu.classList.toggle('hidden'));

    // Click outside to close
    document.addEventListener('click', e => {
      if (!sortButton.contains(e.target) && !sortMenu.contains(e.target)) sortMenu.classList.add('hidden');
    });

    // Select value
    sortMenu.querySelectorAll('button').forEach(btn => {
      btn.addEventListener('click', () => {
        sortLabel.textContent = btn.textContent;
        sortSelect.value = btn.getAttribute('data-value');
        sortMenu.classList.add('hidden');
        filterAndSort();
      });
    });

    function filterAndSort() {
      const term = searchInput.value.toLowerCase();
      const rows = Array.from(tableBody.querySelectorAll('.violation-row'));

      // Filter
      rows.forEach(row => {
        const studentNo = row.querySelector('.student-no').textContent.toLowerCase();
        const name = row.querySelector('div:nth-child(2)').textContent.toLowerCase();
        row.style.display = (studentNo.includes(term) || name.includes(term)) ? '' : 'none';
      });

      // Sort
      const value = sortSelect.value;
      if (!value) return;
      const visibleRows = rows.filter(r => r.style.display !== 'none');
      visibleRows.sort((a, b) => {
        let aVal, bVal;
        switch(value) {
          case 'date-asc':
          case 'date-desc':
            aVal = new Date(a.querySelector('div:nth-child(7)').textContent);
            bVal = new Date(b.querySelector('div:nth-child(7)').textContent);
            break;
          case 'type-asc':
          case 'type-desc':
            aVal = a.querySelector('div:nth-child(5)').textContent.toLowerCase();
            bVal = b.querySelector('div:nth-child(5)').textContent.toLowerCase();
            break;
        }
        return value.endsWith('asc') ? (aVal > bVal ? 1 : -1) : (aVal < bVal ? 1 : -1);
      });
      visibleRows.forEach(row => tableBody.appendChild(row));
    }

    searchInput.addEventListener('input', filterAndSort);
  </script>

  <!-- Details Modal -->
  <div id="detailsModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6">
      <h2 class="text-xl font-bold mb-4">Violation Details</h2>
      <div id="modalContent" class="space-y-2 text-sm">
        <!-- Content will be inserted dynamically -->
      </div>
      <div class="mt-6 text-right">
        <button onclick="closeDetailsModal()" class="px-4 py-2 rounded-lg bg-brand-700 text-white hover:bg-brand-700/90">Close</button>
      </div>
    </div>
  </div>

  <script>
    function openDetailsModal(studentNo, name, course, year, type, details, date, penalty, status) {
      const modal = document.getElementById('detailsModal');
      const content = document.getElementById('modalContent');
      content.innerHTML = `
        <p><strong>Student No:</strong> ${studentNo}</p>
        <p><strong>Name:</strong> ${name}</p>
        <p><strong>Course:</strong> ${course}</p>
        <p><strong>Year Level:</strong> ${year}</p>
        <p><strong>Type:</strong> ${type}</p>
        <p><strong>Details:</strong> ${details}</p>
        <p><strong>Date:</strong> ${date}</p>
        <p><strong>Penalty:</strong> ${penalty}</p>
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

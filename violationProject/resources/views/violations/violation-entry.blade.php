<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Violation Entry</title>

  {{-- Tailwind CSS --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { brand: { 700: '#7A0000' } },
          borderRadius: { '2xl': '1rem' }
        }
      }
    }
  </script>
</head>

<body class="bg-neutral-50 text-neutral-800 antialiased">
  <div class="max-w-[1400px] mx-auto px-6 py-10">

    {{-- Flash Message --}}
    @if(session('success'))
      <div id="successMessage" class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3">
        {{ session('success') }}
      </div>
    @endif

    {{-- Title --}}
    <h1 class="text-3xl font-bold tracking-tight mb-6">Violation Entry</h1>

    {{-- Controls --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
      <!-- Search + Sort -->
      <div class="flex w-full sm:w-auto gap-3 items-center">
        <!-- Search -->
        <div class="relative w-full sm:w-72">
          <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400"></i>
          <input type="text" id="searchInput" placeholder="Search Student No. / Name"
            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-neutral-200 bg-white shadow focus:outline-none focus:ring-2 focus:ring-brand-700" />
        </div>

        <!-- Sort -->
        <div class="relative">
          <button id="sortButton" class="flex items-center gap-2 bg-white border border-neutral-200 px-4 py-2.5 rounded-xl shadow hover:bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-brand-700">
            <i data-lucide="list-filter" class="w-5 h-5 text-neutral-600"></i>
            <span id="sortLabel">Sort By</span>
            <i data-lucide="chevron-down" class="w-4 h-4 text-neutral-400"></i>
          </button>
          <div id="sortMenu" class="hidden absolute right-0 mt-2 w-56 bg-white border border-neutral-200 rounded-xl shadow-lg z-10">
            <button data-value="date-asc" class="w-full text-left px-4 py-2 hover:bg-neutral-100">Oldest</button>
            <button data-value="date-desc" class="w-full text-left px-4 py-2 hover:bg-neutral-100">Newest</button>
            <button data-value="name-asc" class="w-full text-left px-4 py-2 hover:bg-neutral-100">Name: A→Z</button>
            <button data-value="name-desc" class="w-full text-left px-4 py-2 hover:bg-neutral-100">Name: Z→A</button>
          </div>
        </div>
      </div>

      <!-- Buttons -->
      <div class="flex gap-3">
        <a href="{{ route('faculty.violations.create') }}"
          class="inline-flex items-center gap-2 rounded-xl bg-brand-700 hover:bg-brand-700/90 text-white font-semibold px-4 py-2.5 shadow transition">
          <i data-lucide="plus" class="w-5 h-5"></i>
          Add Record
        </a>
        <a href="{{ route('faculty.violations.exportPdf') }}"
          class="inline-flex items-center gap-2 rounded-xl bg-neutral-700 hover:bg-neutral-800 text-white font-semibold px-4 py-2.5 shadow transition">
          <i data-lucide="file-text" class="w-5 h-5"></i>
          Export PDF
        </a>
      </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto rounded-2xl bg-white shadow border border-neutral-200">
      <div class="min-w-[1200px]">
        {{-- Header --}}
        <div class="bg-brand-700 text-white border-b border-neutral-200">
          <div class="grid grid-cols-11 divide-x divide-neutral-300/30 px-6 py-3 text-sm font-semibold">
            <div class="text-center">Student No.</div>
            <div class="text-center">Name</div>
            <div class="text-center">Course</div>
            <div class="text-center">Year Level</div>
            <div class="text-center">Type</div>
            <div class="text-center">Details</div>
            <div class="text-center">Date</div>
            <div class="text-center">Penalty</div>
            <div class="text-center">Appeal</div>
            <div class="text-center">Status</div>
            <div class="text-center">Actions</div>
          </div>
        </div>

        {{-- Body --}}
        <div id="tableBody" class="divide-y divide-neutral-200">
          @forelse($violations as $row)
            <div class="violation-row grid grid-cols-11 divide-x divide-neutral-200 px-6 py-3 hover:bg-neutral-50 odd:bg-neutral-50/40 transition text-sm items-center">
              <div class="text-center student-no">{{ $row->student->student_no }}</div>
              <div class="text-center name">{{ $row->student->first_name }} {{ $row->student->last_name }}</div>
              <div class="text-center">{{ $row->course->course_name }}</div>
              <div class="text-center">{{ $row->student->year_level }}</div>
              <div class="text-center">{{ $row->type }}</div>
              <div class="text-center">{{ $row->details ?? 'N/A' }}</div>
              <div class="text-center">{{ \Carbon\Carbon::parse($row->violation_date)->format('M d, Y') }}</div>
              <div class="text-center">{{ $row->penalty }}</div>

              {{-- Appeal column -> opens Appeal Modal --}}
              <div class="text-center">
                @if($row->studentAppeals->isNotEmpty())
                  <button
                    type="button"
                    class="text-blue-600 hover:underline"
                    data-appeal='{!! json_encode([
                      "violation_id"  => $row->violation_id,
                      "student_no"    => $row->student->student_no,
                      "name"          => $row->student->first_name . " " . $row->student->last_name,
                      "course"        => $row->course->course_name,
                      "year_level"    => $row->student->year_level,
                      "type"          => $row->type,
                      "date"          => \Carbon\Carbon::parse($row->violation_date)->format("M d, Y"),
                      "appeal"        => $row->studentAppeals->first()->appeal->appeal_text,
                      "appeal_id"     => $row->studentAppeals->first()->appeal_id,
                      "appeal_status" => $row->studentAppeals->first()->status,
                    ]) !!}'
                    onclick="openAppealModal(this)">
                    View Appeal
                  </button>
                @else
                  N/A
                @endif
              </div>

              {{-- Status pill --}}
              <div class="text-center">
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                  {{ strtolower($row->status) == 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                  {{ strtolower($row->status) == 'disclosed' ? 'bg-blue-100 text-blue-800' : '' }}
                  {{ strtolower($row->status) == 'cleared' ? 'bg-green-100 text-green-800' : '' }}">
                  {{ ucfirst($row->status) }}
                </span>
              </div>

              {{-- Actions --}}
              <div class="flex items-center justify-center gap-3">
                <!-- View Violation Details -->
                <button
                  type="button"
                  class="text-green-600 hover:text-green-800"
                  title="View Details"
                  data-details='{!! json_encode([
                    "student_no" => $row->student->student_no,
                    "name"       => $row->student->first_name . " " . $row->student->last_name,
                    "course"     => $row->course->course_name,
                    "year_level" => $row->student->year_level,
                    "type"       => $row->type,
                    "details"    => $row->details ?? "N/A",
                    "date"       => \Carbon\Carbon::parse($row->violation_date)->format("M d, Y"),
                    "penalty"    => $row->penalty,
                    "status"     => $row->status,
                  ]) !!}'
                  onclick="openDetailsModalFromBtn(this)">
                  <i data-lucide="eye" class="w-5 h-5"></i>
                </button>

                <a href="{{ route('faculty.violations.edit', $row->violation_id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                  <i data-lucide="pencil" class="w-5 h-5"></i>
                </a>
                <form action="{{ route('faculty.violations.destroy', $row->violation_id) }}" method="POST" onsubmit="return confirm('Delete this record?')" class="inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                  </button>
                </form>
              </div>
            </div>
          @empty
            <div class="px-6 py-12 text-center text-neutral-500">
              <i data-lucide="check-circle" class="mx-auto w-12 h-12 mb-3 text-neutral-400"></i>
              <p class="font-medium">No records found</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  {{-- Violation Details Modal (read-only) --}}
  <div id="details-modal" class="fixed inset-0 hidden bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full p-6">
      <h3 class="text-lg font-semibold mb-4">Violation Details</h3>
      <div id="details-content" class="space-y-3 text-sm text-neutral-700"></div>

      <div class="mt-6 flex justify-end gap-2">
        <button onclick="closeDetailsModal()"
          class="px-4 py-2 rounded-lg bg-brand-700 text-white hover:bg-brand-700/90 transition">
          Close
        </button>
      </div>
    </div>
  </div>

  {{-- Appeal Modal (Approve/Reject only when pending) --}}
  <div id="appeal-modal" class="fixed inset-0 hidden bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full p-6">
      <h3 class="text-lg font-semibold mb-4">Appeal Details</h3>

      <div id="appeal-content" class="space-y-3 text-sm text-neutral-700"></div>

      <div id="appeal-actions" class="hidden mt-6 flex justify-end gap-2">
        <form id="appeal-approve-form" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="status" value="Approved">
          <button type="submit"
            class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition">
            ✅ Approve
          </button>
        </form>
        <form id="appeal-reject-form" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="status" value="Rejected">
          <button type="submit"
            class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
            ❌ Reject
          </button>
        </form>
      </div>

      <div class="mt-6 flex justify-end">
        <button onclick="closeAppealModal()"
          class="px-4 py-2 rounded-lg bg-brand-700 text-white hover:bg-brand-700/90 transition">
          Close
        </button>
      </div>
    </div>
  </div>

  <script>
    // === Search & Sort ===
    const searchInput = document.getElementById('searchInput');
    const sortSelect = { value: '' };
    const tableBody = document.getElementById('tableBody');
    const sortButton = document.getElementById('sortButton');
    const sortMenu = document.getElementById('sortMenu');
    const sortLabel = document.getElementById('sortLabel');

    sortButton.addEventListener('click', () => sortMenu.classList.toggle('hidden'));
    document.addEventListener('click', e => {
      if (!sortButton.contains(e.target) && !sortMenu.contains(e.target)) sortMenu.classList.add('hidden');
    });

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
        const name = row.querySelector('.name').textContent.toLowerCase();
        row.style.display = (studentNo.includes(term) || name.includes(term)) ? '' : 'none';
      });

      // Sort
      const value = sortSelect.value;
      if (!value) return;

      const visibleRows = rows.filter(r => r.style.display !== 'none');
      visibleRows.sort((a, b) => {
        switch (value) {
          case 'date-asc':
          case 'date-desc': {
            const aVal = new Date(a.querySelector('div:nth-child(7)').textContent).getTime();
            const bVal = new Date(b.querySelector('div:nth-child(7)').textContent).getTime();
            return value.endsWith('asc') ? aVal - bVal : bVal - aVal;
          }
          case 'name-asc':
          case 'name-desc': {
            const aVal = a.querySelector('.name').textContent.toLowerCase();
            const bVal = b.querySelector('.name').textContent.toLowerCase();
            return value.endsWith('asc') ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
          }
          default:
            return 0;
        }
      });
      visibleRows.forEach(row => tableBody.appendChild(row));
    }
    searchInput.addEventListener('input', filterAndSort);

    // === Helpers ===
    function escapeHtml(str) {
      if (str == null) return '';
      return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
    }
    function statusPill(status) {
      const s = (status || '').toLowerCase();
      let cls = 'bg-neutral-100 text-neutral-800';
      if (s === 'pending') cls = 'bg-amber-100 text-amber-800';
      if (s === 'approved') cls = 'bg-green-100 text-green-800';
      if (s === 'rejected') cls = 'bg-red-100 text-red-800';
      return `<span class="px-2.5 py-1 rounded-full text-xs font-semibold ${cls}">${status}</span>`;
    }

    // === Violation Details Modal ===
    function openDetailsModalFromBtn(btn) {
      const v = JSON.parse(btn.dataset.details);
      openDetailsModal(v);
    }
    function openDetailsModal(v) {
      const content = document.getElementById('details-content');
      content.innerHTML = `
        <p><strong>Student No:</strong> ${escapeHtml(v.student_no)}</p>
        <p><strong>Name:</strong> ${escapeHtml(v.name)}</p>
        <p><strong>Course:</strong> ${escapeHtml(v.course)}</p>
        <p><strong>Year Level:</strong> ${escapeHtml(v.year_level)}</p>
        <p><strong>Type:</strong> ${escapeHtml(v.type)}</p>
        <p><strong>Details:</strong> ${escapeHtml(v.details)}</p>
        <p><strong>Date:</strong> ${escapeHtml(v.date)}</p>
        <p><strong>Penalty:</strong> ${escapeHtml(v.penalty)}</p>
        <p><strong>Status:</strong> ${escapeHtml(v.status)}</p>
      `;
      document.getElementById('details-modal').classList.remove('hidden');
    }
    function closeDetailsModal() {
      document.getElementById('details-modal').classList.add('hidden');
    }

    // === Appeal Modal ===
    function openAppealModal(btn) {
      const v = JSON.parse(btn.dataset.appeal);
      const content = document.getElementById('appeal-content');
      const actions = document.getElementById('appeal-actions');
      const approveForm = document.getElementById('appeal-approve-form');
      const rejectForm = document.getElementById('appeal-reject-form');

      const hasAppeal = v.appeal && v.appeal !== 'N/A';

      content.innerHTML = `
        <div class="grid grid-cols-2 gap-3">
          <p><strong>Student No:</strong> ${escapeHtml(v.student_no)}</p>
          <p><strong>Name:</strong> ${escapeHtml(v.name)}</p>
          <p><strong>Course:</strong> ${escapeHtml(v.course)}</p>
          <p><strong>Year Level:</strong> ${escapeHtml(v.year_level)}</p>
          <p><strong>Violation:</strong> ${escapeHtml(v.type)}</p>
          <p><strong>Date:</strong> ${escapeHtml(v.date)}</p>
        </div>

        <div class="mt-3">
          <p class="mb-1"><strong>Appeal:</strong></p>
          <div class="whitespace-pre-wrap bg-neutral-50 border border-neutral-200 rounded-lg p-3">
            ${hasAppeal ? escapeHtml(v.appeal) : 'N/A'}
          </div>
        </div>

        <p class="mt-3"><strong>Status:</strong> ${statusPill(v.appeal_status || 'N/A')}</p>
      `;

      if (hasAppeal && (v.appeal_status || '').toLowerCase() === 'pending') {
        actions.classList.remove('hidden');
        approveForm.action = `/faculty/appeals/${v.appeal_id}`;
        rejectForm.action  = `/faculty/appeals/${v.appeal_id}`;
      } else {
        actions.classList.add('hidden');
        approveForm.removeAttribute('action');
        rejectForm.removeAttribute('action');
      }

      document.getElementById('appeal-modal').classList.remove('hidden');
    }
    function closeAppealModal() {
      document.getElementById('appeal-modal').classList.add('hidden');
    }

    // Close modals on ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        closeDetailsModal();
        closeAppealModal();
      }
    });

    // Flash Message Auto-hide + icons
    document.addEventListener("DOMContentLoaded", () => {
      const msg = document.getElementById("successMessage");
      if (msg) {
        setTimeout(() => {
          msg.classList.add("opacity-0", "transition", "duration-700");
          setTimeout(() => msg.remove(), 700);
        }, 3000);
      }
      lucide.createIcons();
    });
  </script>
</body>
</html>

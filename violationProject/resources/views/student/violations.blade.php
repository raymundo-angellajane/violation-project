<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My Violations</title>

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
  <div class="max-w-[1200px] mx-auto px-6 py-10">

    <!-- Flash Message -->
    @if(session('success'))
      <div id="successMessage" class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3">
        {{ session('success') }}
      </div>
    @endif

    <!-- Title -->
    <h1 class="text-3xl font-bold tracking-tight mb-6">My Violations</h1>

    <!-- Student Info Card -->
    <div class="bg-white rounded-2xl shadow mb-6 border border-neutral-200 flex items-center p-4 gap-4">
      <div class="w-12 h-12 rounded-full bg-brand-700 text-white flex items-center justify-center font-bold">ST</div>
      <div>
        <p class="text-sm text-neutral-500">Student No.</p>
        <p class="font-semibold">{{ optional($student)->student_no ?? 'N/A' }}</p>
        <p class="text-sm text-neutral-500">Name</p>
        <p class="font-semibold">
          {{ optional($student)->first_name }} {{ optional($student)->last_name }}
        </p>
        <p class="text-sm text-neutral-500">Course</p>
        <p class="font-semibold">{{ optional($student->course)->course_name ?? 'N/A' }}</p>
      </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-2xl bg-white shadow border border-neutral-200">
      <div class="min-w-[1100px]">
        <!-- Header -->
        <div class="bg-brand-700 text-white border-b border-neutral-200">
          <div class="grid grid-cols-9 divide-x divide-neutral-300/30 px-6 py-3 text-sm font-semibold">
            <div class="text-center">Violation ID</div>
            <div class="text-center">Type</div>
            <div class="text-center">Details</div>
            <div class="text-center">Date</div>
            <div class="text-center">Penalty</div>
            <div class="text-center">Appeal</div>
            <div class="text-center">Status</div>
            <div class="text-center">Reviewed By</div>
            <div class="text-center">Actions</div>
          </div>
        </div>

        <!-- Body -->
        <div class="divide-y divide-neutral-200">
          @forelse($violations as $row)
            <div class="grid grid-cols-9 divide-x divide-neutral-200 px-6 py-3 hover:bg-neutral-50 odd:bg-neutral-50/40 transition text-sm items-center">
              <div class="text-center">{{ $row->violation_id }}</div>
              <div class="text-center">{{ $row->type }}</div>
              <div class="text-center">{{ $row->details ?? 'N/A' }}</div>
              <div class="text-center">{{ \Carbon\Carbon::parse($row->violation_date)->format('M d, Y') }}</div>
              <div class="text-center">{{ $row->penalty }}</div>

              <!-- Appeal -->
              <div class="text-center">
                @if(!$row->studentAppeals->count())
                  <button onclick="openAppealModal('{{ $row->violation_id }}')" 
                          class="text-blue-600 hover:text-blue-800 font-medium">
                    Submit Appeal
                  </button>
                @else
                  <button onclick="openViewAppealModal(`{{ optional(optional($row->studentAppeals->first())->appeal)->appeal_text ?? '' }}`)" 
                          class="text-blue-600 hover:text-blue-800 font-medium">
                    View Appeal
                  </button>
                @endif
              </div>

              <!-- Status -->
              <div class="text-center">
                @if($row->studentAppeals->count())
                  <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                    {{ strtolower($row->studentAppeals->first()->status) == 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                    {{ strtolower($row->studentAppeals->first()->status) == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                    {{ strtolower($row->studentAppeals->first()->status) == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ ucfirst($row->studentAppeals->first()->status) }}
                  </span>
                @else
                  -
                @endif
              </div>

              <!-- Reviewed By -->
              <div class="text-center">
                {{ optional($row->studentAppeals->first())->reviewed_by ?? '-' }}
              </div>

              <!-- Actions -->
              <div class="flex items-center justify-center">
                <button onclick="openDetailsModal(
                  '{{ $row->violation_id }}',
                  '{{ $row->type }}',
                  '{{ $row->details ?? 'N/A' }}',
                  '{{ \Carbon\Carbon::parse($row->violation_date)->format('M d, Y') }}',
                  '{{ $row->penalty }}',
                  '{{ $row->studentAppeals->count() ? optional(optional($row->studentAppeals->first())->appeal)->appeal_text : 'No appeal submitted' }}',
                  '{{ $row->studentAppeals->count() ? ucfirst($row->studentAppeals->first()->status) : '-' }}',
                  '{{ optional($row->studentAppeals->first())->reviewed_by ?? '-' }}'
                )" class="text-brand-700 hover:text-brand-900">
                  <i data-lucide="eye"></i>
                </button>
              </div>
            </div>
          @empty
            <div class="px-6 py-12 text-center text-neutral-500">
              <i data-lucide="check-circle" class="mx-auto w-12 h-12 mb-3 text-neutral-400"></i>
              <p class="font-medium">No violations found 🎉</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <!-- Appeal Modal -->
  <div id="appealModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6">
      <h2 class="text-xl font-bold mb-4">Submit Appeal</h2>
      <form method="POST" action="{{ route('student.appeals.store') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="violation_id" id="appealViolationId">
        <textarea name="appeal_text" rows="4" required
          class="w-full rounded-lg border border-neutral-300 px-3 py-2 focus:ring-2 focus:ring-brand-700"
          placeholder="Write your appeal here..."></textarea>
        <div class="flex justify-end gap-3">
          <button type="button" onclick="closeAppealModal()" class="px-4 py-2 rounded-lg bg-neutral-200 hover:bg-neutral-300">Cancel</button>
          <button type="submit" class="px-4 py-2 rounded-lg bg-brand-700 text-white hover:bg-brand-700/90">Submit</button>
        </div>
      </form>
    </div>
  </div>

  <!-- View Appeal Modal -->
  <div id="viewAppealModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6">
      <h2 class="text-xl font-bold mb-4">Appeal Details</h2>
      <p id="viewAppealText" class="text-neutral-700 whitespace-pre-line"></p>
      <div class="mt-6 flex justify-end">
        <button onclick="closeViewAppealModal()" class="px-4 py-2 rounded-lg bg-brand-700 text-white hover:bg-brand-700/90">Close</button>
      </div>
    </div>
  </div>

  <!-- View Details Modal -->
  <div id="detailsModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6 space-y-3">
      <h2 class="text-xl font-bold mb-4">Violation Details</h2>
      <p><strong>Violation ID:</strong> <span id="detailViolationId"></span></p>
      <p><strong>Type:</strong> <span id="detailType"></span></p>
      <p><strong>Details:</strong> <span id="detailDetails"></span></p>
      <p><strong>Date:</strong> <span id="detailDate"></span></p>
      <p><strong>Penalty:</strong> <span id="detailPenalty"></span></p>
      <p><strong>Appeal:</strong> <span id="detailAppeal"></span></p>
      <p><strong>Status:</strong> <span id="detailStatus"></span></p>
      <p><strong>Reviewed By:</strong> <span id="detailReviewedBy"></span></p>
      <div class="mt-6 flex justify-end">
        <button onclick="closeDetailsModal()" class="px-4 py-2 rounded-lg bg-brand-700 text-white hover:bg-brand-700/90">Close</button>
      </div>
    </div>
  </div>

  <script>
    function openAppealModal(violationId) {
      document.getElementById('appealViolationId').value = violationId;
      document.getElementById('appealModal').classList.remove('hidden');
    }
    function closeAppealModal() {
      document.getElementById('appealModal').classList.add('hidden');
    }

    function openDetailsModal(id, type, details, date, penalty, appeal, status, reviewedBy) {
      document.getElementById('detailViolationId').textContent = id;
      document.getElementById('detailType').textContent = type;
      document.getElementById('detailDetails').textContent = details;
      document.getElementById('detailDate').textContent = date;
      document.getElementById('detailPenalty').textContent = penalty;
      document.getElementById('detailAppeal').textContent = appeal;
      document.getElementById('detailStatus').textContent = status;
      document.getElementById('detailReviewedBy').textContent = reviewedBy;
      document.getElementById('detailsModal').classList.remove('hidden');
    }
    function closeDetailsModal() {
      document.getElementById('detailsModal').classList.add('hidden');
    }

    function openViewAppealModal(text) {
      document.getElementById('viewAppealText').textContent = text;
      document.getElementById('viewAppealModal').classList.remove('hidden');
    }
    function closeViewAppealModal() {
      document.getElementById('viewAppealModal').classList.add('hidden');
    }

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

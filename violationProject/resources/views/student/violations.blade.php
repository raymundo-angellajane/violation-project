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
  <div class="max-w-[1100px] mx-auto px-6 py-10">

    <!-- Flash success -->
    @if(session('success'))
      <div id="successMessage" class="mb-4 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3">
        {{ session('success') }}
      </div>
    @endif

    <!-- Title -->
    <h1 class="text-3xl font-bold tracking-tight mb-6">My Violations</h1>

    <!-- Student Info -->
    <div class="bg-white shadow rounded-xl p-4 mb-6 flex items-center gap-4 border border-neutral-200">
      <div class="w-12 h-12 rounded-full bg-brand-700 text-white flex items-center justify-center font-bold">
        ST
      </div>
      <div>
        <p class="text-sm text-neutral-500">Student No.</p>
        <p class="text-lg font-semibold">2025-00001-TG-0</p>
      </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto rounded-2xl bg-white shadow border border-neutral-200">
      <div class="min-w-[950px]">
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
            <div class="text-center">Action</div>
          </div>
        </div>

        <!-- Body -->
        <div id="tableBody" class="divide-y divide-neutral-200">
          @forelse($violations as $row)
            <div class="grid grid-cols-9 divide-x divide-neutral-200 px-6 py-3 hover:bg-neutral-50 odd:bg-neutral-50/40 transition text-sm items-center">
              <div class="text-center font-semibold">{{ $row->formatted_id }}</div>
              <div class="text-center">{{ $row->type }}</div>
              <div class="text-center">{{ $row->details }}</div>
              <div class="text-center">{{ \Carbon\Carbon::parse($row->date)->format('M d, Y') }}</div>
              <div class="text-center">{{ $row->penalty }}</div>

              <!-- Appeal Column -->
              <div class="text-center">
                @if(!$row->appeal)
                  <button type="button" onclick="openAppealModal('{{ $row->id }}')"
                    class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                    Add Appeal
                  </button>
                @else
                  <button type="button" onclick="openAppealViewModal('{{ $row->id }}')"
                    class="text-green-600 hover:text-green-800 font-medium text-sm">
                    View Appeal
                  </button>
                @endif
              </div>

              <!-- Status -->
              <div class="text-center">
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                  {{ $row->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                  {{ $row->status === 'disclosed' ? 'bg-blue-100 text-blue-800' : '' }}
                  {{ $row->status === 'cleared' ? 'bg-green-100 text-green-800' : '' }}">
                  {{ ucfirst($row->status) }}
                </span>
              </div>

              <!-- Reviewed By -->
              <div class="text-center">
                {{ $row->reviewed_by ?? 'Not Reviewed' }}
              </div>

              <!-- Action (Eye only) -->
              <div class="text-center">
                <button type="button" onclick="openDetailsModal('{{ $row->id }}')"
                  class="p-1 rounded hover:bg-neutral-100" title="View Details">
                  <i data-lucide="eye" class="w-5 h-5"></i>
                </button>
              </div>
            </div>
          @empty
            <div class="px-6 py-12 text-center text-neutral-500">
              <i data-lucide="check-circle" class="mx-auto w-12 h-12 mb-3 text-neutral-400"></i>
              <p class="font-medium">No violations found</p>
              <p class="text-sm">You are all clear 🎉</p>
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
      <form id="appealForm" method="POST" action="{{ route('student.appeal') }}">
        @csrf
        <input type="hidden" name="violation_id" id="appealViolationId">
        <textarea name="appeal" rows="4" required
          class="w-full border border-neutral-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-700 focus:outline-none"
          placeholder="Write your appeal here..."></textarea>
        <div class="mt-6 flex justify-end gap-3">
          <button type="button" onclick="closeAppealModal()" 
            class="px-4 py-2 rounded-lg bg-neutral-200 hover:bg-neutral-300">Cancel</button>
          <button type="submit"
            class="px-4 py-2 rounded-lg bg-brand-700 text-white hover:bg-brand-700/90">Submit</button>
        </div>
      </form>
    </div>
  </div>

  <!-- View Appeal Modal -->
  <div id="appealViewModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-6">
      <h2 class="text-xl font-bold mb-4">Appeal Submitted</h2>
      <div id="appealViewContent" class="text-sm text-neutral-700 whitespace-pre-line"></div>
      <div class="mt-6 flex justify-end">
        <button type="button" onclick="closeAppealViewModal()" 
          class="px-4 py-2 rounded-lg bg-neutral-200 hover:bg-neutral-300">Close</button>
      </div>
    </div>
  </div>

  <!-- Details Modal -->
  <div id="detailsModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-lg p-6">
      <h2 class="text-xl font-bold mb-4">Violation Details</h2>
      <div id="detailsContent" class="space-y-3 text-sm text-neutral-700">
        <!-- Populated dynamically -->
      </div>
      <div class="mt-6 flex justify-end">
        <button type="button" onclick="closeDetailsModal()" 
          class="px-4 py-2 rounded-lg bg-neutral-200 hover:bg-neutral-300">
          Close
        </button>
      </div>
    </div>
  </div>

  <script>
    const violations = @json($violations);

    function openAppealModal(id) {
      document.getElementById('appealViolationId').value = id;
      document.getElementById('appealModal').classList.remove('hidden');
    }
    function closeAppealModal() {
      document.getElementById('appealModal').classList.add('hidden');
    }
    
    function openAppealViewModal(id) {
      
      let v = violations.find(item => item.id == id);
      if (!v) return;
      document.getElementById('appealViewContent').textContent = v.appeal;
      document.getElementById('appealViewModal').classList.remove('hidden');
    }
    function closeAppealViewModal() {
      document.getElementById('appealViewModal').classList.add('hidden');
    }

    function openDetailsModal(id) {
      
      let v = violations.find(item => item.id == id);
      if (!v) return;

      document.getElementById('detailsContent').innerHTML = `
        <div><p class="text-xs text-neutral-500">Violation ID</p><p class="font-semibold">V-${new Date().getFullYear()}-${String(v.id).padStart(4, '0')}</p></div>
        <div><p class="text-xs text-neutral-500">Type</p><p>${v.type}</p></div>
        <div><p class="text-xs text-neutral-500">Details</p><p>${v.details}</p></div>
        <div><p class="text-xs text-neutral-500">Date</p><p>${new Date(v.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</p></div>
        <div><p class="text-xs text-neutral-500">Penalty</p><p>${v.penalty}</p></div>
        <div><p class="text-xs text-neutral-500">Appeal</p><p>${v.appeal ?? 'N/A'}</p></div>
        <div><p class="text-xs text-neutral-500">Status</p><p>${v.status}</p></div>
        <div><p class="text-xs text-neutral-500">Reviewed By</p><p>${v.reviewed_by ?? 'Not Reviewed'}</p></div>
      `;

      document.getElementById('detailsModal').classList.remove('hidden');
    }
    function closeDetailsModal() {
      document.getElementById('detailsModal').classList.add('hidden');
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

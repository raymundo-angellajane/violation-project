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

    <!-- Table -->
    <div class="overflow-x-auto rounded-2xl bg-white shadow border border-neutral-200">
      <div class="min-w-[950px]">
        <!-- Header -->
        <div class="bg-brand-700 text-white border-b border-neutral-200">
          <div class="grid grid-cols-8 divide-x divide-neutral-300/30 px-6 py-3 text-sm font-semibold">
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
            <div class="grid grid-cols-8 divide-x divide-neutral-200 px-6 py-3 hover:bg-neutral-50 transition text-sm items-center">
              <div class="truncate text-center">{{ $row->type }}</div>
              <div class="truncate text-center">{{ $row->details }}</div>
              <div class="text-center">{{ \Carbon\Carbon::parse($row->date)->format('M d, Y') }}</div>
              <div class="truncate text-center">{{ $row->penalty }}</div>
              <div class="truncate text-center">{{ $row->appeal ?? 'N/A' }}</div>

              <div class="text-center">
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                  {{ $row->status === 'pending' ? 'bg-amber-100 text-amber-800' : '' }}
                  {{ $row->status === 'disclosed' ? 'bg-blue-100 text-blue-800' : '' }}
                  {{ $row->status === 'cleared' ? 'bg-green-100 text-green-800' : '' }}">
                  {{ ucfirst($row->status) }}
                </span>
              </div>

              <div class="text-center">
                {{ $row->reviewed_by ?? 'Not Reviewed' }}
              </div>

              <div class="text-center">
                @if(!$row->appeal)
                  <button type="button" onclick="openAppealModal('{{ $row->id }}')"
                    class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                    Add Appeal
                  </button>
                @else
                  <span class="text-neutral-500 text-xs">Submitted</span>
                @endif
              </div>
            </div>
          @empty
            <div class="px-6 py-10 text-center text-neutral-500">No violations found</div>
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

  <script>
    function openAppealModal(id) {
      document.getElementById('appealViolationId').value = id;
      document.getElementById('appealModal').classList.remove('hidden');
    }
    function closeAppealModal() {
      document.getElementById('appealModal').classList.add('hidden');
    }

    document.addEventListener("DOMContentLoaded", () => {
      const msg = document.getElementById("successMessage");
      if (msg) {
        setTimeout(() => {
          msg.classList.add("opacity-0", "transition", "duration-700");
          setTimeout(() => msg.remove(), 700);
        }, 3000);
      }
    });
  </script>
</body>
</html>

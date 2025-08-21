<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Violations</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .highlight {
      background-color: #fef08a; /* yellow-200 */
      transition: background-color 1s ease;
    }
  </style>
</head>
<body class="bg-neutral-50 text-neutral-800 antialiased p-8">

  {{-- ✅ Success message --}}
  @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg border border-green-300">
      {{ session('success') }}
    </div>
  @endif

  {{-- 🔹 Violations Table --}}
  <div class="bg-white rounded-2xl shadow border border-neutral-200 p-6 mb-10">
    <h2 class="text-xl font-bold mb-4">My Violations</h2>
    <div class="overflow-x-auto">
      <table class="w-full border-collapse text-sm">
        <thead>
          <tr class="bg-brand-700 text-white">
            <th class="p-3">Student No</th>
            <th class="p-3">Name</th>
            <th class="p-3">Course</th>
            <th class="p-3">Year</th>
            <th class="p-3">Violation</th>
            <th class="p-3">Details</th>
            <th class="p-3">Date</th>
            <th class="p-3">Penalty</th>
            <th class="p-3">Appeal</th>
            <th class="p-3">Reviewed By</th>
            <th class="p-3">Status</th>
            <th class="p-3">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($violations as $row)
            <tr class="border-b">
              <td class="p-3">{{ $row->student_no }}</td>
              <td class="p-3">{{ $row->name }}</td>
              <td class="p-3">{{ $row->course }}</td>
              <td class="p-3">{{ $row->year_level }}</td>
              <td class="p-3">{{ $row->type }}</td>
              <td class="p-3">{{ $row->details }}</td>
              <td class="p-3">{{ $row->date }}</td>
              <td class="p-3">{{ $row->penalty }}</td>
              <td class="p-3">
                @if($row->appeal)
                  <a href="#appeal-{{ $row->id }}" 
                     class="text-blue-600 hover:underline appeal-link">
                     View Appeal
                  </a>
                @else
                  No Appeal
                @endif
              </td>
              <td class="p-3">{{ $row->reviewed_by ?? 'Not yet reviewed' }}</td>
              <td class="p-3">{{ $row->status }}</td>
              <td class="p-3">
                @if(!$row->appeal)
                  <a href="{{ route('appeals.create', $row->id) }}" 
                     class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700">
                     Submit Appeal
                  </a>
                @else
                  <span class="px-3 py-1 bg-gray-400 text-white rounded-lg">Appeal Sent</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="12" class="p-4 text-center">No violations found</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- 🔹 Appeal History Table --}}
  <div class="bg-white rounded-2xl shadow border border-neutral-200 p-6">
    <h2 class="text-xl font-bold mb-4">My Appeal History</h2>
    <div class="overflow-x-auto">
      <table class="w-full border-collapse text-sm">
        <thead>
          <tr class="bg-brand-700 text-white">
            <th class="p-3">Appeal ID</th>
            <th class="p-3">Violation ID</th>
            <th class="p-3">Student</th>
            <th class="p-3">Message</th>
            <th class="p-3">Date Submitted</th>
            <th class="p-3">Reviewed By</th>
            <th class="p-3">Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($appeals as $appeal)
            <tr id="appeal-{{ $appeal->violation_id }}" class="border-b">
              <td class="p-3">{{ $appeal->id }}</td>
              <td class="p-3">{{ $appeal->violation_id }}</td>
              <td class="p-3">{{ $appeal->student }}</td>
              <td class="p-3">{{ $appeal->message }}</td>
              <td class="p-3">{{ $appeal->submitted_at }}</td>
              <td class="p-3">{{ $appeal->reviewed_by ?? 'Not yet reviewed' }}</td>
              <td class="p-3">{{ $appeal->status }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="p-4 text-center">No appeals submitted</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <script>
    // Highlight effect when clicking "View Appeal"
    document.querySelectorAll('.appeal-link').forEach(link => {
      link.addEventListener('click', function(e) {
        const targetId = this.getAttribute('href').substring(1);
        const targetRow = document.getElementById(targetId);
        if (targetRow) {
          targetRow.classList.add('highlight');
          setTimeout(() => {
            targetRow.classList.remove('highlight');
          }, 2000); // remove highlight after 2s
        }
      });
    });
  </script>

</body>
</html>

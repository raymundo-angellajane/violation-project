<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Violation Summary Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2, h3 { margin: 0; padding: 0; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { color: #7A0000; }
        .meta { text-align: right; font-size: 11px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: center; }
        th { background-color: #7A0000; color: white; }
        .summary { margin-top: 20px; }
        .summary table { width: 50%; float: right; border: 1px solid #ddd; }
        .summary th, .summary td { padding: 6px; text-align: left; }
        .footer { position: fixed; bottom: 20px; width: 100%; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <!-- Report Header -->
    <div class="header">
        <h1>Violation Summary Report</h1>
        <p>Generated on {{ \Carbon\Carbon::now()->format('F d, Y h:i A') }}</p>
    </div>

    <!-- Metadata -->
    <div class="meta">
        <p><strong>Total Records:</strong> {{ $violations->count() }}</p>
    </div>

    <!-- Table of Violations -->
    <table>
        <thead>
            <tr>
                <th>Student No.</th>
                <th>Name</th>
                <th>Course</th>
                <th>Year</th>
                <th>Type</th>
                <th>Details</th>
                <th>Date</th>
                <th>Penalty</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($violations as $v)
                <tr>
                    <td>{{ $v->student->student_no ?? 'N/A' }}</td>
                    <td>{{ $v->student->first_name ?? 'N/A' }} {{ $v->student->last_name ?? '' }}</td>
                    <td>{{ $v->course?->course_code ?? 'N/A' }}</td>
                    <td>{{ $v->year_level }}</td>
                    <td>{{ $v->type }}</td>
                    <td>{{ $v->details }}</td>
                    <td>{{ \Carbon\Carbon::parse($v->violation_date)->format('M d, Y') }}</td>
                    <td>{{ $v->penalty }}</td>
                    <td>{{ $v->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary Section -->
    <div class="summary">
        <h3>Report Summary</h3>
        <table>
            <tr>
                <th>Total Pending</th>
                <td>{{ $violations->where('status', 'Pending')->count() }}</td>
            </tr>
            <tr>
                <th>Total Disclosed</th>
                <td>{{ $violations->where('status', 'Disclosed')->count() }}</td>
            </tr>
            <tr>
                <th>Total Major Violations</th>
                <td>{{ $violations->where('type', 'Major')->count() }}</td>
            </tr>
            <tr>
                <th>Total Minor Violations</th>
                <td>{{ $violations->where('type', 'Minor')->count() }}</td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Violation Module — Generated PDF Report</p>
    </div>
</body>
</html>

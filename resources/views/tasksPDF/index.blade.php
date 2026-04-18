<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .chart-container { text-align: center; margin-bottom: 30px; border: 1px solid #eee; padding: 10px; }
        .chart-image { width: 100%; max-width: 600px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; }
        th, td { border: 1px solid #e2e8f0; padding: 10px; text-align: left; }
        th { background-color: #f8fafc; color: #64748b; text-transform: uppercase; font-size: 10px; }
        .status-done { color: #10b981; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Weekly Task Completion Report</h2>
        <p>User: {{ auth()->user()->name }} | Date: {{ now()->format('d M, Y') }}</p>
    </div>

    <div class="chart-container">
        <h3>Weekly Performance Overview</h3>
        @if($chartImage)
            <img src="{{ $chartImage }}" class="chart-image">
        @endif
    </div>

    <h3>Task Details</h3>
    <table>
        <thead>
            <tr>
                <th>name</th>
                <th>Title</th>
                <th>Status</th>
                <th>Updated</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->user->name ?? 'Unknown' }}</td>
                <td>{{ $task->title }}</td>
                <td class="{{ $task->status == 'completed' ? 'status-done' : '' }}">
                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                </td>
                <td>{{ $task->updated_at->format('d/m/y') }}</td>
                <td>{{ $task->due_date->format('d/m/y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

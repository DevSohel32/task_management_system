<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page { margin: 40px; }
        body { font-family: 'Helvetica', sans-serif; color: #1e293b; line-height: 1.5; background-color: #fff; }

        /* Header Section */
        .header { border-bottom: 2px solid #2563eb; padding-bottom: 15px; margin-bottom: 25px; }
        .header h2 { color: #2563eb; margin: 0; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 5px 0 0; color: #64748b; font-size: 13px; }

        /* Stats Summary Table (Fixed width cards) */
        .stats-table { width: 100%; border-collapse: separate; border-spacing: 10px 0; margin-bottom: 30px; }
        .stat-card { background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0; text-align: center; }
        .stat-label { font-size: 10px; color: #64748b; text-transform: uppercase; font-weight: bold; display: block; margin-bottom: 5px; }
        .stat-value { font-size: 20px; font-weight: bold; color: #0f172a; display: block; }

        /* Chart Section */
        .chart-section { text-align: center; margin-bottom: 35px; }
        .chart-box { border: 1px solid #f1f5f9; padding: 15px; border-radius: 12px; background: #fff; }
        .chart-image { width: 100%; max-width: 450px; height: auto; }
        .section-title { font-size: 14px; font-weight: bold; color: #334155; margin-bottom: 15px; border-left: 4px solid #2563eb; padding-left: 10px; }

        /* Data Table */
        table.task-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .task-table th { background-color: #f1f5f9; color: #475569; font-size: 10px; text-transform: uppercase; padding: 12px 10px; border-bottom: 2px solid #e2e8f0; text-align: left; }
        .task-table td { padding: 12px 10px; border-bottom: 1px solid #f1f5f9; font-size: 11px; color: #334155; }

        /* Status Badge */
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 9px; font-weight: bold; text-transform: uppercase; }
        .status-completed { background-color: #dcfce7; color: #15803d; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-in-progress { background-color: #dbeafe; color: #1e40af; }

        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #94a3b8; border-top: 1px solid #f1f5f9; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Taskflow Analytics Report</h2>
        <p>User: <strong>{{ auth()->user()->name }}</strong> | Generated: {{ now()->format('d M, Y h:i A') }}</p>
    </div>

    <table class="stats-table">
        <tr>
            <td width="25%">
                <div class="stat-card">
                    <span class="stat-label">Total Tasks</span>
                    <span class="stat-value">{{ $total }}</span>
                </div>
            </td>
            <td width="25%">
                <div class="stat-card">
                    <span class="stat-label">Completed</span>
                    <span class="stat-value" style="color: #10b981;">{{ $completed }}</span>
                </div>
            </td>
            <td width="25%">
                <div class="stat-card">
                    <span class="stat-label">Pending</span>
                    <span class="stat-value" style="color: #f59e0b;">{{ $pending }}</span>
                </div>
            </td>
            <td width="25%">
                <div class="stat-card" style="background: #2563eb; border: none;">
                    <span class="stat-label" style="color: #bfdbfe;">Success Rate</span>
                    <span class="stat-value" style="color: #fff;">{{ $completionRate }}%</span>
                </div>
            </td>
        </tr>
    </table>

    @if(isset($chartImage) && $chartImage)
    <div class="chart-section">
        <div class="section-title">Weekly Performance Overview</div>
        <div class="chart-box">
            <img src="{{ $chartImage }}" class="chart-image">
        </div>
    </div>
    @endif

    <div class="section-title">Detailed Task List</div>
    <table class="task-table">
        <thead>
            <tr>
                <th width="40%">Task Title</th>
                <th width="20%">Status</th>
                <th width="20%">Assignee</th>
                <th width="20%">Due Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td><strong>{{ $task->title }}</strong></td>
                <td>
                    <span class="badge status-{{ str_replace('_', '-', $task->status) }}">
                        {{ str_replace('_', ' ', $task->status) }}
                    </span>
                </td>
                <td>{{ $task->user->name ?? 'Unassigned' }}</td>
                <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M, Y') : 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        © 2026 Qtec Workspace - Generated by Md Sujauddoula Sohel
    </div>
</body>
</html>

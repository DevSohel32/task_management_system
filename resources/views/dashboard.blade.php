@extends('layouts.master')
@section('content')
    <nav class="sticky-nav flex justify-between items-center px-6 lg:px-10 py-4 mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
        <div class="flex items-center gap-3">
            <form id="export-pdf-form" action="{{ route('tasks.downloadPDF') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="chart_image" id="chart_image_input">
            </form>
            <button onclick="exportWithChart()"
                class="btn btn-sm h-10 bg-white border-slate-200 text-slate-600 px-4 rounded-lg flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-file-pdf text-red-500"></i>
                Export PDF Report
            </button>
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button"
                    class="btn btn-ghost btn-circle avatar border-none hover:bg-slate-100 transition-all">
                    <div class="avatar placeholder">
                        <div
                            class="bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center ring ring-blue-100">
                            <span class="text-sm font-bold uppercase">
                                {{ Auth::user() ? strtoupper(substr(Auth::user()->name, 0, 2)) : '??' }}
                            </span>
                        </div>
                    </div>
                </div>

                <ul tabindex="-1"
                    class="menu menu-sm dropdown-content bg-white rounded-2xl z-[99] mt-3 w-56 p-2 shadow-xl border border-slate-100">
                    <div class="px-4 py-3 border-b border-slate-50 mb-1">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Account</p>
                        <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <li>
                        <a href="{{ route('my_tasks') }}"
                            class="py-2.5 flex items-center gap-2 hover:bg-slate-50 rounded-lg">
                            <i class="fa-regular fa-circle-check text-slate-400"></i> My Tasks
                        </a>
                    </li>
                    <div class="border-t border-slate-50 mt-1 pt-1">
                        <li>
                            <a href="{{ route('logout') }}"
                                class="py-2.5 text-error hover:bg-red-50 rounded-lg flex items-center gap-2"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </a>
                        </li>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
    </nav>

    <div class="px-6 lg:px-10 pb-10">
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Total Tasks</p>
                <h2 class="text-3xl font-bold text-[#2563EB]">{{ $totalTasks }}</h2>
                <p class="text-xs {{ $monthGrowth >= 0 ? 'text-emerald-500' : 'text-red-500' }} font-semibold mt-1">
                    {{ $monthGrowth >= 0 ? '↗' : '↘' }} {{ $monthGrowth >= 0 ? '+' : '' }}{{ $monthGrowth }}% this month
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Completed</p>
                <h2 class="text-3xl font-bold text-emerald-500">{{ $completedTasks }}</h2>
                <p class="text-xs text-emerald-500 font-semibold mt-1">↗ {{ $completionRate }}% rate</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">In Progress</p>
                <h2 class="text-3xl font-bold text-slate-800">{{ $inProgressTasks }}</h2>
                <p class="text-xs text-slate-400 mt-1 italic">Active on current sprint</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-red-400 uppercase tracking-wider mb-2">Overdue</p>
                <h2 class="text-3xl font-bold text-red-500">{{ $overdueTasks }}</h2>
                <p class="text-xs text-red-400 font-semibold mt-1">↘ Needs attention</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-6">Weekly task completion</h3>
                <div class="h-64">
                    <canvas id="weeklyChart"></canvas>
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-6">Status breakdown</h3>
                <div class="h-64">
                    <canvas id="statusDonutChart"></canvas>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <h3 class="font-bold text-slate-800 mb-6 px-2">Team performance</h3>
                <table class="table w-full">
                    <thead>
                        <tr class="text-[10px] text-slate-400 uppercase border-none">
                            <th>Member</th>
                            <th>Done</th>
                            <th>Progress</th>
                            <th class="text-right">Rate</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600">
                        @foreach ($teamMembers as $member)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center ring ring-blue-100">
                                            <span class="text-sm font-bold uppercase">
                                                {{ Auth::user() ? strtoupper(substr(Auth::user()->name, 0, 2)) : '??' }}
                                            </span>
                                        </div>
                                        <span class="font-bold">{{ $member->name }}</span>
                                    </div>
                                </td>
                                {{-- Updated to use total_tasks_count from controller --}}
                                <td>{{ $member->completed_tasks_count }}/{{ $member->total_tasks_count }}</td>
                                <td>
                                    <progress class="progress progress-primary h-1.5 w-full" value="{{ $member->rate }}"
                                        max="100"></progress>
                                </td>
                                <td class="text-right font-bold">{{ $member->rate }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-6">Recent activity</h3>
                <div class="space-y-6">
                    @foreach ($allTasks as $task)
                        <div class="flex gap-4">
                            @if ($task->status === 'completed')
                                <span
                                    class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                            @elseif ($task->status === 'in_progress')
                                <span class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></span>
                            @else
                                <span class="w-2 h-2 rounded-full bg-amber-500 mt-1.5 shadow-[0_0_8px_rgba(245,158,11,0.5)]"></span>
                            @endif

                            <div>
                                <p class="text-sm text-slate-700">
                                    <span class="font-semibold">{{ $task->user->name ?? 'Someone' }}</span>
                                    updated
                                    <span class="font-bold text-slate-900">"{{ $task->title }}"</span>
                                </p>
                                <p class="text-[11px] text-slate-400 mt-1">
                                    <span class="capitalize">{{ str_replace('_', ' ', $task->status) }}</span> •
                                    {{ $task->updated_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Weekly Completion Bar Chart
            new Chart(document.getElementById('weeklyChart'), {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Completed',
                        data: [{{ $chartData['completed'] }}],
                        backgroundColor: '#2563EB',
                        borderRadius: 6,
                        barThickness: 12
                    },
                    {
                        label: 'In Progress',
                        data: [{{ $chartData['in_progress'] }}],
                        backgroundColor: '#BFDBFE',
                        borderRadius: 6,
                        barThickness: 12
                    },
                    {
                        label: 'Pending',
                        data: [{{ $chartData['pending'] }}],
                        backgroundColor: '#FBBF24',
                        borderRadius: 6,
                        barThickness: 12
                    }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                color: '#F1F5F9'
                            },
                            ticks: {
                                font: {
                                    size: 10
                                },
                                color: '#94A3B8'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                },
                                color: '#94A3B8'
                            }
                        }
                    }
                }
            });

            // 2. Status Donut Chart
            new Chart(document.getElementById('statusDonutChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'In Progress', 'Pending'],
                    datasets: [{
                        data: [
                                {{ $chartData['completed'] ?? 0 }},
                                {{ $chartData['in_progress'] ?? 0 }},
                            {{ $chartData['pending'] ?? 0 }}
                        ],
                        backgroundColor: ['#10B981', '#3B82F6', '#FBBF24'],
                        borderWidth: 0,
                        cutout: '75%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });

        function exportWithChart() {
            const chartCanvas = document.getElementById('weeklyChart');
            const chartImage = chartCanvas.toDataURL('image/png');
            document.getElementById('chart_image_input').value = chartImage;
            document.getElementById('export-pdf-form').submit();
        }
    </script>
@endpush

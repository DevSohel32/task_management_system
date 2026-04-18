@extends('layouts.master')
@section('content')
    <nav class="sticky-nav flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
        <h1 class="text-3xl font-bold text-slate-900 shrink-0">All Tasks</h1>
        <div class="flex items-center gap-4 w-full justify-end">

            <div class="relative w-full max-w-md hidden md:block">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" id="taskSearchInput" placeholder="Search tasks..."
                    class="input input-sm h-10 w-full pl-10 bg-slate-100 border-none rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 transition-all text-sm" />
            </div>

            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button"
                    class="btn btn-ghost btn-circle avatar border-none hover:bg-slate-100 transition-all">
                    <div class="avatar placeholder">
                        <div
                            class="bg-blue-600 text-white rounded-full w-10 h-10 flex items-center justify-center ring ring-blue-100 shadow-sm">
                            <span class="text-sm font-bold uppercase">
                                {{ Auth::user() ? strtoupper(substr(Auth::user()->name, 0, 2)) : '??' }}
                            </span>
                        </div>
                    </div>
                </div>

                <ul tabindex="-1"
                    class="menu menu-sm dropdown-content bg-white rounded-2xl z-[99] mt-3 w-60 p-2 shadow-2xl border border-slate-100">
                    <div class="px-4 py-3 border-b border-slate-50 mb-1">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Account</p>
                        <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                    </div>

                    <li>
                        <a href="{{ route('my_tasks') }}"
                            class="py-2.5 flex items-center gap-3 hover:bg-slate-50 rounded-xl transition-colors">
                            <i class="fa-regular fa-circle-check text-slate-400 text-lg"></i>
                            <span class="font-medium">My Tasks</span>
                        </a>
                    </li>

                    <div class="border-t border-slate-50 mt-1 pt-1">
                        <li>
                            <a href="{{ route('logout') }}"
                                class="py-2.5 text-red-600 hover:bg-red-50 rounded-xl flex items-center gap-3 transition-colors"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket text-lg"></i>
                                <span class="font-semibold">Logout</span>
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
    <div class="px-6 lg:px-10 pb-10 ">
         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 pt-8">
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase mb-2">Total Tasks</p>
                <h2 class="text-3xl font-bold text-[#2563EB]">{{ $totalTasks }}</h2>
                <p class="text-xs text-slate-400 mt-1">This sprint</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase mb-2">Pending</p>
                <h2 class="text-3xl font-bold text-slate-800">{{ $totalPendingTasks }}</h2>
                <p class="text-xs text-slate-400 mt-1 italic">Awaiting start</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase mb-2">In Progress</p>
                <h2 class="text-3xl font-bold text-blue-500">{{ $totalInProgressTasks }}</h2>
                <p class="text-xs text-slate-400 mt-1 italic">Active now</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase mb-2">Completed</p>
                <h2 class="text-3xl font-bold text-emerald-500">{{ $totalCompletedTasks }}</h2>
                <p class="text-xs text-slate-400 mt-1 italic">Delivered</p>
            </div>
        </div>
    </div>
    <div class="px-6 lg:px-10 pb-10">
        <div x-data="{ filter: 'all' }" class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex justify-between items-center px-6 pt-6 pb-2 border-b border-slate-100 mb-6">
                <h2 class="font-bold text-slate-900">All Tasks</h2>

                <div class="tabs tabs-bordered flex gap-2">
                    <a @click="filter = 'all'"
                        :class="filter === 'all' ? 'tab-active font-bold' : 'text-slate-400 font-medium'"
                        class="tab tab-sm px-4 h-10 cursor-pointer">All</a>

                    <a @click="filter = 'pending'"
                        :class="filter === 'pending' ? 'tab-active font-bold' : 'text-slate-400 font-medium'"
                        class="tab tab-sm px-4 h-10 cursor-pointer hover:text-slate-600">Pending</a>

                    <a @click="filter = 'in_progress'"
                        :class="filter === 'in_progress' ? 'tab-active font-bold' : 'text-slate-400 font-medium'"
                        class="tab tab-sm px-4 h-10 cursor-pointer hover:text-slate-600">In Progress</a>

                    <a @click="filter = 'completed'"
                        :class="filter === 'completed' ? 'tab-active font-bold' : 'text-slate-400 font-medium'"
                        class="tab tab-sm px-4 h-10 cursor-pointer hover:text-slate-600">Completed</a>
                </div>
            </div>

            <div class="overflow-x-auto px-1 pb-4">
                <table class="table w-full text-sm">
                    <thead class="bg-slate-50/50">
                        <tr class="text-[10px] text-slate-400 uppercase border-b border-slate-100">
                            <th>Task</th>
                            <th>Status</th>
                            <th class="text-center">Priority</th>
                            <th>Assignee</th>
                            <th>Due Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="text-slate-700">
                        @foreach ($tasks as $task)
                            <tr x-show="filter === 'all' || filter === '{{ $task->status }}'"
                                class="border-b border-slate-50" x-transition.opacity>
                                <td>
                                    <div class="flex flex-col">
                                        <label for="task-modal-{{ $task->id }}" class="cursor-pointer">
                                            <h3
                                                class="font-bold text-slate-800 text-[15px] mb-1 hover:text-blue-600 transition-colors">
                                                {{ $task->title }}
                                            </h3>
                                        </label>


                                        {{-- modal for viewing task details --}}
                                        <input type="checkbox" id="task-modal-{{ $task->id }}" class="modal-toggle" />
                                        <div class="modal" role="dialog">
                                            <div class="modal-box bg-white max-w-2xl">
                                                <div class="flex justify-between items-start border-b pb-4 mb-4">
                                                    <h3 class="text-xl font-bold text-slate-800">{{ $task->title }}</h3>
                                                    <label for="task-modal-{{ $task->id }}"
                                                        class="btn btn-sm btn-circle btn-ghost">✕</label>
                                                </div>

                                                <div class="space-y-4">
                                                    <div class="flex gap-2">
                                                        <span
                                                            class="px-3 py-1 rounded-full text-xs font-bold {{ $task->status == 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                                                            Status: {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                        </span>
                                                        <span
                                                            class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                                            Priority:
                                                            @php
                                                                $priority = 'low';
                                                                if ($task->due_date) {
                                                                    $today = \Carbon\Carbon::today()->day;
                                                                    $due_date = \Carbon\Carbon::parse($task->due_date)
                                                                        ->day;
                                                                    $diff = $due_date - $today;
                                                                    if ($diff >= 0 && $diff <= 3) {
                                                                        $priority = 'high';
                                                                    } elseif ($diff >= 4 && $diff <= 5) {
                                                                        $priority = 'medium';
                                                                    } else {
                                                                        $priority = 'low';
                                                                    }
                                                                }
                                                            @endphp

                                                            {{-- Design onujayi priority show kora --}}
                                                            @if ($priority === 'high')
                                                                High
                                                            @elseif ($priority === 'medium')
                                                                Medium
                                                            @else
                                                                Low
                                                            @endif
                                                        </span>
                                                    </div>

                                                    <div>
                                                        <h4 class="text-sm font-semibold text-slate-600 mb-1">Description:
                                                        </h4>
                                                        <p class="text-slate-500 text-sm leading-relaxed">
                                                            {{ $task->description ?? 'No description provided.' }}
                                                        </p>
                                                    </div>

                                                    <div class="pt-4 border-t flex justify-between text-xs text-slate-400">
                                                        <span>Created:
                                                            {{ $task->created_at->format('M d, Y h:i A') }}</span>
                                                        <span>Last Updated: {{ $task->updated_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>

                                                <div class="modal-action">
                                                    <label for="task-modal-{{ $task->id }}"
                                                        class="btn btn-primary text-white">Close</label>
                                                </div>
                                            </div>
                                            <label class="modal-backdrop"
                                                for="task-modal-{{ $task->id }}">Close</label>
                                        </div>
                                        <p class="text-[13px] text-slate-500 leading-relaxed">
                                            @php
                                                $words = explode(' ', $task->description ?? '');
                                                $limitedWords = array_slice($words, 0, 20);
                                                $chunks = array_chunk($limitedWords, 10);
                                            @endphp
                                            @foreach ($chunks as $chunk)
                                                {{ implode(' ', $chunk) }}
                                                @if (!$loop->last)
                                                    <br>
                                                @endif
                                            @endforeach
                                            @if (count($words) > 20)
                                                ...
                                            @endif
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    @if ($task->status === 'completed')
                                        <span
                                            class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 px-3 py-1 rounded-full w-28 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Completed
                                        </span>
                                    @elseif ($task->status === 'in_progress')
                                        <span
                                            class="flex items-center gap-1.5 text-[10px] font-bold text-blue-600 px-3 py-1 rounded-full w-28 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> In Progress
                                        </span>
                                    @else
                                        <span
                                            class="flex items-center gap-1.5 text-[10px] font-bold text-orange-600 px-3 py-1 rounded-full w-28 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php
                                        $priority = 'low';
                                        if ($task->due_date) {
                                            $today = \Carbon\Carbon::today()->day;
                                            $due_date = \Carbon\Carbon::parse($task->due_date)->day;
                                            $diff = $due_date - $today;
                                            if ($diff >= 0 && $diff <= 3) {
                                                $priority = 'high';
                                            } elseif ($diff >= 4 && $diff <= 5) {
                                                $priority = 'medium';
                                            } else {
                                                $priority = 'low';
                                            }
                                        }
                                    @endphp

                                    {{-- Design onujayi priority show kora --}}
                                    @if ($priority === 'high')
                                        <span
                                            class="text-[11px] font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded-full flex items-center gap-0.5">
                                            <i class="fa-solid fa-angles-up"></i> High
                                        </span>
                                    @elseif ($priority === 'medium')
                                        <span
                                            class="text-[11px] font-bold text-yellow-600 bg-yellow-50 px-2 py-0.5 rounded-full flex items-center gap-0.5">
                                            <i class="fa-solid fa-equals"></i> Medium
                                        </span>
                                    @else
                                        <span
                                            class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full flex items-center gap-0.5">
                                            <i class="fa-solid fa-angles-down"></i> Low
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="avatar placeholder">
                                            <div
                                                class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center">
                                                <span
                                                    class="text-[10px]">{{ $task->user ? Str::limit($task->user->name, 2, '') : '??' }}</span>
                                            </div>
                                        </div>
                                        <span class="text-sm font-bold">{{ $task->user->name ?? 'Unassigned' }}</span>
                                    </div>
                                </td>
                                <td class="text-slate-400">{{ $task->due_date->format('d M') }}</td>

                                <td class="px-6 py-4">
                                    @if ($task->user_id === auth()->id())
                                        <div class="flex items-center justify-center gap-2">
                                            <label for="task-edit-{{ $task->id }}"
                                                class="p-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all cursor-pointer shadow-sm">
                                                <i class="fa-solid fa-pen text-[10px]"></i>
                                            </label>

                                            <input type="checkbox" id="task-edit-{{ $task->id }}"
                                                class="modal-toggle" />
                                            <div class="modal" role="dialog">
                                                <div
                                                    class="modal-box p-0 max-w-xl bg-white rounded-2xl overflow-hidden shadow-2xl border-none">
                                                    <div
                                                        class="flex justify-between items-center p-6 border-b border-slate-100 bg-slate-50/50">
                                                        <h3
                                                            class="font-bold text-xl text-slate-800 flex items-center gap-2">
                                                            <i class="fa-solid fa-pen-to-square text-blue-600"></i> Edit
                                                            Task
                                                        </h3>
                                                        <label for="task-edit-{{ $task->id }}"
                                                            class="btn btn-sm btn-circle btn-ghost">✕</label>
                                                    </div>

                                                    <form action="{{ route('my_task_store', $task->id) }}" method="POST"
                                                        class="p-8 space-y-6">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="form-control">
                                                            <label class="label font-bold text-slate-700">Task Title <span
                                                                    class="text-red-500">*</span></label>
                                                            <input type="text" name="title"
                                                                value="{{ old('title', $task->title) }}"
                                                                class="input input-bordered w-full bg-slate-50 border-slate-200 focus:ring-2 focus:ring-blue-500 transition-all"
                                                                required />
                                                        </div>

                                                        <div class="form-control">
                                                            <label
                                                                class="label font-bold text-slate-700">Description</label>
                                                            <textarea name="description"
                                                                class="textarea textarea-bordered w-full h-32 bg-slate-50 border-slate-200 focus:ring-2 focus:ring-blue-500">{{ old('description', $task->description) }}</textarea>
                                                        </div>

                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                            <div class="form-control">
                                                                <label
                                                                    class="label font-bold text-slate-700">Status</label>
                                                                <select name="status"
                                                                    class="select select-bordered w-full bg-slate-50 border-slate-200">
                                                                    <option value="pending"
                                                                        {{ $task->status == 'pending' ? 'selected' : '' }}>
                                                                        Pending</option>
                                                                    <option value="in_progress"
                                                                        {{ $task->status == 'in_progress' ? 'selected' : '' }}>
                                                                        In Progress</option>
                                                                    <option value="completed"
                                                                        {{ $task->status == 'completed' ? 'selected' : '' }}>
                                                                        Completed</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-control">
                                                                <label class="label font-bold text-slate-700">Due
                                                                    Date</label>
                                                                <input type="date" name="due_date"
                                                                    value="{{ old('due_date', $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}"
                                                                    class="input input-bordered w-full bg-slate-50 border-slate-200" />
                                                            </div>
                                                        </div>

                                                        <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                                                            <label for="task-edit-{{ $task->id }}"
                                                                class="btn btn-ghost px-6 font-bold">Cancel</label>
                                                            <button type="submit"
                                                                class="btn bg-[#2563EB] hover:bg-blue-700 text-white border-none px-10 shadow-lg shadow-blue-200">
                                                                Update Task
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <label class="modal-backdrop"
                                                    for="task-edit-{{ $task->id }}">Close</label>
                                            </div>

                                            <form id="delete-form-{{ $task->id }}"
                                                action="{{ route('my_task_destroy', $task->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete({{ $task->id }})"
                                                    class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                                    <i class="fa-solid fa-trash text-[10px]"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 italic">View Only</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>

        </div>
        <div class="mt-4">
            {{ $tasks->links() }}
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        document.getElementById('taskSearchInput').addEventListener('keyup', function() {
            let searchTerm = this.value.toLowerCase();
            let rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                let titleText = row.querySelector('h3') ? row.querySelector('h3').innerText.toLowerCase() :
                    '';
                let userName = row.querySelector('.avatar + span') ? row.querySelector('.avatar + span')
                    .innerText.toLowerCase() : '';
                if (titleText.includes(searchTerm) || userName.includes(searchTerm)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#2563EB',
            });
        @endif


        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `
                                <ul style="text-align: left;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            `,
                confirmButtonColor: '#2563EB',
            });

            const modal = document.getElementById('add_task_modal');
            if (modal) {
                modal.showModal();
            }
        @endif

        function toggleView(viewType) {
            const boardView = document.getElementById('board-view');
            const listView = document.getElementById('list-view');
            const boardBtn = document.getElementById('board-btn');
            const listBtn = document.getElementById('list-btn');

            if (viewType === 'board') {
                boardView.classList.remove('hidden');
                listView.classList.add('hidden');
                boardBtn.classList.add('bg-blue-50', 'text-[#2563EB]');
                boardBtn.classList.remove('btn-ghost', 'text-slate-400');

                listBtn.classList.add('btn-ghost', 'text-slate-400');
                listBtn.classList.remove('bg-blue-50', 'text-[#2563EB]');
            } else {
                listView.classList.remove('hidden');
                boardView.classList.add('hidden');
                listBtn.classList.add('bg-blue-50', 'text-[#2563EB]');
                listBtn.classList.remove('btn-ghost', 'text-slate-400');

                boardBtn.classList.add('btn-ghost', 'text-slate-400');
                boardBtn.classList.remove('bg-blue-50', 'text-[#2563EB]');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {

            @if ($errors->any())
                const modal = document.getElementById('add_task_modal');
                if (modal) {
                    modal.showModal();
                }
            @endif
        });
















        document.addEventListener('DOMContentLoaded', function() {
            // 1. Weekly Completion Bar Chart
            new Chart(document.getElementById('weeklyChart'), {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                            label: 'Completed',
                            data: [3, 5, 2, 6, 4, 1, 2],
                            backgroundColor: '#2563EB',
                            borderRadius: 6,
                            barThickness: 12
                        },
                        {
                            label: 'In Progress',
                            data: [2, 3, 4, 2, 3, 1, 1],
                            backgroundColor: '#BFDBFE',
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
                        data: [67, 21, 12],
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
    </script>
@endpush

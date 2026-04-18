@extends('layouts.master')
@section('content')

    <nav class="sticky-nav flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
        <div class="flex items-center gap-4">
            <h1 class="text-3xl font-bold text-slate-900">My Tasks</h1>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="add_task_modal.showModal()"
                class="btn btn-sm h-10 bg-[#2563EB] hover:bg-blue-700 border-none text-white normal-case px-4 rounded-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                </svg>
                Add Task
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
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
            <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Tasks</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-[#2563EB]">{{ $totalTasks }}</span>
                    <span class="text-xs text-slate-400 font-medium">This sprint</span>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">In Progress</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-blue-500">{{ $totalInProgressTasks }}</span>
                    <span class="text-xs text-slate-400 font-medium text-success">Active now</span>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Completed</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-emerald-500">{{ $totalCompletedTasks }}</span>
                    <span class="text-xs text-slate-400 font-medium">Done</span>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pending</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-orange-400">{{ $totalPendingTasks }}</span>
                    <span class="text-xs text-slate-400 font-medium">Awaiting start</span>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center mb-6">
            <h2 class="font-bold text-slate-800 text-3xl">Task board</h2>
            <div class="join border border-slate-200 bg-white">
                <button id="board-btn" onclick="toggleView('board')"
                    class="btn p-4 join-item bg-blue-50 text-[#2563EB] border-none">Board</button>
                <button id="list-btn" onclick="toggleView('list')"
                    class="btn p-4 join-item btn-ghost text-slate-400 border-none">List</button>
            </div>
        </div>


        {{-- task board items --}}
        <div id="board-view" class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            @if ($tasks->isEmpty())
                <div
                    class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border-2 border-dashed border-slate-200">
                    <div class="bg-slate-50 p-4 rounded-full mb-4">
                        <i class="fa-solid fa-clipboard-list text-4xl text-slate-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700">You have not created any tasks yet</h3>
                    <p class="text-slate-500 mb-6">Start organizing your work by creating your first task.</p>
                    <button onclick="add_task_modal.showModal()"
                        class="btn bg-blue-600 hover:bg-blue-700 text-white border-none px-6">
                        <i class="fa-solid fa-plus mr-2"></i> Create Task
                    </button>
                </div>
            @else
                @php
                    $statuses = [
                        'pending' => ['label' => 'Pending', 'color' => 'bg-slate-400'],
                        'in_progress' => ['label' => 'In Progress', 'color' => 'bg-blue-500'],
                        'completed' => ['label' => 'Completed', 'color' => 'bg-emerald-500'],
                    ];
                @endphp

                @foreach ($statuses as $key => $status)
                    <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-2xl p-4 w-full space-y-4">

                        <div class="flex justify-between items-center px-1 mb-2">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full {{ $status['color'] }}"></span>
                                <span class="font-bold text-sm text-slate-700">{{ $status['label'] }}</span>
                                <span class="text-slate-400 text-xs font-bold ml-1">
                                    {{ $tasks->where('status', $key)->count() }}
                                </span>
                            </div>
                            <button onclick="add_task_modal.showModal()"
                                class="btn btn-xs btn-ghost border border-slate-200 bg-white hover:bg-slate-50 text-slate-400 rounded-lg p-0 h-7 w-7 flex items-center justify-center">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>

                        @foreach ($tasks->where('status', $key) as $task)
                            <div
                                class="group relative bg-white p-4 rounded-2xl border-2 border-blue-200 shadow-sm transition-all cursor-pointer">

                                <div
                                    class="absolute top-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    @if ($task->status !== 'completed')
                                        {{-- Edit Trigger Label --}}
                                        <label for="task-edit-{{ $task->id }}"
                                            class="p-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 cursor-pointer">
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                        </label>
                                    @endif

                                    {{-- Modal for Editing Task --}}
                                    <input type="checkbox" id="task-edit-{{ $task->id }}" class="modal-toggle" />
                                    <div class="modal" role="dialog">
                                        <div class="modal-box p-0 max-w-xl bg-white rounded-2xl overflow-hidden shadow-2xl">
                                            <div class="flex justify-between items-center p-6 border-b border-slate-100">
                                                <h3 class="font-bold text-xl text-slate-800">Edit Task</h3>
                                                <label for="task-edit-{{ $task->id }}"
                                                    class="btn btn-sm btn-circle btn-ghost">✕</label>
                                            </div>
                                            <form action="{{ route('my_task_update', $task->id) }}" method="POST"
                                                class="p-8 space-y-6">
                                                @csrf
                                                @method('PUT')

                                                <div>
                                                    <label class="block text-sm font-bold text-slate-700 mb-2">Task title
                                                        <span class="text-red-500">*</span></label>
                                                    <input type="text" name="title"
                                                        value="{{ old('title', $task->title) }}"
                                                        class="input input-bordered w-full bg-[#F8FAFC] border-slate-200 focus:ring-2 focus:ring-blue-500 transition-all"
                                                        required />
                                                </div>

                                                <div>
                                                    <label
                                                        class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                                                    <textarea name="description" class="textarea textarea-bordered w-full h-28 bg-[#F8FAFC] border-slate-200">{{ old('description', $task->description) }}</textarea>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                    <div>
                                                        <label
                                                            class="block text-sm font-bold text-slate-700 mb-2">Status</label>
                                                        <select name="status"
                                                            class="select select-bordered w-full bg-[#F8FAFC] border-slate-200">
                                                            <option value="pending"
                                                                {{ $task->status == 'pending' ? 'selected' : '' }}>
                                                                Pending</option>
                                                            <option value="in_progress"
                                                                {{ $task->status == 'in_progress' ? 'selected' : '' }}>In
                                                                Progress</option>
                                                            <option value="completed"
                                                                {{ $task->status == 'completed' ? 'selected' : '' }}>
                                                                Completed</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-700 mb-2">Due
                                                            Date</label>
                                                        <input type="date" name="due_date"
                                                            value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
                                                            class="input input-bordered w-full bg-[#F8FAFC] border-slate-200" />
                                                    </div>
                                                </div>



                                                <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                                                    <label for="task-edit-{{ $task->id }}"
                                                        class="btn btn-ghost px-6 cursor-pointer">Cancel</label>
                                                    <button type="submit"
                                                        class="btn bg-[#2563EB] hover:bg-blue-700 text-white border-none px-10">
                                                        Update Task
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <label class="modal-backdrop" for="task-edit-{{ $task->id }}">Close</label>
                                    </div>
                                    <form id="delete-form-{{ $task->id }}"
                                        action="{{ route('my_task_destroy', $task->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $task->id }})"
                                            class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">
                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>

                                <label for="task-modal-{{ $task->id }}" class="cursor-pointer">
                                    <h3
                                        class="font-bold text-lg mb-1 hover:text-blue-600 transition-colors {{ $task->status === 'completed' ? 'text-slate-400 line-through' : 'text-slate-800' }}">
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
                                                        <span class="text-red-600">High</span>
                                                    @elseif ($priority === 'medium')
                                                        <span class="text-yellow-600">Medium</span>
                                                    @else
                                                        <span class="text-green-600">Low</span>
                                                    @endif
                                                </span>
                                            </div>

                                            <div>
                                                <h4 class="text-sm font-semibold text-slate-600 mb-1">Description:</h4>
                                                <p class="text-slate-500 text-sm leading-relaxed">
                                                    {{ $task->description ?? 'No description provided.' }}
                                                </p>
                                            </div>

                                            <div class="pt-4 border-t flex justify-between text-xs text-slate-400">
                                                <span>Created: {{ $task->created_at->format('M d, Y h:i A') }}</span>
                                                <span>Last Updated: {{ $task->updated_at->diffForHumans() }}</span>
                                            </div>
                                        </div>

                                        <div class="modal-action">
                                            <label for="task-modal-{{ $task->id }}"
                                                class="btn btn-primary text-white">Close</label>
                                        </div>
                                    </div>
                                    <label class="modal-backdrop" for="task-modal-{{ $task->id }}">Close</label>
                                </div>

                                <p class="text-[13px] text-slate-500 mb-4 line-clamp-2">{{ $task->description }}</p>

                                <div class="mb-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Status</label>
                                        <select name="status"
                                            class="status-select select select-bordered w-full bg-[#F8FAFC] border-slate-200"
                                            data-id="{{ $task->id }}">
                                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="in_progress"
                                                {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress
                                            </option>
                                            <option value="completed"
                                                {{ $task->status == 'completed' ? 'selected' : '' }}>Completed
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center mt-2">
                                    <div class="flex items-center gap-1 text-slate-400">
                                        <i class="fa-regular fa-calendar text-[11px]"></i>
                                        <span class="text-[11px] font-medium">
                                            Due: {{ $task->due_date ? $task->due_date->format('d M') : 'No Date' }}
                                        </span>
                                    </div>

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
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif

        </div>

        {{-- List items --}}
        <div id="list-view" class="flex flex-col w-full hidden">
            @foreach ($tasks as $task)
                <div
                    class="list-item-row grid grid-cols-[40px,1fr,120px,80px,80px,100px] items-center gap-4 px-6 py-4 border-b border-slate-50 transition-all cursor-pointer bg-white">

                    @if ($task->status === 'completed')
                        <div class="flex items-center justify-center">
                            <div class="w-5 h-5 bg-emerald-500 rounded flex items-center justify-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center">
                            <input type="checkbox" class="task-checkbox rounded border-slate-200"
                                data-id="{{ $task->id }}" />
                        </div>
                    @endif










                    <div class="flex flex-col min-w-0">
                        @if ($task->status === 'completed')
                            <h3 class="text-sm font-semibold text-slate-400 line-through">{{ $task->title }}</h3>
                        @else
                            <h3 class="text-sm font-semibold text-slate-800 truncate">{{ $task->title }}</h3>
                        @endif
                        <p class="text-xs text-slate-400 truncate">{{ $task->description }}</p>
                    </div>

                    <div class="flex justify-start">
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
                                class="flex items-center gap-1.5 text-[10px] font-bold text-orange-600  px-3 py-1 rounded-full w-28 whitespace-nowrap">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> Pending
                            </span>
                        @endif
                    </div>

                    <div>
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
                    </div>

                    <div class="text-xs text-slate-400 font-medium text-center">
                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M') : 'No due date' }}</div>

                    <div class="list-item-actions flex items-center justify-end gap-2">
                        @if ($task->status !== 'completed')
                            <button class="p-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        @endif
                        <button class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>


    </div>

    {{-- modal for adding new task --}}
    <dialog id="add_task_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box p-0 max-w-xl bg-white rounded-2xl overflow-hidden shadow-2xl">
            <div class="flex justify-between items-center p-6 border-b border-slate-100">
                <h3 class="font-bold text-xl text-slate-800">Add new task</h3>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost">✕</button>
                </form>
            </div>

            <form action="{{ route('my_task_store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">
                        Task title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        placeholder="e.g. Complete Laravel Schema Design"
                        class="input input-bordered w-full bg-[#F8FAFC] border-slate-200 focus:ring-2 focus:ring-blue-500 transition-all @error('title') border-red-500 @enderror" />
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                    <textarea name="description" placeholder="Provide a short summary of the task..."
                        class="textarea textarea-bordered w-full h-28 bg-[#F8FAFC] border-slate-200 focus:ring-2 focus:ring-blue-500 transition-all">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Status</label>
                        <select name="status" class="select select-bordered w-full bg-[#F8FAFC] border-slate-200"
                            data-id="{{ $task->id ?? '' }}">
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress
                            </option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Due Date</label>
                        <input type="date" name="due_date" value="{{ old('due_date') }}"
                            class="input input-bordered w-full bg-[#F8FAFC] border-slate-200 @error('due_date') border-red-500 @enderror" />
                        @error('due_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Assignee</label>
                        <div class="flex items-center gap-2 p-3 bg-slate-50 rounded-lg border border-slate-200">
                            <span class="text-sm text-slate-600 font-medium">{{ Auth::user()->name }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                    <button type="button" class="btn btn-ghost px-6">Cancel</button>
                    <button type="submit" class="btn bg-[#2563EB] hover:bg-blue-700 text-white border-none px-10">
                        Save Task
                    </button>
                </div>
            </form>

        </div>
        <form method="dialog" class="modal-backdrop bg-slate-900/40">
            <button>close</button>
        </form>
    </dialog>


@endsection

@push('scripts')
    <script>
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

        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                let taskId = this.getAttribute('data-id');
                let newStatus = this.value;


                axios.patch(`/tasks/${taskId}/update-status`, {
                        status: newStatus
                    })
                    .then(response => {

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });

                        Toast.fire({
                            icon: 'success',
                            title: response.data.message
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    })
                    .catch(error => {
                        console.error(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong while updating the status!',
                        });
                    });
            });
        });
        document.querySelectorAll('.task-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    let taskId = this.getAttribute('data-id');
                    let newStatus = 'completed';

                    axios.patch(`/tasks/${taskId}/update-status`, {
                            status: newStatus
                        })
                        .then(response => {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true
                            });

                            Toast.fire({
                                icon: 'success',
                                title: 'Task marked as completed!'
                            });

                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        })
                        .catch(error => {
                            console.error(error);
                            this.checked = false;
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Could not update task status.',
                            });
                        });
                }
            });
        });
    </script>
@endpush

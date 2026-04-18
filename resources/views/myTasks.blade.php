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
                    <span class="text-3xl font-bold text-[#2563EB]">                 </span>
                    <span class="text-xs text-slate-400 font-medium">This sprint</span>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">In Progress</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-blue-500">                   </span>
                    <span class="text-xs text-slate-400 font-medium text-success">Active now</span>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Completed</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-emerald-500">                  </span>
                    <span class="text-xs text-slate-400 font-medium">Done</span>
                </div>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pending</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-orange-400">              </span>
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

            <form action=" {{ route('my_task_store') }}       " method="POST" class="p-8 space-y-6">
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
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Due Date</label>
                        <input type="date" name="due_date" value="{{ old('due_date') }}"
                            class="input input-bordered w-full bg-[#F8FAFC] border-slate-200 @error('due_date') border-red-500 @enderror" />
                        @error('due_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#2563EB',
            });
        @endif


        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: `
                                        <ul style="text-align: left;">
                                            @foreach($errors->all() as $error)
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

        document.addEventListener('DOMContentLoaded', function () {

            @if ($errors->any())
                const modal = document.getElementById('add_task_modal');
                if (modal) {
                    modal.showModal();
                }
            @endif

        });

        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function () {
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
            checkbox.addEventListener('change', function () {
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

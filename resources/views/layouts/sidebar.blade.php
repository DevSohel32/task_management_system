<aside class="drawer-side z-64">
    <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
    <div class="menu p-4 w-64 min-h-full bg-[#0F172A] text-slate-400 flex flex-col">
        <div class="flex items-center gap-3 px-4 py-8 mb-4">
            <div class="bg-[#2563EB] p-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 002-2h2a2 2 0 002 2" />
                </svg>
            </div>
            <div>
                <span class="text-white font-bold text-xl block leading-none">Task Flow</span>
                <span class="text-[10px] uppercase tracking-widest opacity-40">Workspace</span>
            </div>
        </div>

        <ul class="space-y-1">
             <li><a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-3 rounded-lg hover:bg-slate-800 transition-colors {{ Request::is('dashboard') ? 'active' : '' }}">
                   <i class="fa-solid fa-chart-simple"></i>
                    Dashboard</a>
            </li>
            <li><a href="{{ route('all_tasks') }}" class="flex items-center gap-3 py-3 rounded-lg hover:bg-slate-800 transition-colors {{ Request::is('all-tasks') ? 'active' : '' }}">
                    <i class="fa-solid fa-bars"></i>
                    All Tasks</a>
            </li>
            <li><a href="{{ route('my_tasks') }}" class="flex items-center gap-3 py-3 rounded-lg {{ Request::is('my-tasks') ? 'active' : '' }}">
                    <i class="fa-regular fa-user"></i>
                    My Tasks</a>
            </li>
        </ul>

        <div class="mt-auto pt-6 border-t border-slate-800 flex items-center gap-3">
            <div class="avatar placeholder">
                <div class="bg-blue-600 text-white rounded-full w-10">
                    <span class="text-xs font-bold">AR</span>
                </div>
            </div>
            <div class="overflow-hidden">
                <p class="text-white text-sm font-bold truncate">Alex Rahman</p>
                <p class="text-[10px] opacity-50 truncate">Team Lead</p>
            </div>
        </div>
    </div>
</aside>

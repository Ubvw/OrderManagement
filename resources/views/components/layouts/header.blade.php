<header class="text-white px-8 py-6 flex items-center justify-between">
    <!-- Left Section - Brand -->
    <div class="flex items-center space-x-6">
        <!-- Logo/Brand Icon -->
        <div class="bg-gradient-to-br from-primary to-primary-dark p-3 rounded-2xl shadow-soft-lg shadow-primary/25">
            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
            </svg>
        </div>
        
        <!-- Brand Name -->
        <div>
            <h1 class="text-2xl font-black bg-gradient-to-r from-white to-slate-200 bg-clip-text text-transparent tracking-tight">
                Brew Coffee
            </h1>
            <p class="text-xs text-slate-400 font-semibold tracking-wide">Management System</p>
        </div>
    </div>

    <!-- Right Section - Actions & Profile -->
    <div class="flex items-center space-x-4">
        <!-- User Profile -->
        <div class="flex items-center space-x-3 bg-slate-700/30 hover:bg-slate-600/40 rounded-2xl px-5 py-3 transition-all duration-300 cursor-pointer group backdrop-blur-sm border border-slate-600/30 hover:border-slate-500/50">
            <div class="flex flex-col items-end">
                <span class="text-sm font-bold text-white group-hover:text-slate-100 tracking-wide">Admin User</span>
                <span class="text-xs text-slate-400 group-hover:text-slate-300 font-semibold">Administrator</span>
            </div>
            
            <!-- Avatar -->
            <div class="relative">
                <div class="w-11 h-11 bg-gradient-to-br from-primary to-primary-dark rounded-2xl flex items-center justify-center shadow-soft-lg shadow-primary/25 ring-2 ring-slate-600/30">
                    <span class="text-white text-sm font-black">AU</span>
                </div>
                <!-- Online Status -->
                <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-400 rounded-full border-2 border-slate-900 shadow-sm"></div>
            </div>

            <!-- Dropdown Arrow -->
            <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-300 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </div>
</header>
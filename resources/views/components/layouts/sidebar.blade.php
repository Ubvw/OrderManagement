<aside class="w-64 flex-shrink-0 p-6">
    <nav class="space-y-2">

    
        {{-- function so admin lang nakakakita sa dashboard--}}
        @php
            $role = auth()->user()->role->name ?? '';
        @endphp

        @if($role === 'Admin')
        <a href="/dashboard" class="group flex items-center space-x-4 px-4 py-3 rounded-2xl transition-all duration-300 {{ ($activeSection ?? '') === 'dashboard' ? 'text-white bg-gradient-to-r from-primary to-primary-dark shadow-soft-lg shadow-primary/25' : 'text-slate-300 hover:text-white hover:bg-slate-800/50 hover:shadow-md' }}">
            <div class="flex items-center justify-center w-10 h-10 rounded-xl {{ ($activeSection ?? '') === 'dashboard' ? 'bg-white/20 text-white shadow-inner' : 'bg-slate-800/50 text-slate-400 group-hover:bg-slate-700/50 group-hover:text-slate-200' }} transition-all duration-300">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                </svg>
            </div>
            <span class="font-semibold text-base">Dashboard</span>
            @if(($activeSection ?? '') === 'dashboard')
                <div class="w-1 h-8 bg-white/30 rounded-full ml-auto"></div>
            @endif
        </a>
        @endif

        <a href="/orders" class="group flex items-center space-x-4 px-4 py-3 rounded-2xl transition-all duration-300 {{ ($activeSection ?? '') === 'orders' ? 'text-white bg-gradient-to-r from-primary to-primary-dark shadow-soft-lg shadow-primary/25' : 'text-slate-300 hover:text-white hover:bg-slate-800/50 hover:shadow-md' }}">
            <div class="flex items-center justify-center w-10 h-10 rounded-xl {{ ($activeSection ?? '') === 'orders' ? 'bg-white/20 text-white shadow-inner' : 'bg-slate-800/50 text-slate-400 group-hover:bg-slate-700/50 group-hover:text-slate-200' }} transition-all duration-300">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1zm-3 3a1 1 0 100 2h.01a1 1 0 100-2H10zm-4 1a1 1 0 011-1h.01a1 1 0 110 2H7a1 1 0 01-1-1zm1-4a1 1 0 100 2h.01a1 1 0 100-2H7zm2 0a1 1 0 100 2h.01a1 1 0 100-2H9zm2 0a1 1 0 100 2h.01a1 1 0 100-2H11z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="font-semibold text-base">Orders</span>
            @if(($activeSection ?? '') === 'orders')
                <div class="w-1 h-8 bg-white/30 rounded-full ml-auto"></div>
            @endif
        </a>

        {{-- function so admin lang nakakakita --}}
        @if($role === 'Admin')
        <a href="/products" class="group flex items-center space-x-4 px-4 py-3 rounded-2xl transition-all duration-300 {{ ($activeSection ?? '') === 'products' ? 'text-white bg-gradient-to-r from-primary to-primary-dark shadow-soft-lg shadow-primary/25' : 'text-slate-300 hover:text-white hover:bg-slate-800/50 hover:shadow-md' }}">
            <div class="flex items-center justify-center w-10 h-10 rounded-xl {{ ($activeSection ?? '') === 'products' ? 'bg-white/20 text-white shadow-inner' : 'bg-slate-800/50 text-slate-400 group-hover:bg-slate-700/50 group-hover:text-slate-200' }} transition-all duration-300">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2L3 7v11a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V7l-7-5z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="font-semibold text-base">Products</span>
            @if(($activeSection ?? '') === 'products')
                <div class="w-1 h-8 bg-white/30 rounded-full ml-auto"></div>
            @endif
        </a>
        @endif

        @if($role === 'Admin')
        <a href="/reports" class="group flex items-center space-x-4 px-4 py-3 rounded-2xl transition-all duration-300 {{ ($activeSection ?? '') === 'reports' ? 'text-white bg-gradient-to-r from-primary to-primary-dark shadow-soft-lg shadow-primary/25' : 'text-slate-300 hover:text-white hover:bg-slate-800/50 hover:shadow-md' }}">
            <div class="flex items-center justify-center w-10 h-10 rounded-xl {{ ($activeSection ?? '') === 'reports' ? 'bg-white/20 text-white shadow-inner' : 'bg-slate-800/50 text-slate-400 group-hover:bg-slate-700/50 group-hover:text-slate-200' }} transition-all duration-300">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="font-semibold text-base">Reports</span>
            @if(($activeSection ?? '') === 'reports')
                <div class="w-1 h-8 bg-white/30 rounded-full ml-auto"></div>
            @endif
        </a>
        @endif

        @if($role === 'Admin')
        <a href="/users" class="group flex items-center space-x-4 px-4 py-3 rounded-2xl transition-all duration-300 {{ ($activeSection ?? '') === 'users' ? 'text-white bg-gradient-to-r from-primary to-primary-dark shadow-soft-lg shadow-primary/25' : 'text-slate-300 hover:text-white hover:bg-slate-800/50 hover:shadow-md' }}">
            <div class="flex items-center justify-center w-10 h-10 rounded-xl {{ ($activeSection ?? '') === 'users' ? 'bg-white/20 text-white shadow-inner' : 'bg-slate-800/50 text-slate-400 group-hover:bg-slate-700/50 group-hover:text-slate-200' }} transition-all duration-300">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                </svg>
            </div>
            <span class="font-semibold text-base">Users</span>
            @if(($activeSection ?? '') === 'users')
                <div class="w-1 h-8 bg-white/30 rounded-full ml-auto"></div>
            @endif
        </a>
        @endif

    </nav>
</aside>
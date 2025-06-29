<aside class="w-48 flex-shrink-0 bg-gradient-to-b from-primary-light via-primary to-primary-dark h-screen fixed left-0 top-0 z-10 flex flex-col items-center py-6" style="box-shadow: 2px 0 15px -5px rgba(0, 0, 0, 0.3);">
    {{-- Logo Section --}}
    <div class="mb-8">
        <div class="text-center">
            <div class="flex items-center">
                <img src="{{ asset('images/logo2.png') }}" alt="TasteOfHome" class="w-63 h-63">
            </div>
        </div>
    </div>

    {{-- User Profile Section --}}
    @php
        $role = auth()->user()->role->name ?? '';
        $roleInitials = match($role) {
            'Admin' => 'ADMIN',
            'Cashier' => 'CASHIER', 
            'Food Processor' => 'FOOD PROCESSOR',
            default => 'US'
        };
    @endphp
    
    <div class="mb-8">
        <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center shadow-lg">
            <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
        </div>
        <div class="text-center mt-2">
            <span class="text-white text-xs font-semibold">{{ $roleInitials }}</span>
        </div>
    </div>

    {{-- Navigation Menu --}}
    <nav class="flex flex-col space-y-4 flex-1">

        {{-- Dashboard - Admin only --}}
        @if($role === 'Admin')
        <a href="/dashboard" class="group flex flex-row items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-300 {{ ($activeSection ?? '') === 'dashboard' ? 'bg-white/90 shadow-lg text-primary-dark shadow-lg backdrop-blur-sm' : 'hover:bg-white/50' }}">
            <svg class="{{ ($activeSection ?? '') === 'dashboard' ? 'w-8 h-8 text-primary-dark mb-1' : 'w-8 h-8 text-white mb-1' }}" fill="currentColor" viewBox="0 0 24 24">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
            </svg>
            <span class="{{ ($activeSection ?? '') === 'dashboard' ? 'text-primary-dark text-s font-medium' : 'text-white text-s font-medium' }}">Dashboard</span>
        </a>
        @endif

        {{-- Reports - Admin only --}}
        @if($role === 'Admin')
        <a href="/reports" class="group flex flex-row items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-300 {{ ($activeSection ?? '') === 'reports' ? 'bg-white/90 shadow-lg text-primary-dark shadow-lg backdrop-blur-sm' : 'hover:bg-white/50' }}">
            <svg class="{{ ($activeSection ?? '') === 'reports' ? 'w-8 h-8 text-primary-dark mb-1' : 'w-8 h-8 text-white mb-1' }}" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
            </svg>
            <span class="{{ ($activeSection ?? '') === 'reports' ? 'text-primary-dark text-s font-medium' : 'text-white text-s font-medium' }}">Reports</span>
        </a>
        @endif

        {{-- Orders --}}
        <a href="/orders" class="group flex flex-row items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-300 {{ ($activeSection ?? '') === 'orders' ? 'bg-white/90 shadow-lg text-primary-dark shadow-lg backdrop-blur-sm' : 'hover:bg-white/50' }}">
            <svg class="{{ ($activeSection ?? '') === 'orders' ? 'w-8 h-8 text-primary-dark mb-1' : 'w-8 h-8 text-white mb-1' }}" fill="currentColor" viewBox="0 0 24 24">
                <path d="M7 18c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12L8.1 13h7.45c.75 0 1.41-.41 1.75-1.03L21.7 4H5.21l-.94-2H1zm16 16c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
            </svg>
            <span class="{{ ($activeSection ?? '') === 'orders' ? 'text-primary-dark text-s font-medium' : 'text-white text-s font-medium' }}">Orders</span>
        </a>

        {{-- Products - Admin only --}}
        @if($role === 'Admin')
        <a href="/products" class="group flex flex-row items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-300 {{ ($activeSection ?? '') === 'products' ? 'bg-white/90 shadow-lg text-primary-dark shadow-lg backdrop-blur-sm' : 'hover:bg-white/50' }}">
            <svg class="{{ ($activeSection ?? '') === 'products' ? 'w-8 h-8 text-primary-dark mb-1' : 'w-8 h-8 text-white mb-1' }}" fill="currentColor" viewBox="0 0 24 24">
                <path d="M2 17h20v2H2zm1.15-4.05L4 11l.85 1.95L6.8 13l-1.95.85L4 15.8l-.85-1.95L1.2 13l1.95-.85zM6.5 2L4 7h5l-2.5-5zM12 8c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm6 2h-4v4h4v-4z"/>
            </svg>
            <span class="{{ ($activeSection ?? '') === 'products' ? 'text-primary-dark text-s font-medium' : 'text-white text-s font-medium' }}">Menu</span>
        </a>
        @endif

        {{-- Users - Admin only --}}
        @if($role === 'Admin')
        <a href="/users" class="group flex flex-row items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-300 {{ ($activeSection ?? '') === 'users' ? 'bg-white/90 shadow-lg text-primary-dark shadow-lg backdrop-blur-sm' : 'hover:bg-white/50' }}">
            <svg class="{{ ($activeSection ?? '') === 'users' ? 'w-8 h-8 text-primary-dark mb-1' : 'w-8 h-8 text-white mb-1' }}" fill="currentColor" viewBox="0 0 24 24">
                <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A1.5 1.5 0 0 0 18.5 7H17c-.8 0-1.5.7-1.5 1.5v6c0 .8.7 1.5 1.5 1.5h1v6h2zM12.5 11.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5S11 9.17 11 10s.67 1.5 1.5 1.5zM5.5 6c1.11 0 2-.89 2-2s-.89-2-2-2-2 .89-2 2 .89 2 2 2zm2 16v-7H9V9c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v6h1.5v7h4z"/>
            </svg>
            <span class="{{ ($activeSection ?? '') === 'users' ? 'text-primary-dark text-s font-medium' : 'text-white text-s font-medium' }}">Users</span>
        </a>
        @endif

    </nav>

    {{-- Logout Section at Bottom --}}
    <div class="mt-auto">
        <form method="GET" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="group flex flex-row items-center space-x-3 p-3 rounded-xl transition-all duration-300 hover:bg-white/20">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                </svg>
                <span class="text-white text-s font-medium">Logout</span>
            </button>
        </form>
    </div>

</aside>
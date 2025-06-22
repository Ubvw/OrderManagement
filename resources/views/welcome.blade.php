<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodOrder - Sign In</title>
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Inter Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    {{-- Spline 3D Viewer --}}
    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.10.10/build/spline-viewer.js"></script>
    
    {{-- Custom Tailwind Config --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: '#FF6B35',
                        'primary-dark': '#E55A2B',
                        'primary-light': '#FF8A5B',
                    },
                    boxShadow: {
                        'glow-subtle': '0 0 20px rgba(255, 107, 53, 0.15)',
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.3)',
                        'soft-xl': '0 20px 25px -5px rgba(0, 0, 0, 0.4)',
                    },
                    animation: {
                        'float': 'float 4s ease-in-out infinite',
                        'fade-in': 'fadeIn 1s ease-out forwards',
                        'slide-up': 'slideUp 1s ease-out forwards',
                        'pulse-glow': 'pulseGlow 4s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-8px)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateX(50px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                        pulseGlow: {
                            '0%, 100%': { opacity: '0.3' },
                            '50%': { opacity: '0.6' },
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #000000;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 0px;
        }
        
        ::-webkit-scrollbar-track {
            background: #111111;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #FF6B35;
            border-radius: 3px;
        }
        
        /* Loading animation */
        .loading-spinner {
            border: 2px solid transparent;
            border-top: 2px solid #ffffff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Form focus effects */
        .form-input:focus {
            transform: translateY(-1px);
            box-shadow: 0 0 0 2px rgba(255, 107, 53, 0.3);
        }
        
        /* Spline viewer styling */
        spline-viewer {
            width: 100%;
            height: 100%;
            display: block;
            border-radius: 0;
            background: transparent;
        }
        
        /* Modern glass effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        /* Subtle text glow */
        .text-glow {
            text-shadow: 0 0 10px rgba(255, 107, 53, 0.2);
        }
        
        .robot-container {
            position: absolute;
            right: -300px; /* Extend beyond the container */
            top: 0;
            width: 150%;
            height: 100%;
        }

        /* Subtle grid pattern - very minimal */
        .minimal-grid {
            background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.02) 1px, transparent 0);
            background-size: 60px 60px;
        }
        
        /* Professional status indicator */
        .status-indicator {
            position: relative;
        }
        
        .status-indicator::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, rgba(255, 107, 53, 0.2), transparent, rgba(255, 107, 53, 0.1));
            border-radius: inherit;
            z-index: -1;
        }
    </style>
</head>

<body class="min-h-screen bg-black font-inter overflow-x-hidden minimal-grid">

    
    {{-- Clean Header --}}
    <header class="relative z-10 h-32 flex items-center px-8 animate-fade-in">
        <div class="max-w-7xl mx-auto w-full">
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="FoodOrder" class="w-40 h-40">
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <div class="flex items-center justify-center min-h-[calc(90vh-140px)] px-8 relative z-10">
        <div class="main-grid-container grid grid-cols-1 lg:grid-cols-2 gap-20 max-w-7xl w-full items-center">
            
            {{-- Left Side - Login Form --}}
            <div class="space-y-10 animate-fade-in max-w-lg relative">
                <div class="space-y-8">
                    {{-- Hero Text - removed awkward badge --}}
                    <div class="space-y-6">
                        <h2 class="text-6xl md:text-7xl font-black text-white tracking-tight leading-none">
                            ORDERS UP
                            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-primary via-primary-light to-primary-dark text-glow">
                                ISSUES DOWN
                            </span>
                        </h2>
                        
                        <p class="text-gray-400 text-lg font-medium leading-relaxed max-w-md">
                            The best way to manage orders instead of chaotic folders, 
                            deliver efficiency and control at scale.
                        </p>
                        
                        {{-- Professional status indicator --}}
                        <div class="inline-flex items-center space-x-3 mt-6">
                            <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                            <span class="text-gray-300 text-sm font-medium">System Online</span>
                        </div>
                    </div>
                </div>

                {{-- Login Form --}}
                <form action="{{ route('login') }}" method="POST" class="space-y-6" id="loginForm">
                    @csrf
                    
                    <div class="space-y-5">
                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-300 mb-3">
                                Email Address
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email"
                                value="{{ old('email') }}"
                                class="form-input w-full px-5 py-4 bg-white/5 border border-white/10 rounded-2xl text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-all duration-300 text-lg @error('email') border-red-500 @enderror"
                                placeholder="Enter your email"
                                required
                            >
                            @error('email')
                                <p class="text-red-400 text-sm mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-300 mb-3">
                                Password
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password"
                                    class="form-input w-full px-5 py-4 bg-white/5 border border-white/10 rounded-2xl text-white placeholder-gray-500 focus:outline-none focus:border-primary transition-all duration-300 text-lg @error('password') border-red-500 @enderror"
                                    placeholder="Enter your password"
                                    required
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword()"
                                    class="absolute right-5 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors"
                                >
                                    <svg id="eyeIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-400 text-sm mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="remember"
                                class="w-5 h-5 text-primary bg-white/5 border-white/20 rounded focus:ring-primary focus:ring-1 transition-all duration-200"
                            >
                            <span class="text-gray-300 text-base font-medium">Remember me</span>
                        </label>

                        <a href="#" class="text-primary text-base font-bold hover:text-primary-light transition-colors">
                            Forgot password?
                        </a>
                    </div>

                    {{-- Single Sign In Button --}}
                    <div class="pt-4">
                        <button 
                            type="submit"
                            class="w-full bg-gradient-to-r from-gray-200 to-white text-black font-black py-4 px-8 rounded-2xl hover:shadow-glow-subtle transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none text-lg"
                            id="submitBtn"
                        >
                            <span id="btnText">Sign In</span>
                            <div id="btnLoading" class="hidden flex items-center justify-center space-x-2">
                                <div class="loading-spinner border-black"></div>
                                <span>Signing in...</span>
                            </div>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Right Side - 3D Robot (Fixed positioning) --}}
            <div class="relative h-[800px] md:h-[900px] animate-slide-up overflow-hidden">
                {{-- 3D Robot Container - moved much further right --}}
                <div class="robot-container">
                    <spline-viewer url="https://prod.spline.design/TB3QCWcaxmrpGpqJ/scene.splinecode"></spline-viewer>
                    
                    {{-- Fallback content while Spline loads --}}
                    <div class="absolute inset-0 flex items-center justify-center" id="splineLoader">
                        <div class="text-center space-y-4">
                            <div class="loading-spinner mx-auto w-10 h-10 border-primary"></div>
                            <p class="text-gray-400 font-medium text-lg">Loading...</p>
                        </div>
                    </div>
                </div>

                {{-- Enhanced Status Card --}}
                <div class="status-indicator absolute bottom-32 left-8 glass-effect rounded-2xl p-5 shadow-soft animate-float">
                    <div class="text-center">
                        <p class="text-primary font-black text-xl">Always Here</p>
                        <p class="text-gray-300 text-sm font-medium">Ready to Serve</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="fixed top-8 right-8 bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-soft-xl z-50 animate-fade-in">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-8 right-8 bg-red-500 text-white px-6 py-4 rounded-2xl shadow-soft-xl z-50 animate-fade-in">
            {{ session('error') }}
        </div>
    @endif

    {{-- JavaScript --}}
    <script>
        // Password toggle functionality
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }

        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            
            submitBtn.disabled = true;
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
        });

        // Hide Spline loader when loaded
        document.addEventListener('DOMContentLoaded', function() {
            const splineViewer = document.querySelector('spline-viewer');
            const loader = document.getElementById('splineLoader');
            
            if (splineViewer) {
                splineViewer.addEventListener('load', function() {
                    loader.style.opacity = '0';
                    setTimeout(() => {
                        loader.style.display = 'none';
                    }, 500);
                });
                
                setTimeout(() => {
                    if (loader) {
                        loader.style.opacity = '0';
                        setTimeout(() => {
                            loader.style.display = 'none';
                        }, 300);
                    }
                }, 3000);
            }
        });

        // Auto-hide flash messages
        setTimeout(function() {
            const messages = document.querySelectorAll('.fixed.top-8.right-8');
            messages.forEach(message => {
                message.style.opacity = '0';
                message.style.transform = 'translateX(100%)';
                setTimeout(() => message.remove(), 300);
            });
        }, 5000);
    </script>
</body>
</html>
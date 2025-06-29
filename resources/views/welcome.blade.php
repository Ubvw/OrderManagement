<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taste of Home - Sign In</title>
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Google Fonts - Pacifico and Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    {{-- Spline 3D Viewer --}}
    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.10.10/build/spline-viewer.js"></script>
    
    {{-- Custom Tailwind Config --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'pacifico': ['Pacifico', 'cursive'],
                        'poppins': ['Poppins', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'brand-orange': '#F9A55F',
                        'brand-green': '#5F8B5C',
                        'warm-peach': '#FFB87A',
                    },
                    boxShadow: {
                        'warm': '0 10px 25px -5px rgba(249, 165, 95, 0.25)',
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.1)',
                        'soft-xl': '0 20px 25px -5px rgba(0, 0, 0, 0.15)',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in': 'fadeIn 1s ease-out forwards',
                        'slide-in': 'slideIn 1s ease-out forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideIn: {
                            '0%': { opacity: '0', transform: 'translateX(30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Poppins', system-ui, sans-serif;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #F9A55F;
            border-radius: 4px;
        }
        
        /* Loading animation */
        .loading-spinner {
            border: 2px solid transparent;
            border-top: 2px solid #F9A55F;
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
            box-shadow: 0 0 0 3px rgba(249, 165, 95, 0.2);
        }
        
        /* Outer container - handles watermark hiding */
        .spline-outer-container {
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden; /* Keeps watermark hidden */
            border-radius: 0;
        }
        
        /* Inner container - provides rotation space */
        .spline-inner-container {
            width: 200%; /* Much larger to accommodate rotation */
            height: 200%;
            position: absolute;
            top: -50%; /* Center the larger container */
            left: -50%;
            overflow: visible; /* Allows rotation without clipping */
        }
        
        /* Spline viewer - ADJUSTED positioning to move up and right */
        spline-viewer {
            width: 70%; /* Scaled down since container is larger */
            height: 70%;
            position: absolute;
            top: 11%; /* Moved up from 15% to 5% */
            left: 17%; /* Moved right from 15% to 25% */
            display: block;
            border-radius: 0;
            background: transparent;
        }
        
        /* Circular orange background - adjusted positioning */
        .circular-background {
            position: absolute;
            top: 50%;
            left: 0;
            width: 120vh;
            height: 120vh;
            background: #F9A55F;
            border-radius: 50%;
            transform: translateY(-50%) translateX(-25%);
            z-index: 1;
        }
        
        /* Warm beige background */
        .warm-beige {
            background: linear-gradient(135deg, #F5F1EB 0%, #EDE7DD 100%);
        }
    </style>
</head>

<body class="min-h-screen font-poppins overflow-hidden warm-beige">
    {{-- Circular Orange Background --}}
    <div class="circular-background"></div>
    
    <div class="min-h-screen flex relative z-10">
        
        {{-- Left Side - Content over circular background --}}
        <div class="flex-1 relative flex flex-col">
            {{-- Logo Section --}}
            <div class="absolute top-8 left-8 z-20 animate-fade-in">
                <div class="flex items-center space-x-3">
                    {{-- Logo Placeholder - Food Dome Icon --}}
                    <div class="flex items-center">
                        <img src="{{ asset('images/logo2.png') }}" alt="TasteOfHome" class="w-63 h-63">
                    </div>
                </div>
            </div>

            {{-- 3D Restaurant Model Container - Increased Size --}}
            <div class="flex-1 flex items-center justify-center relative z-10">
                <div class="w-full max-w-3xl h-[500px] lg:h-[600px] xl:h-[700px] relative animate-float">
                    <div class="spline-outer-container">
                        <div class="spline-inner-container">
                            <spline-viewer url="https://prod.spline.design/IOulcdq7mMUl3hGF/scene.splinecode"></spline-viewer>
                        </div>
                        
                        {{-- Fallback content while Spline loads --}}
                        <div class="absolute inset-0 flex items-center justify-center" id="splineLoader">
                            <div class="text-center space-y-4">
                                <div class="loading-spinner mx-auto w-8 h-8"></div>
                                <p class="text-white/80 font-medium">Loading 3D Model...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side - Login Form --}}
        <div class="flex-1 flex items-center justify-center p-8 lg:p-16 relative z-10">
            <div class="w-full max-w-md space-y-8 animate-slide-in">
                
                {{-- Welcome Header --}}
                <div class="text-center space-y-3">
                    <h2 class="font-pacifico text-brand-green" style="font-size: 32px; line-height: 1.2;">
                        Welcome Back!
                    </h2>
                    <p class="text-brand-green font-poppins font-medium" style="font-size: 24px;">
                        Sign in to your account
                    </p>
                </div>

                {{-- Login Form --}}
                <form action="/" method="POST" class="space-y-6" id="loginForm">
                    @csrf
                    
                    <div class="space-y-5">
                        {{-- Email Field --}}
                        <div>
                            <label for="email" class="block font-poppins font-semibold text-brand-green mb-3" style="font-size: 16px;">
                                Email Address
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email"
                                value="{{ old('email') }}"
                                class="form-input w-full px-5 py-4 bg-white/80 border border-brand-orange/30 rounded-2xl text-gray-800 placeholder-gray-500 focus:outline-none focus:border-brand-orange focus:bg-white transition-all duration-300 text-lg font-poppins @error('email') border-red-400 @enderror"
                                placeholder="Enter your email"
                                required
                            >
                            @error('email')
                                <p class="text-red-500 text-sm mt-2 font-medium font-poppins">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password Field --}}
                        <div>
                            <label for="password" class="block font-poppins font-semibold text-brand-green mb-3" style="font-size: 16px;">
                                Password
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password"
                                    class="form-input w-full px-5 py-4 bg-white/80 border border-brand-orange/30 rounded-2xl text-gray-800 placeholder-gray-500 focus:outline-none focus:border-brand-orange focus:bg-white transition-all duration-300 text-lg font-poppins @error('password') border-red-400 @enderror"
                                    placeholder="Enter your password"
                                    required
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword()"
                                    class="absolute right-5 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                                >
                                    <svg id="eyeIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-red-500 text-sm mt-2 font-medium font-poppins">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Sign In Button --}}
                    <div class="pt-4">
                        <button 
                            type="submit"
                            class="w-full text-white font-bold py-4 px-8 rounded-2xl hover:shadow-warm transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none text-lg font-poppins"
                            style="background: linear-gradient(135deg, #F89768 6%, #F88870 53%, #F9A55F 96%);"
                            id="submitBtn"
                        >
                            <span id="btnText">Sign In</span>
                            <div id="btnLoading" class="hidden flex items-center justify-center space-x-2">
                                <div class="loading-spinner"></div>
                                <span>Signing in...</span>
                            </div>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="fixed top-8 right-8 bg-green-500 text-white px-6 py-4 rounded-2xl shadow-soft-xl z-50 animate-fade-in">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-poppins">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-8 right-8 bg-red-500 text-white px-6 py-4 rounded-2xl shadow-soft-xl z-50 animate-fade-in">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-poppins">{{ session('error') }}</span>
            </div>
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
                    if (loader) {
                        loader.style.opacity = '0';
                        setTimeout(() => {
                            loader.style.display = 'none';
                        }, 500);
                    }
                });
                
                // Fallback timeout
                setTimeout(() => {
                    if (loader) {
                        loader.style.opacity = '0';
                        setTimeout(() => {
                            loader.style.display = 'none';
                        }, 300);
                    }
                }, 4000);
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'CRUD Generator' }}</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='0.9em' font-size='90'>&lt;/&gt;</text></svg>">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-200 overflow-x-hidden" x-data="darkModeHandler()" :class="darkMode ? 'dark' : ''" x-cloak>
    <!-- Animated Background Blobs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute w-96 h-96 bg-blue-400/20 dark:bg-blue-600/10 rounded-full blur-3xl animate-blob top-0 -left-20"></div>
        <div class="absolute w-96 h-96 bg-purple-400/20 dark:bg-purple-600/10 rounded-full blur-3xl animate-blob animation-delay-2000 top-0 -right-20"></div>
        <div class="absolute w-96 h-96 bg-pink-400/20 dark:bg-pink-600/10 rounded-full blur-3xl animate-blob animation-delay-4000 bottom-0 left-1/2"></div>
    </div>
    <nav class="relative bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center h-16">
                <a href="/" wire:navigate class="flex items-center gap-3 hover:opacity-80 transition group">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center shadow-lg group-hover:shadow-xl transition">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">CRUD Generator</h1>
                </a>
                
                <div class="flex-1 flex justify-center items-center gap-8">
                    @auth
                        <a href="/admin" class="text-sm font-medium transition relative group {{ request()->is('admin*') ? 'text-blue-600 dark:text-blue-400' : 'hover:text-blue-600 dark:hover:text-blue-400' }}">
                            Dashboard
                            <span class="absolute bottom-0 left-0 {{ request()->is('admin*') ? 'w-full' : 'w-0' }} h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                    @endauth
                    <a href="/" wire:navigate class="text-sm font-medium transition relative group {{ request()->is('/') ? 'text-blue-600 dark:text-blue-400' : 'hover:text-blue-600 dark:hover:text-blue-400' }}">
                        Home
                        <span class="absolute bottom-0 left-0 {{ request()->is('/') ? 'w-full' : 'w-0' }} h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="/generator" wire:navigate class="text-sm font-medium transition relative group {{ request()->is('generator') ? 'text-blue-600 dark:text-blue-400' : 'hover:text-blue-600 dark:hover:text-blue-400' }}">
                        Generator
                        <span class="absolute bottom-0 left-0 {{ request()->is('generator') ? 'w-full' : 'w-0' }} h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="/components" wire:navigate class="text-sm font-medium transition relative group {{ request()->is('components') && !request()->is('admin*') ? 'text-blue-600 dark:text-blue-400' : 'hover:text-blue-600 dark:hover:text-blue-400' }}">
                        Library
                        <span class="absolute bottom-0 left-0 {{ request()->is('components') && !request()->is('admin*') ? 'w-full' : 'w-0' }} h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                    </a>
                    <a href="/about" wire:navigate class="text-sm font-medium transition relative group {{ request()->is('about') ? 'text-blue-600 dark:text-blue-400' : 'hover:text-blue-600 dark:hover:text-blue-400' }}">
                        About
                        <span class="absolute bottom-0 left-0 {{ request()->is('about') ? 'w-full' : 'w-0' }} h-0.5 bg-gradient-to-r from-blue-600 to-purple-600 group-hover:w-full transition-all duration-300"></span>
                    </a>
                </div>
                
                <div class="flex items-center">
                    <button @click="toggle()" class="p-2 rounded-lg hover:bg-gradient-to-br hover:from-blue-50 hover:to-purple-50 dark:hover:from-blue-900/20 dark:hover:to-purple-900/20 transition-all duration-300 transform hover:scale-110">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="relative z-10">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="relative z-10 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-t border-gray-200 dark:border-gray-700 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-center md:text-left">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">All Rights Reserved © 2025</p>
                    <p class="text-gray-500 dark:text-gray-500 text-xs mt-1">Built with ❤️ by Kasemov using TALL Stack & Filament</p>
                </div>
                <div class="flex items-center gap-6">
                    <a href="https://github.com/Kasemov123" target="_blank" class="flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 transform hover:scale-110">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        <span class="text-sm font-medium">GitHub</span>
                    </a>
                    <a href="https://wa.me/963951579883" target="_blank" class="flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-green-500 dark:hover:text-green-400 transition-all duration-300 transform hover:scale-110">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        <span class="text-sm font-medium">WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    
    <script>
        function darkModeHandler() {
            return {
                darkMode: localStorage.getItem('darkMode') === 'true',
                toggle() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('darkMode', this.darkMode);
                }
            }
        }
        
        document.addEventListener('livewire:navigated', () => {
            document.querySelectorAll('pre code').forEach((block) => {
                hljs.highlightElement(block);
            });
        });
    </script>
    
    <style>
        @keyframes blob {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            25% {
                transform: translate(20px, -50px) scale(1.1);
            }
            50% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            75% {
                transform: translate(50px, 50px) scale(1.05);
            }
        }
        
        .animate-blob {
            animation: blob 20s infinite;
        }
        
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>
</html>

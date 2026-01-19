<div>
    <div class="min-h-screen">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-purple-600 to-pink-600 text-white py-12 overflow-hidden">
            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="text-4xl mb-3">👨‍💻</div>
                <h1 class="text-3xl font-black mb-2">About Me</h1>
                <p class="text-base text-purple-100">Laravel Developer & TALL Stack Enthusiast</p>
            </div>
        </div>

        <!-- About Content -->
        <div class="py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-3xl shadow-2xl p-10 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-6 mb-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-3xl">
                            👨‍💻
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600">Kasemov</h2>
                            <p class="text-gray-600 dark:text-gray-400">Full Stack Developer</p>
                        </div>
                    </div>
                    
                    <p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">
                        Hi! I'm a passionate Laravel developer who loves building tools that make developers' lives easier. 
                        This CRUD Generator was born from my own need to speed up repetitive tasks and focus on what really matters.
                    </p>
                    
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        I believe in clean code, modern practices, and the power of the TALL Stack. 
                        This project is my contribution to the Laravel community. I hope it saves you as much time as it saves me!
                    </p>
                </div>

                <!-- Tech Stack -->
                <div class="mt-12">
                    <h3 class="text-2xl font-bold text-center mb-8 bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600">Core Technologies</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="group bg-gradient-to-br from-cyan-50 to-cyan-100 dark:from-cyan-900/20 dark:to-cyan-800/20 p-6 rounded-xl border-2 border-cyan-200 dark:border-cyan-700 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 animate-fade-in-up">
                            <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🎨</div>
                            <h4 class="font-bold text-cyan-900 dark:text-cyan-100">Tailwind</h4>
                        </div>
                        <div class="group bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 p-6 rounded-xl border-2 border-green-200 dark:border-green-700 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 animate-fade-in-up animation-delay-100">
                            <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">⚡</div>
                            <h4 class="font-bold text-green-900 dark:text-green-100">Alpine.js</h4>
                        </div>
                        <div class="group bg-gradient-to-br from-pink-50 to-pink-100 dark:from-pink-900/20 dark:to-pink-800/20 p-6 rounded-xl border-2 border-pink-200 dark:border-pink-700 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 animate-fade-in-up animation-delay-200">
                            <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">⚙️</div>
                            <h4 class="font-bold text-pink-900 dark:text-pink-100">Livewire</h4>
                        </div>
                        <div class="group bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 p-6 rounded-xl border-2 border-red-200 dark:border-red-700 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 animate-fade-in-up animation-delay-300">
                            <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🚀</div>
                            <h4 class="font-bold text-red-900 dark:text-red-100">Laravel</h4>
                        </div>
                    </div>
                </div>

                <!-- CTA -->
                <div class="mt-12 text-center animate-fade-in-up animation-delay-400">
                    <a href="/generator" wire:navigate class="inline-block px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold rounded-lg shadow-xl hover:shadow-2xl transform hover:scale-105 transition duration-300">
                        🚀 Try the Generator
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .animate-blob {
            animation: blob 7s infinite;
        }
        
        .animation-delay-100 { animation-delay: 0.1s; }
        .animation-delay-200 { animation-delay: 0.2s; }
        .animation-delay-300 { animation-delay: 0.3s; }
        .animation-delay-400 { animation-delay: 0.4s; }
        .animation-delay-2000 { animation-delay: 2s; }
    </style>
</div>

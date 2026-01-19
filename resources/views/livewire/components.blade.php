<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-black mb-2 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">Components Library</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">Browse and preview ready-to-use components</p>
        </div>

        <div class="grid grid-cols-12 gap-6">
            <!-- Sidebar -->
            <div class="col-span-3">
                <div class="sticky top-20 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4" style="max-height: calc(100vh - 120px); overflow-y: auto;">
                    <h3 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase mb-3">Categories</h3>
                    @foreach($categoriesWithComponents as $category)
                        <div class="mb-2">
                            <button wire:click="toggleCategory({{ $category->id }})" 
                                    class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition text-left">
                                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $category->name }}</span>
                                <span class="text-xs bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 px-2 py-0.5 rounded-full">{{ $category->components->count() }}</span>
                            </button>
                            @if(in_array($category->id, $expandedCategories))
                                <div class="ml-4 mt-1 space-y-1">
                                    @foreach($category->components as $component)
                                        <button wire:click="viewComponent({{ $component->id }})" 
                                                class="w-full text-left px-3 py-1.5 text-sm text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded transition">
                                            {{ $component->name }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-span-9">
                @if($showPreview && $selectedComponent)
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $selectedComponent->name }}</h2>
                                    <p class="text-sm text-blue-600 dark:text-blue-400">{{ $selectedComponent->category->name }}</p>
                                    @if($selectedComponent->description)
                                        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $selectedComponent->description }}</p>
                                    @endif
                                </div>
                                <button wire:click="closePreview" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-2xl">&times;</button>
                            </div>
                        </div>

                        <div class="border-b border-gray-200 dark:border-gray-700">
                            <nav class="flex">
                                <button wire:click="$set('showCode', false)" 
                                        class="px-6 py-3 text-sm font-medium transition {{ !$showCode ? 'border-b-2 border-blue-600 text-blue-600 dark:text-blue-400' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
                                    👁️ Preview
                                </button>
                                <button wire:click="$set('showCode', true)" 
                                        class="px-6 py-3 text-sm font-medium transition {{ $showCode ? 'border-b-2 border-blue-600 text-blue-600 dark:text-blue-400' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400' }}">
                                    📝 Code
                                </button>
                            </nav>
                        </div>

                        @if(!$showCode)
                            <div class="p-6">
                                <div class="bg-gray-50 dark:bg-gray-900 rounded-xl p-8 min-h-[400px]">
                                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border-2 border-dashed border-gray-300 dark:border-gray-600">
                                        {!! $this->getComponentCode() !!}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div>
                                <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 flex justify-between items-center">
                                    <span class="text-sm font-medium">{{ $selectedComponent->name }}.blade.php</span>
                                    <button onclick="copyCode()" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded transition">
                                        📋 Copy
                                    </button>
                                </div>
                                <div style="max-height: 600px; overflow: auto; background: #1e1e1e; border-bottom-left-radius: 0.75rem; border-bottom-right-radius: 0.75rem;">
                                    <pre style="margin: 0; padding: 1rem;"><code id="component-code" class="language-xml" style="color: #d4d4d4;">{{ $this->getComponentCode() }}</code></pre>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center" style="min-height: 500px; display: flex; align-items: center; justify-content: center;">
                        <div>
                            <div class="text-6xl mb-4">👈</div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Select a Component</h3>
                            <p class="text-gray-600 dark:text-gray-400">Choose a category from the sidebar and select a component to preview</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function copyCode() {
            const code = document.getElementById('component-code').textContent;
            navigator.clipboard.writeText(code);
            alert('Copied!');
        }

        document.addEventListener('livewire:init', () => {
            Livewire.hook('morph.updated', () => {
                setTimeout(() => {
                    if (window.hljs) {
                        document.querySelectorAll('pre code').forEach((block) => {
                            window.hljs.highlightElement(block);
                        });
                    }
                }, 100);
            });
        });
    </script>
</div>

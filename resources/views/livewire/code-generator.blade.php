<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(!$showPreview)
        <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-gray-200 dark:border-gray-700 animate-fade-in">
            <div class="text-center mb-8">
                <h2 class="text-4xl font-black mb-2 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">Generate TALL Stack CRUD</h2>
                <p class="text-gray-600 dark:text-gray-400">Fill the form below to generate your files</p>
            </div>

            <form wire:submit.prevent="generate">
                <!-- Stack Type Selection -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold mb-3 text-gray-700 dark:text-gray-300">🎯 Stack Type</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex items-center p-5 border-2 rounded-xl cursor-pointer transition {{ $stackType === 'tall' ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-300 dark:border-gray-600 hover:border-blue-400' }}">
                            <input type="radio" wire:model.live="stackType" value="tall" class="mr-3">
                            <div>
                                <div class="font-bold text-lg">TALL Stack</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Tailwind + Alpine + Livewire + Laravel</div>
                            </div>
                        </label>
                        <label class="relative flex items-center p-5 border-2 rounded-xl cursor-pointer transition {{ $stackType === 'blade' ? 'border-blue-600 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-300 dark:border-gray-600 hover:border-blue-400' }}">
                            <input type="radio" wire:model.live="stackType" value="blade" class="mr-3">
                            <div>
                                <div class="font-bold text-lg">Laravel Blade</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Traditional Laravel with Blade Templates</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Model Name -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold mb-2 text-gray-700 dark:text-gray-300">📝 Model Name</label>
                    <input type="text" wire:model="modelName" 
                           class="w-full px-5 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-lg"
                           placeholder="e.g., Post">
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">💡 English only, auto-formatted (e.g., post → Post). Max 50 fields allowed.</p>
                    @error('modelName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Fields -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">📦 Fields</h3>
                        <button type="button" wire:click.prevent="addField" 
                                class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-xl transition transform hover:scale-105 shadow-lg hover:shadow-xl font-semibold">
                            + Add Field
                        </button>
                    </div>

                    <div class="space-y-4">
                        @forelse($fields as $index => $field)
                            <div class="p-5 border-2 border-gray-200 dark:border-gray-700 rounded-xl bg-gradient-to-br from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 hover:shadow-lg transition">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-sm mb-1">Field Name</label>
                                        <input type="text" wire:model="fields.{{ $index }}.name" 
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-sm"
                                               placeholder="title">
                                    </div>
                                    <div>
                                        <label class="block text-sm mb-1">Type</label>
                                        <select wire:model="fields.{{ $index }}.type" 
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-sm">
                                            <option value="string">String</option>
                                            <option value="text">Text</option>
                                            <option value="longText">Long Text</option>
                                            <option value="char">Char</option>
                                            <option value="integer">Integer</option>
                                            <option value="tinyInteger">Tiny Integer</option>
                                            <option value="bigInteger">Big Integer</option>
                                            <option value="unsignedBigInteger">Unsigned Big Integer</option>
                                            <option value="boolean">Boolean</option>
                                            <option value="date">Date</option>
                                            <option value="datetime">DateTime</option>
                                            <option value="timestamp">Timestamp</option>
                                            <option value="time">Time</option>
                                            <option value="year">Year</option>
                                            <option value="decimal">Decimal</option>
                                            <option value="float">Float</option>
                                            <option value="double">Double</option>
                                            <option value="json">JSON</option>
                                            <option value="enum">Enum</option>
                                        </select>
                                    </div>
                                    <div class="flex items-end gap-2">
                                        <label class="flex items-center gap-2 text-sm">
                                            <input type="checkbox" wire:model="fields.{{ $index }}.nullable" 
                                                   class="rounded border-gray-300 dark:border-gray-600">
                                            Nullable
                                        </label>
                                        <label class="flex items-center gap-2 text-sm">
                                            <input type="checkbox" wire:model="fields.{{ $index }}.unique" 
                                                   class="rounded border-gray-300 dark:border-gray-600">
                                            Unique
                                        </label>
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" wire:click.prevent="removeField({{ $index }})" 
                                                class="w-full px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-sm transition">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">No fields yet. Click "Add Field" to start.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Relationships -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">🔗 Relationships</h3>
                        <button type="button" wire:click.prevent="addRelationship" 
                                class="px-5 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-xl transition transform hover:scale-105 shadow-lg hover:shadow-xl font-semibold">
                            + Add Relationship
                        </button>
                    </div>

                    <div class="space-y-4">
                        @foreach($relationships as $index => $relationship)
                            <div class="p-5 border-2 border-gray-200 dark:border-gray-700 rounded-xl bg-gradient-to-br from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 hover:shadow-lg transition">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-sm mb-1">Relationship Name</label>
                                        <input type="text" wire:model="relationships.{{ $index }}.name" 
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-sm"
                                               placeholder="user">
                                    </div>
                                    <div>
                                        <label class="block text-sm mb-1">Type</label>
                                        <select wire:model="relationships.{{ $index }}.type" 
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-sm">
                                            <option value="belongsTo">belongsTo</option>
                                            <option value="hasOne">hasOne</option>
                                            <option value="hasMany">hasMany</option>
                                            <option value="belongsToMany">belongsToMany</option>
                                            <option value="morphTo">morphTo</option>
                                            <option value="morphOne">morphOne</option>
                                            <option value="morphMany">morphMany</option>
                                            <option value="morphToMany">morphToMany</option>
                                            <option value="hasManyThrough">hasManyThrough</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm mb-1">Related Model</label>
                                        <input type="text" wire:model="relationships.{{ $index }}.model" 
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-sm"
                                               placeholder="User">
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" wire:click.prevent="removeRelationship({{ $index }})" 
                                                class="w-full px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-sm transition">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- File Options -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold mb-5 text-gray-800 dark:text-gray-200">📁 Files to Generate</h3>
                    
                    <!-- Common Files -->
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold mb-3 text-gray-600 dark:text-gray-400">Common Files</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <label class="flex items-center gap-2 p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-blue-400 transition">
                                <input type="checkbox" wire:model="generateMigration" class="rounded">
                                <span class="text-sm">Migration</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-blue-400 transition">
                                <input type="checkbox" wire:model="generateModel" class="rounded">
                                <span class="text-sm">Model</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-blue-400 transition">
                                <input type="checkbox" wire:model="generateRoutes" class="rounded">
                                <span class="text-sm">Routes</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-blue-400 transition">
                                <input type="checkbox" wire:model="generateFactory" class="rounded">
                                <span class="text-sm">Factory</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-blue-400 transition">
                                <input type="checkbox" wire:model="generateSeeder" class="rounded">
                                <span class="text-sm">Seeder</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-blue-400 transition">
                                <input type="checkbox" wire:model="generateApiRoutes" class="rounded">
                                <span class="text-sm">API Routes</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-blue-400 transition">
                                <input type="checkbox" wire:model="generateApiController" class="rounded">
                                <span class="text-sm">API Controller</span>
                            </label>
                        </div>
                    </div>

                    @if($stackType === 'tall')
                    <!-- TALL Stack Files -->
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold mb-3 text-blue-600 dark:text-blue-400">TALL Stack Options</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="p-4 border-2 rounded-lg {{ $generateLivewireComponent ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-300 dark:border-gray-600' }}">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" wire:model="generateLivewireComponent" class="mt-1 rounded">
                                    <div>
                                        <div class="font-semibold text-base">Livewire CRUD</div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Full CRUD with Livewire Component + Blade View</div>
                                    </div>
                                </label>
                            </div>
                            <div class="p-4 border-2 rounded-lg {{ $generateFilamentResource ? 'border-purple-500 bg-purple-50 dark:bg-purple-900/20' : 'border-gray-300 dark:border-gray-600' }}">
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <input type="checkbox" wire:model="generateFilamentResource" class="mt-1 rounded">
                                    <div>
                                        <div class="font-semibold text-base">Filament Admin Panel</div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Resource + List/Create/Edit Pages</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">💡 You can select both options to generate Livewire for frontend and Filament for admin</p>
                    </div>
                    @endif

                    @if($stackType === 'blade')
                    <!-- Laravel Blade Files -->
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold mb-3 text-green-600 dark:text-green-400">Laravel Blade Files</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <label class="flex items-center gap-2 p-3 border-2 border-green-200 dark:border-green-700 rounded-lg cursor-pointer hover:border-green-400 transition bg-green-50/50 dark:bg-green-900/10">
                                <input type="checkbox" wire:model="generateController" class="rounded">
                                <span class="text-sm">Controller</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border-2 border-green-200 dark:border-green-700 rounded-lg cursor-pointer hover:border-green-400 transition bg-green-50/50 dark:bg-green-900/10">
                                <input type="checkbox" wire:model="generateViews" class="rounded">
                                <span class="text-sm">Blade Views</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 border-2 border-green-200 dark:border-green-700 rounded-lg cursor-pointer hover:border-green-400 transition bg-green-50/50 dark:bg-green-900/10">
                                <input type="checkbox" wire:model="generateRequest" class="rounded">
                                <span class="text-sm">Form Request</span>
                            </label>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="submit" 
                            class="px-12 py-5 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 hover:from-blue-700 hover:via-purple-700 hover:to-pink-700 text-white text-lg font-bold rounded-2xl transition transform hover:scale-105 shadow-2xl hover:shadow-blue-500/50">
                        <span class="flex items-center gap-3">
                            <span>🚀</span>
                            <span>Generate Files</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </span>
                    </button>
                </div>
            </form>
        </div>
        @else
        <!-- Generated Code Preview with Tabs -->
        <div>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Generated Files</h2>
                <button wire:click="$set('showPreview', false)" 
                        class="px-4 py-2 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-lg transition transform hover:scale-105 shadow-lg">
                    ← Back to Generator
                </button>
            </div>

            <!-- Tabs -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-2xl overflow-hidden border-2 border-purple-100 dark:border-purple-900 animate-fade-in">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex overflow-x-auto">
                        @foreach($generatedFiles as $type => $code)
                            <button wire:click="$set('activeTab', '{{ $type }}')" 
                                    class="px-6 py-3 text-sm font-medium whitespace-nowrap transition transform hover:scale-105 {{ $activeTab === $type ? 'border-b-3 border-gradient-to-r from-blue-600 to-purple-600 text-blue-600 bg-blue-50 dark:bg-blue-900/20' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                            </button>
                        @endforeach
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="relative">
                    @foreach($generatedFiles as $type => $code)
                        <div x-show="$wire.activeTab === '{{ $type }}'" class="p-0">
                            <div class="bg-gray-100 dark:bg-gray-700 px-4 py-3 flex justify-between items-center">
                                <span class="text-sm font-medium">{{ ucfirst(str_replace('_', ' ', $type)) }}.php</span>
                                <button onclick="navigator.clipboard.writeText(document.getElementById('code-{{ $type }}').textContent); alert('Copied!')" 
                                        class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded transition">
                                    📋 Copy
                                </button>
                            </div>
                            <pre class="!m-0 !rounded-none"><code id="code-{{ $type }}" class="language-php block p-4 overflow-x-auto text-sm" style="background: #1e1e1e; color: #d4d4d4;">{{ $code }}</code></pre>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                if (window.hljs) {
                    document.querySelectorAll('pre code').forEach((block) => {
                        window.hljs.highlightElement(block);
                    });
                }
            }, 100);
        });
        
        document.addEventListener('livewire:navigated', () => {
            setTimeout(() => {
                if (window.hljs) {
                    document.querySelectorAll('pre code').forEach((block) => {
                        window.hljs.highlightElement(block);
                    });
                }
            }, 100);
        });
        
        Livewire.on('filesGenerated', () => {
            setTimeout(() => {
                if (window.hljs) {
                    document.querySelectorAll('pre code').forEach((block) => {
                        window.hljs.highlightElement(block);
                    });
                }
            }, 100);
        });
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulseSlow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        .animate-pulse-slow {
            animation: pulseSlow 3s ease-in-out infinite;
        }
    </style>
</div>

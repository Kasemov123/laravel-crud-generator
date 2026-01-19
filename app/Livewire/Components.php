<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Component as ComponentModel;
use Livewire\Component;

class Components extends Component
{
    public $selectedCategory = null;
    public $selectedComponent = null;
    public $showPreview = false;
    public $showCode = false;
    public $expandedCategories = [];

    public function toggleCategory($categoryId)
    {
        if (in_array($categoryId, $this->expandedCategories)) {
            $this->expandedCategories = array_diff($this->expandedCategories, [$categoryId]);
        } else {
            $this->expandedCategories[] = $categoryId;
        }
    }

    public function viewComponent($componentId)
    {
        $this->selectedComponent = ComponentModel::with('category')
            ->where('is_active', true)
            ->findOrFail($componentId);
        $this->showPreview = true;
        $this->showCode = false;
        $this->dispatch('componentSelected');
    }

    public function getComponentCode()
    {
        if (!$this->selectedComponent) return '';
        
        $filePath = $this->selectedComponent->uploaded_file;
        
        if (!$filePath) return '// No file path';
        
        // حماية قوية من Path Traversal
        $normalizedPath = str_replace('\\', '/', $filePath);
        if (str_contains($normalizedPath, '..') || !str_starts_with($normalizedPath, 'components/')) {
            return '// Invalid file path';
        }
        
        try {
            if (\Storage::disk('public')->exists($filePath)) {
                return \Storage::disk('public')->get($filePath);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to read component file: ' . $e->getMessage());
        }
        
        return '// File not found';
    }

    public function toggleCode()
    {
        $this->showCode = !$this->showCode;
    }

    public function closePreview()
    {
        $this->showPreview = false;
        $this->selectedComponent = null;
    }

    public function render()
    {
        $categoriesWithComponents = \Cache::remember('active_categories_with_components', 3600, function() {
            return Category::where('is_active', true)
                ->with(['components' => fn($q) => $q->where('is_active', true)->select('id', 'category_id', 'name', 'slug', 'description', 'is_active')])
                ->select('id', 'name', 'slug', 'description', 'is_active')
                ->get();
        });

        return view('livewire.components', compact('categoriesWithComponents'));
    }
}

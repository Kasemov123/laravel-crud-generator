<?php

namespace App\Observers;

use App\Models\Component;
use Illuminate\Support\Facades\Storage;

class ComponentObserver
{
    public function saving(Component $component): void
    {
        $inputMethod = request('input_method');
        
        if ($inputMethod === 'code' && request()->has('blade_code') && request('blade_code')) {
            $bladeCode = request('blade_code');
            
            if (strlen($bladeCode) > 50000) {
                throw new \Exception('Blade code is too large (max 50KB)');
            }
            
            // منع حقن PHP الخطير
            $dangerousPatterns = ['<?php', '<?=', '@php', 'eval(', 'exec(', 'system(', 'shell_exec', 'passthru'];
            foreach ($dangerousPatterns as $pattern) {
                if (stripos($bladeCode, $pattern) !== false) {
                    throw new \Exception('Dangerous code detected. PHP execution is not allowed.');
                }
            }
            
            $category = $component->category;
            $dir = 'components/' . ($category ? preg_replace('/[^a-z0-9-]/', '', $category->slug) : 'uncategorized');
            Storage::disk('public')->makeDirectory($dir);
            
            $filename = preg_replace('/[^a-z0-9-]/', '', $component->slug) . '.blade.php';
            $filePath = $dir . '/' . $filename;
            
            Storage::disk('public')->put($filePath, $bladeCode);
            
            $component->uploaded_file = $filePath;
            $component->file_path = null;
        }
        
        if ($inputMethod === 'path' && request()->has('file_path') && request('file_path')) {
            $filePath = request('file_path');
            // حماية من Path Traversal
            if (str_contains($filePath, '..') || str_contains($filePath, '//') || !str_starts_with($filePath, 'components/')) {
                throw new \Exception('Invalid file path');
            }
            $component->uploaded_file = null;
        }
        
        if ($inputMethod === 'upload') {
            $component->file_path = null;
        }
    }

    public function deleting(Component $component): void
    {
        if ($component->uploaded_file && !str_contains($component->uploaded_file, '..')) {
            try {
                if (Storage::disk('public')->exists($component->uploaded_file)) {
                    Storage::disk('public')->delete($component->uploaded_file);
                }
            } catch (\Exception $e) {
                \Log::error('Failed to delete component file: ' . $e->getMessage());
            }
        }
    }
}

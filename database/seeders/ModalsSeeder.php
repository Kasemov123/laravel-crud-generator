<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Component;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ModalsSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::where('slug', 'modals')->first();
        if (!$category) {
            $category = Category::create([
                'name' => 'Modals',
                'slug' => 'modals',
                'description' => 'Modal components',
                'is_active' => true,
            ]);
        }

        Storage::disk('public')->makeDirectory('components/modals');

        $modals = [
            ['name' => 'Confirmation Modal', 'slug' => 'confirmation-modal', 'code' => '<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-xl max-w-md w-full p-6">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Confirm Action</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Are you sure you want to proceed?</p>
        <div class="flex gap-3">
            <button type="button" disabled class="flex-1 bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg cursor-not-allowed opacity-90">Cancel</button>
            <button type="button" disabled class="flex-1 bg-red-600 dark:bg-red-500 text-white px-4 py-2 rounded-lg cursor-not-allowed opacity-90">Confirm</button>
        </div>
    </div>
</div>'],
            ['name' => 'Alert Modal', 'slug' => 'alert-modal', 'code' => '<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-xl max-w-md w-full p-6 text-center">
        <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="text-green-600 dark:text-green-400 text-3xl">✓</span>
        </div>
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">Success!</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Your changes have been saved.</p>
        <button type="button" disabled class="w-full bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded-lg cursor-not-allowed opacity-90">OK</button>
    </div>
</div>'],
        ];

        foreach ($modals as $modal) {
            $filePath = 'components/modals/' . $modal['slug'] . '.blade.php';
            Storage::disk('public')->put($filePath, $modal['code']);
            Component::create([
                'category_id' => $category->id,
                'name' => $modal['name'],
                'slug' => $modal['slug'],
                'description' => $modal['name'],
                'uploaded_file' => $filePath,
                'is_active' => true,
            ]);
        }
    }
}

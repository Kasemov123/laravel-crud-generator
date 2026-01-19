<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Component;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AlertsSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::where('slug', 'alerts')->first();
        if (!$category) {
            $category = Category::create([
                'name' => 'Alerts',
                'slug' => 'alerts',
                'description' => 'Alert components',
                'is_active' => true,
            ]);
        }

        Storage::disk('public')->makeDirectory('components/alerts');

        $alerts = [
            ['name' => 'Success Alert', 'slug' => 'success-alert', 'code' => '<div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg flex items-center">
    <span class="mr-2">✓</span>
    <span>Operation completed successfully!</span>
</div>'],
            ['name' => 'Error Alert', 'slug' => 'error-alert', 'code' => '<div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 px-4 py-3 rounded-lg flex items-center">
    <span class="mr-2">✕</span>
    <span>An error occurred. Please try again.</span>
</div>'],
            ['name' => 'Warning Alert', 'slug' => 'warning-alert', 'code' => '<div class="bg-yellow-100 dark:bg-yellow-900 border border-yellow-400 dark:border-yellow-600 text-yellow-700 dark:text-yellow-300 px-4 py-3 rounded-lg flex items-center">
    <span class="mr-2">⚠</span>
    <span>Please review your information.</span>
</div>'],
            ['name' => 'Info Alert', 'slug' => 'info-alert', 'code' => '<div class="bg-blue-100 dark:bg-blue-900 border border-blue-400 dark:border-blue-600 text-blue-700 dark:text-blue-300 px-4 py-3 rounded-lg flex items-center">
    <span class="mr-2">ℹ</span>
    <span>New updates are available.</span>
</div>'],
        ];

        foreach ($alerts as $alert) {
            $filePath = 'components/alerts/' . $alert['slug'] . '.blade.php';
            Storage::disk('public')->put($filePath, $alert['code']);
            Component::create([
                'category_id' => $category->id,
                'name' => $alert['name'],
                'slug' => $alert['slug'],
                'description' => $alert['name'],
                'uploaded_file' => $filePath,
                'is_active' => true,
            ]);
        }
    }
}

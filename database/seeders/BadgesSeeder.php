<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Component;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BadgesSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::where('slug', 'badges')->first();
        if (!$category) {
            $category = Category::create([
                'name' => 'Badges',
                'slug' => 'badges',
                'description' => 'Badge components',
                'is_active' => true,
            ]);
        }

        Storage::disk('public')->makeDirectory('components/badges');

        $badges = [
            ['name' => 'Primary Badge', 'slug' => 'primary-badge', 'code' => '<span class="inline-block bg-blue-600 dark:bg-blue-500 text-white text-xs px-3 py-1 rounded-full">Primary</span>'],
            ['name' => 'Success Badge', 'slug' => 'success-badge', 'code' => '<span class="inline-block bg-green-600 dark:bg-green-500 text-white text-xs px-3 py-1 rounded-full">Success</span>'],
            ['name' => 'Danger Badge', 'slug' => 'danger-badge', 'code' => '<span class="inline-block bg-red-600 dark:bg-red-500 text-white text-xs px-3 py-1 rounded-full">Danger</span>'],
            ['name' => 'Warning Badge', 'slug' => 'warning-badge', 'code' => '<span class="inline-block bg-yellow-600 dark:bg-yellow-500 text-white text-xs px-3 py-1 rounded-full">Warning</span>'],
        ];

        foreach ($badges as $badge) {
            $filePath = 'components/badges/' . $badge['slug'] . '.blade.php';
            Storage::disk('public')->put($filePath, $badge['code']);
            Component::create([
                'category_id' => $category->id,
                'name' => $badge['name'],
                'slug' => $badge['slug'],
                'description' => $badge['name'],
                'uploaded_file' => $filePath,
                'is_active' => true,
            ]);
        }
    }
}

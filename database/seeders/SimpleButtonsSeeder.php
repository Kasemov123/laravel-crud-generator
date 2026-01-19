<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Component;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SimpleButtonsSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::create([
            'name' => 'Buttons',
            'slug' => 'buttons',
            'description' => 'Button components',
            'is_active' => true,
        ]);

        Storage::disk('public')->makeDirectory('components/buttons');

        $buttons = [
            [
                'name' => 'Primary Button',
                'slug' => 'primary-button',
                'description' => 'Blue primary action button',
                'code' => '<button type="button" disabled class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition cursor-not-allowed opacity-90">
    Click me
</button>',
            ],
            [
                'name' => 'Secondary Button',
                'slug' => 'secondary-button',
                'description' => 'Gray secondary button',
                'code' => '<button type="button" disabled class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition cursor-not-allowed opacity-90">
    Click me
</button>',
            ],
            [
                'name' => 'Outline Button',
                'slug' => 'outline-button',
                'description' => 'Outlined button',
                'code' => '<button type="button" disabled class="border-2 border-blue-600 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition cursor-not-allowed opacity-90">
    Click me
</button>',
            ],
            [
                'name' => 'Danger Button',
                'slug' => 'danger-button',
                'description' => 'Red danger/delete button',
                'code' => '<button type="button" disabled class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition cursor-not-allowed opacity-90">
    Click me
</button>',
            ],
            [
                'name' => 'Success Button',
                'slug' => 'success-button',
                'description' => 'Green success button',
                'code' => '<button type="button" disabled class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition cursor-not-allowed opacity-90">
    Click me
</button>',
            ],
            [
                'name' => 'Ghost Button',
                'slug' => 'ghost-button',
                'description' => 'Minimal ghost button',
                'code' => '<button type="button" disabled class="text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-100 transition cursor-not-allowed opacity-90">
    Click me
</button>',
            ],
        ];

        foreach ($buttons as $button) {
            $filePath = 'components/buttons/' . $button['slug'] . '.blade.php';
            Storage::disk('public')->put($filePath, $button['code']);
            
            Component::create([
                'category_id' => $category->id,
                'name' => $button['name'],
                'slug' => $button['slug'],
                'description' => $button['description'],
                'uploaded_file' => $filePath,
                'is_active' => true,
            ]);
        }
    }
}

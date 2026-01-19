<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Component;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ExtraComponentsSeeder extends Seeder
{
    public function run(): void
    {
        // Image Card
        $cardsCategory = Category::where('slug', 'cards')->first();
        if ($cardsCategory) {
            $imageCard = '<div class="max-w-sm bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden">
    <div class="h-48 bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
        <span class="text-gray-500 dark:text-gray-400 text-lg font-semibold">No Photo Available</span>
    </div>
    <div class="p-6">
        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">Card Title</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-400">This is a card with image placeholder.</p>
        <button type="button" disabled class="mt-4 w-full bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded-lg cursor-not-allowed opacity-90">View Details</button>
    </div>
</div>';
            
            Storage::disk('public')->put('components/cards/image-card.blade.php', $imageCard);
            Component::create([
                'category_id' => $cardsCategory->id,
                'name' => 'Image Card',
                'slug' => 'image-card',
                'description' => 'Card with image placeholder',
                'uploaded_file' => 'components/cards/image-card.blade.php',
                'is_active' => true,
            ]);
        }

        // Image Table
        $tablesCategory = Category::where('slug', 'tables')->first();
        if ($tablesCategory) {
            $imageTable = '<div class="overflow-x-auto">
    <table class="min-w-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
                <th class="px-6 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Image</th>
                <th class="px-6 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Name</th>
                <th class="px-6 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Email</th>
                <th class="px-6 py-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-t border-gray-200 dark:border-gray-700">
                <td class="px-6 py-4">
                    <div class="w-12 h-12 bg-gray-300 dark:bg-gray-700 rounded-full flex items-center justify-center">
                        <span class="text-gray-500 dark:text-gray-400 text-xs">No Photo</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">John Doe</td>
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">john@example.com</td>
                <td class="px-6 py-4">
                    <span class="inline-block bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 px-2 py-1 rounded text-xs">Active</span>
                </td>
            </tr>
            <tr class="border-t border-gray-200 dark:border-gray-700">
                <td class="px-6 py-4">
                    <div class="w-12 h-12 bg-gray-300 dark:bg-gray-700 rounded-full flex items-center justify-center">
                        <span class="text-gray-500 dark:text-gray-400 text-xs">No Photo</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">Jane Smith</td>
                <td class="px-6 py-4 text-gray-800 dark:text-gray-200">jane@example.com</td>
                <td class="px-6 py-4">
                    <span class="inline-block bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 px-2 py-1 rounded text-xs">Inactive</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>';
            
            Storage::disk('public')->put('components/tables/image-table.blade.php', $imageTable);
            Component::create([
                'category_id' => $tablesCategory->id,
                'name' => 'Image Table',
                'slug' => 'image-table',
                'description' => 'Table with image placeholders',
                'uploaded_file' => 'components/tables/image-table.blade.php',
                'is_active' => true,
            ]);
        }

        // Footer
        $navCategory = Category::where('slug', 'navigation')->first();
        if ($navCategory) {
            $footer = '<footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Company</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 pointer-events-none">About Us</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 pointer-events-none">Careers</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 pointer-events-none">Contact</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Products</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 pointer-events-none">Features</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 pointer-events-none">Pricing</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 pointer-events-none">FAQ</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Resources</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 pointer-events-none">Blog</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 pointer-events-none">Documentation</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 pointer-events-none">Support</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Legal</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 pointer-events-none">Privacy</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 pointer-events-none">Terms</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 pointer-events-none">License</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 text-center">
            <p class="text-gray-600 dark:text-gray-400 text-sm">&copy; 2024 Company Name. All rights reserved.</p>
        </div>
    </div>
</footer>';
            
            Storage::disk('public')->put('components/navigation/footer.blade.php', $footer);
            Component::create([
                'category_id' => $navCategory->id,
                'name' => 'Footer',
                'slug' => 'footer',
                'description' => 'Website footer with links',
                'uploaded_file' => 'components/navigation/footer.blade.php',
                'is_active' => true,
            ]);
        }
    }
}

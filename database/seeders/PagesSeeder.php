<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Component;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::where('slug', 'pages')->first();
        if (!$category) {
            $category = Category::create([
                'name' => 'Pages',
                'slug' => 'pages',
                'description' => 'Complete page templates',
                'is_active' => true,
            ]);
        }

        Storage::disk('public')->makeDirectory('components/pages');

        $pages = [
            ['name' => 'Login Page', 'slug' => 'login-page', 'code' => '<div class="min-h-screen bg-gray-100 dark:bg-gray-800 flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white dark:bg-gray-900 rounded-lg shadow-xl p-8">
        <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-gray-100 mb-8">Login</h2>
        <form>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Email</label>
                <input type="email" value="user@example.com" readonly class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-200 cursor-not-allowed">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Password</label>
                <input type="password" value="password" readonly class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-200 cursor-not-allowed">
            </div>
            <button type="button" disabled class="w-full bg-blue-600 dark:bg-blue-500 text-white px-4 py-2 rounded-lg cursor-not-allowed opacity-90">Sign In</button>
        </form>
    </div>
</div>'],
            ['name' => 'Dashboard Page', 'slug' => 'dashboard-page', 'code' => '<div class="min-h-screen bg-gray-100 dark:bg-gray-800 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8">Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                <p class="text-gray-600 dark:text-gray-400 text-sm">Total Users</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-2">1,234</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                <p class="text-gray-600 dark:text-gray-400 text-sm">Revenue</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-2">$12,345</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
                <p class="text-gray-600 dark:text-gray-400 text-sm">Orders</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-2">567</p>
            </div>
        </div>
    </div>
</div>'],
            ['name' => '404 Page', 'slug' => '404-page', 'code' => '<div class="min-h-screen bg-gray-100 dark:bg-gray-800 flex items-center justify-center p-4">
    <div class="text-center">
        <h1 class="text-9xl font-bold text-gray-800 dark:text-gray-100">404</h1>
        <p class="text-2xl text-gray-600 dark:text-gray-400 mt-4">Page Not Found</p>
        <p class="text-gray-500 dark:text-gray-500 mt-2">The page you are looking for does not exist.</p>
        <button type="button" disabled class="mt-8 bg-blue-600 dark:bg-blue-500 text-white px-6 py-3 rounded-lg cursor-not-allowed opacity-90">Go Home</button>
    </div>
</div>'],
        ];

        foreach ($pages as $page) {
            $filePath = 'components/pages/' . $page['slug'] . '.blade.php';
            Storage::disk('public')->put($filePath, $page['code']);
            Component::create([
                'category_id' => $category->id,
                'name' => $page['name'],
                'slug' => $page['slug'],
                'description' => $page['name'],
                'uploaded_file' => $filePath,
                'is_active' => true,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Component;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FormsSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::create([
            'name' => 'Forms',
            'slug' => 'forms',
            'description' => 'Form input components',
            'is_active' => true,
        ]);

        Storage::disk('public')->makeDirectory('components/forms');

        $forms = [
            [
                'name' => 'Text Input',
                'slug' => 'text-input',
                'description' => 'Basic text input field',
                'code' => '<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
        Name
    </label>
    <input 
        type="text" 
        name="name" 
        id="name"
        placeholder="Enter your name"
        value="John Doe"
        readonly
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 cursor-not-allowed"
    >
</div>',
            ],
            [
                'name' => 'Email Input',
                'slug' => 'email-input',
                'description' => 'Email input field with validation',
                'code' => '<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
        Email
    </label>
    <input 
        type="email" 
        name="email" 
        id="email"
        placeholder="Enter your email"
        value="john@example.com"
        readonly
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 cursor-not-allowed"
    >
</div>',
            ],
            [
                'name' => 'Password Input',
                'slug' => 'password-input',
                'description' => 'Password input field',
                'code' => '<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
        Password
    </label>
    <input 
        type="password" 
        name="password" 
        id="password"
        placeholder="Enter your password"
        value="password123"
        readonly
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 cursor-not-allowed"
    >
</div>',
            ],
            [
                'name' => 'Textarea',
                'slug' => 'textarea',
                'description' => 'Multi-line text area',
                'code' => '<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="message">
        Message
    </label>
    <textarea 
        name="message" 
        id="message"
        rows="4"
        placeholder="Enter your message"
        readonly
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 cursor-not-allowed"
    >This is a sample message text.</textarea>
</div>',
            ],
            [
                'name' => 'Select Dropdown',
                'slug' => 'select-dropdown',
                'description' => 'Dropdown select field',
                'code' => '<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="country">
        Country
    </label>
    <select 
        name="country" 
        id="country"
        disabled
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50 cursor-not-allowed"
    >
        <option value="">Select a country</option>
        <option value="us" selected>United States</option>
        <option value="uk">United Kingdom</option>
        <option value="ca">Canada</option>
    </select>
</div>',
            ],
            [
                'name' => 'Checkbox',
                'slug' => 'checkbox',
                'description' => 'Checkbox input',
                'code' => '<div class="mb-4">
    <label class="inline-flex items-center cursor-not-allowed">
        <input 
            type="checkbox" 
            name="agree" 
            id="agree"
            checked
            disabled
            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-not-allowed"
        >
        <span class="ml-2 text-gray-700">I agree to the terms and conditions</span>
    </label>
</div>',
            ],
            [
                'name' => 'Radio Button',
                'slug' => 'radio-button',
                'description' => 'Radio button group',
                'code' => '<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">Gender</label>
    <div class="space-y-2">
        <label class="inline-flex items-center cursor-not-allowed">
            <input 
                type="radio" 
                name="gender" 
                value="male"
                checked
                disabled
                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-not-allowed"
            >
            <span class="ml-2 text-gray-700">Male</span>
        </label>
        <br>
        <label class="inline-flex items-center cursor-not-allowed">
            <input 
                type="radio" 
                name="gender" 
                value="female"
                disabled
                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-not-allowed"
            >
            <span class="ml-2 text-gray-700">Female</span>
        </label>
    </div>
</div>',
            ],
            [
                'name' => 'Insert Form',
                'slug' => 'insert-form',
                'description' => 'Complete insert/create form',
                'code' => '<form class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Create New User</h2>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
            Name
        </label>
        <input type="text" id="name" name="name" value="John Doe" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed" placeholder="Enter name">
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
            Email
        </label>
        <input type="email" id="email" name="email" value="john@example.com" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed" placeholder="Enter email">
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
            Password
        </label>
        <input type="password" id="password" name="password" value="password123" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed" placeholder="Enter password">
    </div>
    
    <button type="button" disabled class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition cursor-not-allowed opacity-90">
        Create User
    </button>
</form>',
            ],
            [
                'name' => 'Update Form',
                'slug' => 'update-form',
                'description' => 'Complete update/edit form',
                'code' => '<form class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Update User</h2>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
            Name
        </label>
        <input type="text" id="name" name="name" value="John Doe" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed" placeholder="Enter name">
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
            Email
        </label>
        <input type="email" id="email" name="email" value="john@example.com" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed" placeholder="Enter email">
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
            Phone
        </label>
        <input type="tel" id="phone" name="phone" value="+1234567890" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed" placeholder="Enter phone">
    </div>
    
    <button type="button" disabled class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition cursor-not-allowed opacity-90">
        Update User
    </button>
</form>',
            ],
            [
                'name' => 'Edit Form',
                'slug' => 'edit-form',
                'description' => 'Complete edit form with all fields',
                'code' => '<form class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Profile</h2>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
            Username
        </label>
        <input type="text" id="username" name="username" value="johndoe" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed">
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="bio">
            Bio
        </label>
        <textarea id="bio" name="bio" rows="3" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed">Web developer and designer</textarea>
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="country">
            Country
        </label>
        <select id="country" name="country" disabled class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed">
            <option value="us" selected>United States</option>
            <option value="uk">United Kingdom</option>
        </select>
    </div>
    
    <button type="button" disabled class="w-full bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition cursor-not-allowed opacity-90">
        Save Changes
    </button>
</form>',
            ],
            [
                'name' => 'Contact Form',
                'slug' => 'contact-form',
                'description' => 'Complete contact form',
                'code' => '<form class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Contact Us</h2>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
            Name
        </label>
        <input type="text" id="name" name="name" value="John Doe" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed" placeholder="Your name">
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
            Email
        </label>
        <input type="email" id="email" name="email" value="john@example.com" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed" placeholder="your@email.com">
    </div>
    
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="message">
            Message
        </label>
        <textarea id="message" name="message" rows="4" readonly class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed" placeholder="Your message">Hello, I would like to get in touch with you.</textarea>
    </div>
    
    <button type="button" disabled class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition cursor-not-allowed opacity-90">
        Send Message
    </button>
</form>',
            ],
        ];

        foreach ($forms as $form) {
            $filePath = 'components/forms/' . $form['slug'] . '.blade.php';
            Storage::disk('public')->put($filePath, $form['code']);
            
            Component::create([
                'category_id' => $category->id,
                'name' => $form['name'],
                'slug' => $form['slug'],
                'description' => $form['description'],
                'uploaded_file' => $filePath,
                'is_active' => true,
            ]);
        }
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_generator_has_rate_limiting(): void
    {
        for ($i = 0; $i < 6; $i++) {
            $response = $this->get('/generator');
        }
        
        $response->assertStatus(429); // Too Many Requests
    }

    public function test_dangerous_php_code_is_rejected(): void
    {
        $this->actingAs(\App\Models\User::factory()->create());
        
        $category = \App\Models\Category::factory()->create();
        
        $response = $this->post('/admin/components', [
            'category_id' => $category->id,
            'name' => 'Test Component',
            'slug' => 'test-component',
            'input_method' => 'code',
            'blade_code' => '<?php system("ls"); ?>',
            'is_active' => true,
        ]);
        
        $this->assertDatabaseMissing('components', [
            'name' => 'Test Component'
        ]);
    }

    public function test_path_traversal_is_blocked(): void
    {
        $this->actingAs(\App\Models\User::factory()->create());
        
        $category = \App\Models\Category::factory()->create();
        
        $response = $this->post('/admin/components', [
            'category_id' => $category->id,
            'name' => 'Test Component',
            'slug' => 'test-component',
            'input_method' => 'path',
            'file_path' => '../../.env',
            'is_active' => true,
        ]);
        
        $response->assertSessionHasErrors();
    }

    public function test_max_fields_limit_is_enforced(): void
    {
        $fields = array_fill(0, 51, [
            'name' => 'field',
            'type' => 'string',
            'nullable' => false,
            'unique' => false,
        ]);
        
        $component = \Livewire\Livewire::test(\App\Livewire\CodeGenerator::class)
            ->set('modelName', 'Test')
            ->set('fields', $fields)
            ->call('generate');
        
        $component->assertHasNoErrors();
        $component->assertSet('showPreview', false);
    }
}

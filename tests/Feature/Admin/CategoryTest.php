<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_category_page_has_next_sequence()
    {
        $user = User::factory()->create();

        Category::create([
            'name' => 'Cat 1',
            'slug' => 'cat-1',
            'sequence' => 10,
            'is_active' => true
        ]);

        Category::create([
            'name' => 'Cat 2',
            'slug' => 'cat-2',
            'sequence' => 5,
            'is_active' => true
        ]);

        $response = $this->actingAs($user)->get(route('admin.categories.create'));

        $response->assertStatus(200);
        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Admin/Categories/Create')
                ->has('nextSequence')
                ->where('nextSequence', 11)
        );
    }

    public function test_create_category_page_defaults_sequence_to_1_if_no_categories()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.categories.create'));

        $response->assertStatus(200);
        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Admin/Categories/Create')
                ->has('nextSequence')
                ->where('nextSequence', 1)
        );
    }
}

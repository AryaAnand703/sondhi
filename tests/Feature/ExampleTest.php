<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Test storefront home page loads successfully.
     */
    public function test_the_storefront_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test products API returns JSON catalog.
     */
    public function test_products_api_returns_catalog(): void
    {
        $response = $this->getJson('/api/products');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'price', 'category', 'fragrance']
        ]);
    }

    /**
     * Test seeded user authentication.
     */
    public function test_user_can_authenticate(): void
    {
        $response = $this->postJson('/auth/login', [
            'login' => 'arya',
            'password' => 'arya123',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);
        $this->assertAuthenticated();
    }

    /**
     * Test guest cannot access admin portal.
     */
    public function test_guest_is_redirected_from_admin_portal(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/');
    }

    /**
     * Test admin user can access admin portal.
     */
    public function test_admin_can_access_admin_portal(): void
    {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }

    /**
     * Test customer cannot access superadmin portal.
     */
    public function test_customer_cannot_access_superadmin_portal(): void
    {
        $customer = User::where('role', 'customer')->first();
        $response = $this->actingAs($customer)->get('/superadmin');
        $response->assertRedirect('/');
    }

    /**
     * Test superadmin can access superadmin portal.
     */
    public function test_superadmin_can_access_superadmin_portal(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $response = $this->actingAs($superadmin)->get('/superadmin');
        $response->assertStatus(200);
    }

    /**
     * Test storefront page does not show admin or superadmin login links.
     */
    public function test_storefront_does_not_contain_admin_or_superadmin_logins(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSee('Atelier Admin (Pass Required)');
        $response->assertDontSee('Super Admin (Pass Required)');
        $response->assertDontSee('Atelier Operations Admin');
        $response->assertDontSee('Super Admin Governance');
    }

    /**
     * Test separate admin login opens admin portal.
     */
    public function test_admin_login_redirects_to_admin_portal(): void
    {
        $response = $this->postJson('/auth/login', [
            'login' => 'meera',
            'password' => 'meera123',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'redirect' => route('admin.index'),
        ]);
    }

    /**
     * Test separate superadmin login opens superadmin portal.
     */
    public function test_superadmin_login_redirects_to_superadmin_portal(): void
    {
        $response = $this->postJson('/auth/login', [
            'login' => 'superadmin',
            'password' => 'admin123',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'redirect' => route('superadmin.index'),
        ]);
    }
}

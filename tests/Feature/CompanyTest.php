<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user
        $this->admin = User::factory()->create([
            'email' => 'admin@admin.com',
        ]);
    }

    public function test_admin_can_see_companies_list(): void
    {
        $this->actingAs($this->admin)
            ->get(route('companies.index'))
            ->assertStatus(200)
            ->assertViewIs('companies.index');
    }

    public function test_admin_can_create_company(): void
    {
        Storage::fake('public');

        $companyData = [
            'name' => $this->faker->company,
            'email' => $this->faker->companyEmail,
            'website' => $this->faker->url,
            'logo' => UploadedFile::fake()->image('logo.jpg', 100, 100),
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('companies.store'), $companyData);

        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', [
            'name' => $companyData['name'],
            'email' => $companyData['email'],
            'website' => $companyData['website'],
        ]);

        $company = Company::where('name', $companyData['name'])->first();
        $this->assertNotNull($company->logo);
        $this->assertTrue(Storage::disk('public')->exists(str_replace('/storage/', '', $company->logo)));
    }

    public function test_admin_can_update_company(): void
    {
        $company = Company::factory()->create();
        $updatedData = [
            'name' => $this->faker->company,
            'email' => $this->faker->companyEmail,
            'website' => $this->faker->url,
        ];

        $response = $this->actingAs($this->admin)
            ->put(route('companies.update', $company), $updatedData);

        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => $updatedData['name'],
            'email' => $updatedData['email'],
            'website' => $updatedData['website'],
        ]);
    }

    public function test_admin_can_delete_company(): void
    {
        $company = Company::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('companies.destroy', $company));

        $response->assertRedirect(route('companies.index'));
        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    }

    public function test_company_requires_name(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('companies.store'), [
                'email' => $this->faker->email,
                'website' => $this->faker->url,
            ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_company_logo_must_be_valid_image(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('companies.store'), [
                'name' => $this->faker->company,
                'logo' => 'not-an-image',
            ]);

        $response->assertSessionHasErrors('logo');
    }
}

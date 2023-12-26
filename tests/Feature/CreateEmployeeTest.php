<?php
namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Tests\Feature\Trait\EmployeeTrait;

use Database\Seeders\{AdminSeeder, UserTypeSeeder};
use Illuminate\Support\Facades\DB;

class CreateEmployeeTest extends TestCase
{

    use RefreshDatabase, EmployeeTrait;


    public function test_employee_create_successful(): void
    {

        $this->seed(UserTypeSeeder::class);

        Sanctum::actingAs(
            User::factory()->create(),
            ['is_admin']
        );

        $user_params = ['name' => 'John Adams', 'email' => 'johnadams@employee.com', 'password' => '111'];

        $response = $this->postJson('/api/employee/create', $user_params);

        $response->assertStatus(201)->assertJson(['message' => 'Сотрудник успешно создан']);

    }


    public function test_employee_create_already_exists(): void
    {
        
        $this->seed(UserTypeSeeder::class);

        Sanctum::actingAs(
            User::factory()->create(),
            ['is_admin']
        );

        $user_params = ['name' => 'John Adams', 'email' => 'johnadams@employee.com', 'password' => '111'];

        DB::table('users')->insert($user_params);

        $response = $this->postJson('/api/employee/create', $user_params);

        $response->assertStatus(409)->assertJson(['error' => 'Данный пользователь уже существует в системе']);
    }


}
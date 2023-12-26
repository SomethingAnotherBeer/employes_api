<?php
namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Tests\Feature\Trait\EmployeeTrait;

use Database\Seeders\{UserTypeSeeder, RateSeeder};
use Illuminate\Support\Facades\DB;


class EmployeeRateTest extends TestCase
{
    use RefreshDatabase, EmployeeTrait;



    public function test_employee_set_rate_succesful(): void
    {
        $this->seed(UserTypeSeeder::class);
        $this->seed(RateSeeder::class);

        $current_employee_params = ['name' => 'John Adams', 'email' => 'johnadams@employee.com', 'password' => '111'];
        $currentEmployee = $this->createEmployee($current_employee_params);

        
        Sanctum::actingAs(
            User::factory()->create(),
            ['is_admin']
        );

        $params = ['employee_id' => $currentEmployee->id, 'rate_slug' => 'per_hour', 'payment' => 1000];

        $response = $this->postJson('/api/employee/setrate', $params);
        $response->assertStatus(201)->assertJson(['message' => 'Рабочая ставка закреплена за сотрудником']);

    }


    public function test_employee_set_rate_employee_not_found(): void
    {
        $this->seed(UserTypeSeeder::class);
        $this->seed(RateSeeder::class);

        Sanctum::actingAs(
            User::factory()->create(),
            ['is_admin']
        );

        $params = ['employee_id' => 5, 'rate_slug' => 'per_hour', 'payment' => 2000];

        $response = $this->postJson('/api/employee/setrate', $params);
        $response->assertStatus(404)->assertJson(['error' => 'Пользователь не найден']);

    }


    public function test_employee_set_rate_rate_not_found(): void
    {
        $this->seed(UserTypeSeeder::class);
        $this->seed(RateSeeder::class);

        $current_employee_params = ['name' => 'John Adams', 'email' => 'johnadams@employee.com', 'password' => '111'];
        $currentEmployee = $this->createEmployee($current_employee_params);

        Sanctum::actingAs(
            User::factory()->create(),
            ['is_admin']
        );

        $params = ['employee_id' => $currentEmployee->id, 'rate_slug' => 'some_rate', 'payment' => 1000];

        $response = $this->postJson('/api/employee/setrate', $params);
        $response->assertStatus(404)->assertJson(['error' => 'Запрашиваемая рабочая ставка не найдена']);
    }


}
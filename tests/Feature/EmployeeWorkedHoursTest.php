<?php
namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Tests\Feature\Trait\{EmployeeTrait, HoursTransactionTrait};

use Database\Seeders\{UserTypeSeeder};
use Illuminate\Support\Facades\DB;

use App\Models\HoursTransaction;


class EmployeeWorkedHoursTest extends TestCase
{
    use RefreshDatabase, EmployeeTrait, HoursTransactionTrait;


    public function test_add_worked_hours_to_employee_successful(): void
    {
        $this->seed(UserTypeSeeder::class);

        $current_employee_params = ['name' => 'John Adams', 'email' => 'johnadams@employee.com', 'password' => '111'];
        $currentEmployee = $this->createEmployee($current_employee_params);

        Sanctum::actingAs(
            User::factory()->create(),
            ['is_admin']
        );

        $params = ['employee_id' => $currentEmployee->id, 'worked_hours' => 10];

        $response = $this->postJson('/api/employee/setworkedhoursto', $params);
        $response->assertStatus(201)->assertJson(['message' => 'Рабочие часы успешно добавлены']);
    }


    public function test_add_worked_hours_to_employee_employee_not_found(): void
    {
        $this->seed(UserTypeSeeder::class);

        Sanctum::actingAs(
            User::factory()->create(),
            ['is_admin']
        );

        $params = ['employee_id' => 2, 'worked_hours' => 10];
        
        $response = $this->postJson('/api/employee/setworkedhoursto', $params);
        $response->assertStatus(404)->assertJson(['error' => 'Пользователь не найден']);
    }

    public function test_add_worked_hours_to_employee_for_already_done(): void
    {
        $this->seed(UserTypeSeeder::class);

        $current_employee_params = ['name' => 'John Adams', 'email' => 'johnadams@employee.com', 'password' => '111'];
        $currentEmployee = $this->createEmployee($current_employee_params);
        $currentHoursTransaction = $this->createHoursTransactionForEmployee($currentEmployee);

        $currentHoursTransaction->is_done = true;
        $currentHoursTransaction->save();

        Sanctum::actingAs(
            User::factory()->create(),
            ['is_admin']
        );

        $current_date = date("Y-m-d");

        $a = HoursTransaction::where('hours_transaction_created', $current_date)
        ->where('user_id', $currentEmployee->id)->first();

        $params =['employee_id' => $currentEmployee->id, 'worked_hours' => 10];

        $response = $this->postJson('/api/employee/setworkedhoursto', $params);

        $response->assertStatus(409)->assertJson(['error' => 'Платежная транзакция уже осуществлена осуществлена за сегодня. Данные по ней невозможно изменить']);

    }

    
    public function test_add_worked_hours_for_yourself_successful(): void
    {
        $this->seed(UserTypeSeeder::class);

        Sanctum::actingAs(
            User::factory()->create(),
            ['is_employee']
        );

        $params = ['worked_hours' => 10];
        
        $response = $this->postJson('/api/employee/setworkedhours', $params);
        $response->assertStatus(201)->assertJson(['message' => 'Рабочие часы успешно добавлены']);

    }

    
    public function test_add_worked_hours_for_yourself_already_done(): void
    {
        $this->seed(UserTypeSeeder::class);

        $currentEmployee = User::factory()->create();

        Sanctum::actingAs(
            $currentEmployee,
            ['is_employee']
        );

        $currentHoursTransaction = $this->createHoursTransactionForEmployee($currentEmployee);

        $currentHoursTransaction->is_done = true;
        $currentHoursTransaction->save();

        $params = ['worked_hours' => 10];

        $response = $this->postJson('/api/employee/setworkedhours', $params);
        $response->assertStatus(409)->assertJson(['error' => 'Платежная транзакция уже осуществлена осуществлена за сегодня. Данные по ней невозможно изменить']);


    }



}
<?php
namespace Tests\Feature;

use App\Models\User;
use Laravel\Sanctum\Sanctum;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Tests\Feature\Trait\{EmployeeTrait, HoursTransactionTrait};

use Database\Seeders\{UserTypeSeeder, RateSeeder};
use Illuminate\Support\Facades\DB;

use App\Models\HoursTransaction;

class PaymentsTest extends TestCase
{
    use RefreshDatabase, EmployeeTrait, HoursTransactionTrait;

    public function test_get_all_payments_by_hours(): void
    {
        $this->seed(UserTypeSeeder::class);
        $this->seed(RateSeeder::class);

        $this->setWorkersAndGetTransactions();

        Sanctum::actingAs(
            User::factory()->create(),
            ['is_admin']
        );


        $response = $this->getJson('/api/payments/hours/all');
        print_r($response);
        $response->assertStatus(200);

    }


    public function test_execute_transactions_success(): void
    {
        $this->seed(UserTypeSeeder::class);
        $this->seed(RateSeeder::class);

        $this->setWorkersAndGetTransactions();

        Sanctum::actingAs(
            User::factory()->create(),
            ['is_admin']
        );


        $response = $this->postJson('/api/payments/hours/execute');
        $response->assertStatus(201)->assertJson(['message' => 'Платежные транзакции по часовой ставке успешно осуществлены']);

    }



    public function test_execute_transactions_no_transactions(): void
    {
        $this->seed(UserTypeSeeder::class);
        $this->seed(RateSeeder::class);

        $current_transactions = $this->setWorkersAndGetTransactions();

        foreach ($current_transactions as $currentTransaction) {
            $currentTransaction->is_done = true;
            $currentTransaction->save();
        }

        Sanctum::actingAs(
            User::factory()->create(),
            ['is_admin']
        );

        $response = $this->postJson('/api/payments/hours/execute');
        $response->assertStatus(200)->assertJson(['message' => 'Нет транзакций по часовой ставке, ожидающих завершения']);


    }


    protected function setWorkersAndGetTransactions(): array
    {
        $current_workers = [];
        $current_transactions = [];

        $workers_params = [
            ['name' => 'John Adams', 'email' => 'johnadams@employee.com', 'password' => '111'],
            ['name' => 'Marcus Miller', 'email' => 'marcusmiller@employee.com', 'password' => '222'],

        ];
        
        $dates = ['2023-12-18', '2023-12-19', '2023-12-20', '2023-12-21', '2023-12-22'];


        foreach ($workers_params as $worker_params) {
            $current_workers[] = $this->createEmployee($worker_params);
        }

        foreach ($current_workers as $currentWorker) {
            foreach ($dates as $date) {
                $current_transactions[] = $this->createHoursTransactionForEmployee($currentWorker, $date);
            }
        }

        foreach ($current_transactions as $currentTransaction) {
            $currentTransaction->worked_hours = rand(4, 12);
        }


        return $current_transactions;

    }




}
<?php
namespace Tests\Feature\Trait;
use App\Models\{User, HoursTransaction};


trait HoursTransactionTrait
{
    protected function createHoursTransactionForEmployee(User $employee, string $date = null): HoursTransaction
    {
        $current_date = $date ?? date("Y-m-d");

        $hoursTransaction = HoursTransaction::create([
            'user_id' => $employee->id,
            'worked_hours' => 0,
            'is_done' => false,
            'hours_transaction_created' => $current_date,
        ]);

        return $hoursTransaction;
    }
}
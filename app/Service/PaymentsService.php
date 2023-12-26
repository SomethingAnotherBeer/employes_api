<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;
use App\Models\HoursTransaction;


class PaymentsService
{
    
    public function getAllPaymentsByHours(): array
    {
        $query = "SELECT users.id AS employee_id, SUM(hours_transactions.worked_hours * users_rates.payment) AS payments
            FROM users INNER JOIN hours_transactions ON users.id = hours_transactions.user_id INNER JOIN users_rates ON
            users.id = users_rates.user_id INNER JOIN rates ON users_rates.rate_id = rates.id
            WHERE hours_transactions.is_done IS FALSE AND rates.rate_slug = 'per_hour'
            GROUP BY users.id
        ";

        $payments = DB::select($query);

        return $payments;
    }


    public function executeAllPaymentsByHours(): array
    {
        $undoneHoursTransactions = HoursTransaction::where('is_done', false)->get();

        $success = false;
        $message = "";

        if (0 === count($undoneHoursTransactions)) {
            $message = "Нет транзакций по часовой ставке, ожидающих завершения";
        }

        else {

            try {
                DB::beginTransaction();

                foreach ($undoneHoursTransactions as $undoneHoursTransaction) {
                    $undoneHoursTransaction->is_done = true;
                    $undoneHoursTransaction->save();
                }

                DB::commit();

                $message = "Платежные транзакции по часовой ставке успешно осуществлены";
                $success = true;

            }

            catch(\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        }

        return ['status' => $success, 'message' => $message];


    }



}
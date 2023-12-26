<?php
namespace App\Service\Employee;

use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\Transaction\CurrentDateTransactionAlreadyDoneException;
use App\Helpers\ValidationHelper;
use App\Service\UserService;

use App\Models\{User, UsersTypes, UserType, HoursTransaction};
use Illuminate\Support\Facades\DB;

class EmployeeService
{
    use ValidationHelper;

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function createEmployee(array $employee_params): array
    {     
        try {
            DB::beginTransaction();

            $user = $this->userService->createUser($employee_params);
            $employee_type = UserType::where('user_type_name', 'employee')->first();
        
            UsersTypes::create([
                'user_id' => $user->id,
                'user_type_id' => $employee_type->id,
            ]);


            DB::commit();

            return ['id' => $user->id, 'message' => 'Сотрудник успешно создан'];
        }

        catch(\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function setWorkedHours(array $worked_hours_params): array
    {
        $rules = [
            'employee_id' => ['required', 'integer'],
            'worked_hours' => ['required', 'integer'],

        ];

        $this->validateParams($worked_hours_params, $rules);

        if (!User::where('id', $worked_hours_params['employee_id'])->first()) {
            throw new UserNotFoundException("Пользователь не найден");
        }

        $current_date = date("Y-m-d");

        $currentDateTransaction = HoursTransaction::where('hours_transaction_created', $current_date)
                            ->where('user_id', $worked_hours_params['employee_id'])->first();
                            
        if (!$currentDateTransaction) {
            
            $currentDateTransaction = HoursTransaction::create([
                'user_id' => $worked_hours_params['employee_id'],
                'worked_hours' => $worked_hours_params['worked_hours'],
                'hours_transaction_created' => $current_date,
            ]);
        }

        else {

            if ($currentDateTransaction->is_done) {
                throw new CurrentDateTransactionAlreadyDoneException("Платежная транзакция уже осуществлена осуществлена за сегодня. Данные по ней невозможно изменить"); 
            }

            $currentDateTransaction->worked_hours = $worked_hours_params['worked_hours'];
            $currentDateTransaction->save();
        }

        return ['id' => $currentDateTransaction->id, 'message' => 'Рабочие часы успешно добавлены'];


    }



}
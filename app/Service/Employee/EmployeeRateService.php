<?php
namespace App\Service\Employee;

use App\Helpers\ValidationHelper;
use App\Models\{User, UsersRate, Rate};

use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\Rate\RateNotFoundException;
use Illuminate\Support\Facades\DB;

class EmployeeRateService
{
    use ValidationHelper;



    public function setEmployeeRate(array $employee_rate_params): array
    {
        $rules = [
            'employee_id' => ['required', 'integer'],
            'rate_slug' => ['required', 'string'],
            'payment' => ['nullable', 'decimal:0,2'],
        ];

        $this->validateParams($employee_rate_params, $rules);

        $employee = DB::table('users')->join('users_types', 'users.id', '=', 'users_types.user_id')
            ->where('users.id', $employee_rate_params['employee_id'])
            ->select('users.*')->first();
            

        if (!$employee) {
            throw new UserNotFoundException("Пользователь не найден");
        }

        $rate = Rate::where('rate_slug', $employee_rate_params['rate_slug'])->first();

        if (!$rate) {
            throw new RateNotFoundException("Запрашиваемая рабочая ставка не найдена");
        }

        $employeeRate = UsersRate::where('user_id', $employee->id)->where('rate_id', $rate->id)->first();

        if (!$employeeRate) {
            $employeeRate = UsersRate::create([
                'user_id' => $employee->id,
                'rate_id' => $rate->id,
            ]);
        }

        $employeeRate->payment = $employee_rate_params['payment'];
        $employeeRate->save();

        return ['id' => $employeeRate->id, 'message' => 'Рабочая ставка закреплена за сотрудником'];
    }


    


}
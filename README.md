## Employes api

Миграция бд
php artisan migrate
php db:seed

Документация API

1. Логин
   Методы: POST
   Тело запроса:
   -email: string|email
   -password: string
   

## API администратора  


1. Создание сотрудника
    Методы: POST
   
   Тело запроса:
   
   -name: string
   
   -email: string|email
   
   -password: string
   

   Url: http://{host_name}/api/employee/create
   

2. Закрепление рабочей ставки за сотрудником
 
   По умолчанию доступно две рабочие ставки: per_hour и per_week.
   
   Методы: POST, PATCH
   Тело запроса:
   
   -employee_id: int
   
   -rate_slug: string
   
   -payment: decimal, точность от 0 до 2
   

   Url: http://{host_name}/api/employee/setrate
   Если данная рабочая ставка уже закреплена за сотрудником, то обновляется параметр payment, переданный в запросе

3. Добавление/обновление транзакции рабочих часов сотруднику

   Методы: POST, PATCH
   Тело запроса:
   -employee_id: int
   -worked_hours: int

   Url: http://{host_name}/api/employee/setworkedhoursto

Если данная транзакция еще не существует в БД за сегодня, то она создается, в противном случае обновляется параметр worked_hours

4. Получение всей суммы по незавершенным транзакциям
   Методы: GET
   Url: http://{host_name}/api/payments/hours/all

5. Закрытие всех неопогашенных транзакций
   Методы: POST
   Url:  http://{host_name}/api/payments/hours/execute

## Api сотрудника  
1. Добавление/обновление транзакции рабочих часов
   Методы: POST, PATCH
   Тело запроса:
   -worked_hours: int

   url: http:/{host_name}/api/employee/setworkedhours


По умолчанию, в результате применения миграции и сидера базы данных (начало документации), в системе уже имеется пользователь с правами администратора. email и пароль указаны в параметрах при создании пользователя в файле database/seeders/AdminSeeder.php.  
Также данными наполняется таблица рабочих ставок, содержащая значения per_hour и per_week.


   

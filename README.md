## Employes api  

## Действия перед использованием  


Миграция бд php artisan migrate  

Наполение бд необходимыми данными: (типы пользователей и рабочие ставки) php db:seed  



## Логическая схема базы данных  
![schema](https://github.com/SomethingAnotherBeer/employes_api/blob/main/%D0%9B%D0%BE%D0%B3%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%B0%D1%8F%20%D1%81%D1%85%D0%B5%D0%BC%D0%B0%20%D0%B1%D0%B0%D0%B7%D1%8B%20%D0%B4%D0%B0%D0%BD%D0%BD%D1%8B%D1%85.png)


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
   

3. Закрепление рабочей ставки за сотрудником
 
   По умолчанию доступно две рабочие ставки: per_hour и per_week.
   
   Методы: POST, PATCH
   Тело запроса:
   
   -employee_id: int
   
   -rate_slug: string
   
   -payment: decimal, точность от 0 до 2
   

   Url: http://{host_name}/api/employee/setrate
   
   Если данная рабочая ставка уже закреплена за сотрудником, то обновляется параметр payment, переданный в запросе

4. Добавление/обновление транзакции рабочих часов сотруднику

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
   

## API сотрудника  
1. Добавление/обновление транзакции рабочих часов
    
   Методы: POST, PATCH
   
   Тело запроса:
   
   -worked_hours: int
   

   url: http:/{host_name}/api/employee/setworkedhours
   


По умолчанию, в результате применения миграции и сидера базы данных (начало документации), в системе уже имеется пользователь с правами администратора. email и пароль указаны в параметрах при создании пользователя в файле database/seeders/AdminSeeder.php.  
Также данными наполняется таблица рабочих ставок, содержащая значения per_hour и per_week.


   

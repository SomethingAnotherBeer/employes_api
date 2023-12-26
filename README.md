## Employes api

Миграция бд
php artisan migrate
php db:seed

Документация API

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

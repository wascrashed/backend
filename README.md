# Admin Tbuy API

## Установка 

#### 1) Установить все независимости 
```bash
composer install
```
#### 2) Копи паст ```.env.example``` как ```.env``` и написать все креды для DB(pgsql) и redis

#### 3) Запустить миграцию
```bash
php artisan migrate:fresh --seed
```

#### 4) Потом генерациб ключа
```bash
php artisan key:generate
```

#### 6) Есть дефолтный пользователь со всеми пермишенами с кредами
```json
{
    "email": "admin@admin.com",
    "password": "password"
}
```

#### 7) Для генерации АПИ документации:
```bash
php artisan scribe:generate
```
#### Документация к АПИ находится по url ```https://127.0.0.1:8000/docs```

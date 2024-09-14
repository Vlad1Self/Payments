
# Payments

API на Laravel для обработки платежей. 


## Installation

Установка стандартная. Для удобства написан Dockerfile и docker-compose.yml

```bash
  npm install
  composer install
  cp .env.example .env
```
    
## Documentation

В проекте реализовано:

 * Слой DTO c помощью библиотеки от [Spatie](https://github.com/spatie/data-transfer-object)
 * Работа с Enum с помощью библиотеки от [BenSampo](https://github.com/BenSampo/laravel-enum)
 * Архитектура DDD
 * Гибкое подключение новых способов оплаты благодаря системе драйверов
 * Подключение к Stripe
 * Автотесты
 * Полиморфное отношение
 * Классы ValueObject


## Usage/Examples

Наполнение БД тестовыми данными 
```
php artisan db:seed
```


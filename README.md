<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Проект "Blog"
#### Для того что бы запустить проект, нужно:
  - Склонировать репрозиторий
  - Настроить файл .env
  - Выполнить команду php artisan migrate
  - Выполнить команду php artisan db:seed

Для редактирования данных входить под login: admin@admin.ru, password: admin123

####  Методы Api:

| Method | URI       | Action          |
  |--------|----------|------------------|
  | GET    |/article    |Получить все статьи|
  | POST   |/article |Добавить новую статью|
  | GET    |/article/{id}|Получить одну статью|
  | PUT    |/article/{id}|Обновить статью|
  | DELETE |/article/{id}|Удалить статью|
  
  Для работы с методами добавления/обновления/удаления нужно в header слать поле name со значением admin

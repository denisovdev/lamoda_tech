# Lamoda

### _Тестовое задание php junior_

API для работы с товарами на одном или нескольких складах.

Для запуска требуется наличие установленных [git](https://git-scm.com), [docker](https://www.docker.com), Make.

- Веб-сервер Nginx по умолчанию из docker-контейнера слушает `80` порт.
- Postgres работает на `5432` порту.

При необходимости, порты можно изменить в конфигурации .env, находящейся в корневой директории проекта:

`POSTGRES_PORT` — внешний порт Postgres

`NGINX_PORT` — внешний порт Nginx


### Запуск
```
git clone https://github.com/denisovdev/lamoda_tech

cd lamoda_tech

make up
```

После загрузки необходимых компонентов происходит:
1) Запуск postgres контейнера
2) Запуск php-fpm контейнера
3) Установка пакетов с помощью Composer
4) Запуск Doctrine миграций
3) Запуск веб-сервера Nginx

### Сервис настроен и готов к работе


[POSTMAN коллекция с описанием методов](https://documenter.getpostman.com/view/34122323/2sA3JKcMYg)

<h1 align="center">Сервис для хеширования</h1>

## -> Установка проекта

Скачайте git репозиторий при помощи команды.

###`git clone "https://github.com/sens2k/hash-service.git"`

Перейдите в папку с проектом и подключите зависимости при помощи [Composer](https://getcomposer.org/).
</br>Вводим команду в терминале:

###`composer install`

## -> Подключение к базе данных

Откройте файл .env и настройте подключение к БД.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE= название БД
DB_USERNAME= имя пользователя
DB_PASSWORD= пароль
```

## -> Выполнение миграций

Введи команду в терминале

###`php artisan migrate`

## -> Запуск проект

Введите команду в терминале

###`php artisan serve`

## -> Настройка очередей

Для обработки задач, в проекте используются очереди.
</br>Для запуска одной очереди введите команду в отдельном окне терминала .

###`php artisan queue:work --queue=high,low`

Для реализации одновременной обратоки задач, необходимо запустить несколько очередей. 
Это можно сделать локально испоьзуя несколько вкладко в терминале
</br>Количество очередей определяет количество одновременно выполняемых задач.

###Чтобы команда queue:work работала постоянно, нужно установить монитор процессов, Supervisor.

Если вы используете Ubuntu, то можете установить его с помощью команды:

###`sudo apt-get install supervisor`

Далее необходимо создать конфиг файл в каталоге `/etc/supervisor/conf.d`.
Файл конфигурации должен выглядеть так:
```
[program:jobs-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /ПУТЬ К ВАШЕМУ ПРОЕКТУ/host-service/artisan queue:work --queue=high,low
autostart=true
autorestart=true
user=djug
numprocs=5
redirect_stderr=true
stdout_logfile=/ПУТЬ К ВАШЕМУ ПРОЕКТУ/host-service/worker.log
```
В данном случае `numprocs` - максимальное количество одновременно выполняющихся задач

После добавления всех необходимых конфигураций нам нужно будет выполнить следующие команды, чтобы учесть новые изменения:

```
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start all
```

###Документация к API(OpenAPI etc.) `Api-documentation.yaml` находится в корне проекта.

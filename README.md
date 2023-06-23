# Электронное делопроизводство

Программное обеспечение предназначено для организации электронного делопроизводства.

## Особенности

- Учет входящих и исходящих документов
- Хранение документов и приложений к ним
- Полнотекстовый поиск в документах
- Постановка задач сотрудникам и контроль их выполнения
- Телефонная книга

## Лицензия

Это программное обеспечение распространяется под лицензией GPL-3.0.

## Установка

- Скачайте zip-архив.
- Извлеките содержимое.
- В MySql создайте базу данных
- Создайте файл настроек .env по примеру .env.example.
- Обнуление БД и заполнение таблиц миниммально необходимыми записями выполняется командой: composer start

```bash
composer start
```

- Выполните вход под учетной записью администратора и добавьте учетные записи других сотрудников.
login: admin@admin.ru
pass:  +1234567

- Для изучения работы приложения, БД можно наполнить фэйковыми данными с помощью команды: composer seed

```bash
composer seed
```

- Приведение БД к стартовому состоянию выполняется командой: composer start

```bash
composer start
```

- На локальном сервере обработчик задач (Task Scheduling) запускается командой: php artisan schedule:work. Используется для создания архивов, рассылки списка задач на неделю и проверки наличия очередей и ее обработки.

```bash
php artisan schedule:work
```

- Обработчик очередей (Queues) вызывается ежеминутно обработчиком задач и закрывается при отсутствии заданий в очереди. Обработчик очереди может быть вызван отдельно командой: php artisan squeue:work.

```bash
php artisan queue:work
```

- На хостинге для вызова обработчика задач необходимо настроить cron на ежеминутное выполнение команды: artisan schedule:run. Настройка cron может отличаться у разных поставщиков услуги. Примеры:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
```bash
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```
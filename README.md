# Реализовано тестовое задание от компании «Мэйк»

#### Для корректной работы включите обработчик очередей: php artisan queue:work

1) Реализован GET /api/users — просмотр списка существующих пользователей.
2) Реализован GET /api/posts — просмотр списка всех постов.
3) Реализован GET /api/posts/{id} — просмотр конкретного поста.
4) Реализован POST /api/posts — создание поста.

ПРОСТЫЕ
1) Создал сиды для Users и Posts
2) Добавил сортировку в метод GET /api/posts. Доступные методы для сортировки определяются в Enum Order

ПОСЛОЖНЕЕ

3) Добавил систему оповещений пользователей.

Оповещения отправляются через очередь ТОЛЬКО ПОЛЬЗОВАТЕЛЯМ У КОТОРЫХ ПОДТВЕРЖДЕНА ПОЧТА. При создании нового поста, устанавливается очередь на отправку email писем и запись оповещения об статье для каждого пользователя.

Реализован метод GET /notifications?user_id={id} для просмотра списка оповещений

4) Добавил метод GET /admin/users/ с HTML

Загрузка списка пользователей реализована через последовательность http запросов. Каждый запрос подгружает по несколько пользователей

Регистрация пользователя создаёт новую запись в таблице users и отправляет письмо на почту с ссылкой на подтверждение почты

## Примеры запросов к API части приложения
1) Получить список пользователей: curl -X GET -H "Content-Type: application/json" -H "Accept: application/json" http://localhost:8080/api/users/
2) Получить спислк постов: curl -X GET -H "Content-Type: application/json" -H "Accept: application/json" http://localhost:8080/api/posts/
3) Получить конкрентную статью: curl -X GET -H "Content-Type: application/json" -H "Accept: application/json" http://localhost:8080/api/posts/1
4) Создать новую статью: curl -X POST -H "Content-Type: application/json" -H "Accept: application/json" http://localhost:8080/api/posts/ -d '{"title":"New post","anons":"anons for post","text":"text for post","user_id":"1"}'
5) Получить список оповещений пользователя: curl -X GET -H "Content-Type: application/json" -H "Accept: application/json" http://localhost:8080/api/notifications/ -d '{"user_id":"1"}'

6) GET /api/users/cursor/pagination/ модифицированный метод базового метода GET /api/users/ : curl -X GET -H "Content-Type: application/json" -H "Accept: application/json" http://localhost:8080/api/users/cursor/pagination/
7) Подтверждение почты пользователя: curl -X GET -H "Content-Type: application/json" -H "Accept: application/json" http://localhost:8080/confirm-password/{jobHash}

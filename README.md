# Wisebits test task

## Задание
На основе Yii2 basic application создать мини-проект, в котором необходимо реализовать постраничный вывод контента.
Единица контента - видео. Для каждого видео в списке выводится информация:

- Title (можно рандомно генерить что-то)
- Thumbnail (можно использовать картинку плейсхолдер)
- Duration (в базе - секунды, выводится - время в минутах:секундах для видео меньше часа,
и полный формат если видео длиннее 60 минут)
- Views (количество просмотров, для теста задавать рандомно от 0 до 1 000 000)
- Added datetime (случайно задавать из какого-то диапазона дат)

Список представлен в виде сетки (как на большинстве тубов) а не списка. Пейджер стандартный:
first, prev, 1..2..3..Х (с ограничением), next, last. Количество на странице - настраиваемое.

Также должна присутствовать возможность сортировки данных в обе стороны (ASC \ DESC) по двум параметрам: views, date
(пагинация должна учитывать сортировку). Сортировка по умолчанию: date desc

Визуально можно сделать все на дефолтном бутстрапе. Важно правильно организовать структуру проекта. Должна быть
возможность открыть любой номер страницы по прямой ссылке

## Как развернуть проект
Для разворота локально используется docker и docker-compose,
при разработке использовались следующие версии

- docker: v20.10.12
- docker-compose: v2.2.3

Необходимо поднять окружение с помощью docker-compose, выполнить миграции в базе данных
и сгенерировать тестовый набор данных

```bash
docker compose up -d
docker compose exec php_fpm /app/yii migrate/up
docker compose exec php_fpm /app/yii generate/video 100000
```

После чего проект будет доступен локально по ссылке http://localhost:8080

## Нюансы реализации

### Переменные окружения
Для конфигурации приложения используются переменные окружения, которые можно переопределить в проекте
с помощью `.env` файла. Файл игнорируется гитом, поэтому необходимо создать и отредактировать должным образом
самостоятельно, взять за основу можно файл `.env.dist`

### Контейнеры
Для контейнеров с php и c nginx написаны собственные образы, основанные на официальных. Dockerfile-ы можно найти
в директории `.docker/deps`

Так как приложение не разбито на 2 отдельных проекта под фронт и бэк - то все файлы и фронтенда и бэкенда
находятся по соседству друг с другом, что вызывает некоторые проблемы при использовании отдельного
контейнера под веб сервер и отдачи статических файлов с его помощью.

Для этого в контейнер с `nginx` пробрасывается директория с файлами, которые должны быть доступны с веба,
на всякий случай в read-only режиме. Остальные файлы проекта для веб-сервера недоступны

```yaml
services:
  ...
  
  nginx:
    ...
    
    volumes:
      - ./web:/app/web:ro
```

### Счетчик записей
Для подсчета количества записей в таблице используется запрос типа `SELECT MAX(id) FROM ...`,
так как конкретно в данном случае это справедливо. Но данный ход не подходит, если должны будут
добавиться условия к запросу, или будут удалено какое то количество строк, в таком случае придется
изменять данную реализацию на `SELECT COUNT(*) FROM ...` или что то более хитрое.

### Пагинация
Для пагинации используются запросы вида `ORDER 20 LIMIT 40`, реалзованный с помощью стандартного
компонента фреймворка \yii\data\ActiveDataProvider, на фронте также выводится стандартный для фрэймворка пагинатор.

Рассматривался вариант с реализацией пагинации, основанной на счетчике по уникальному индексу, по типу следующего:

```sql
SELECT * FROM tbl_name WHERE id > 10000 LIMIT 50
SELECT * FROM tbl_name WHERE id > 10050 LIMIT 50
SELECT * FROM tbl_name WHERE id > 10100 LIMIT 50
```

Но в задании указана необходимость сортировки по двум другим (не id) полям,
поэтому данный подход тяжело реализуем в таких условиях. Также с таким подходом сложно было бы реализовать
постраничный пагинатор на стороне фронта, данный подход больше характерен для "ленты", когда записи подгружаются
по мере прокрутки контента или по клику на "Показать еще", без разбивки на страницы.

### Роутинг
Для роутинга страниц пагинатора установлено специальное правило в UrlManager, позволяющее строить и разбирать
адреса страниц по шаблону `/videos/page-{n}`.

Для отрисовки страницы с конкретной записью используется заранее
сгенерированный slug в каждой записи, шаблон урла для страницы конкретной записи: `/video/{slug}`

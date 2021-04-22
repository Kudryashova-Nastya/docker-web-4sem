# Домашка.

**Всем без исключения:**
- результаты домашки записать на видео. (например, с помощью
  https://www.teamviewer.com/ru/info/screen-recording/);
- залить код домашки в новую ветку уже созданного репозитория, добавить
  описание, что проделано вами в hw.

**На "3".**  
Скачать файлы с урока, запустить в докере, продемонстрировать выполнение
запросов на insert, find, update, delete через терминал.

**На "4".**  
Взять за основу схему хранения данных из предыдущей домашки. Заполнить
базу данных по вашей схеме (продемонстрировать запросы). Выполнить
запросы find, update, delete с различными опциями и пояснить, что за
опции были использованы.

**На "5".**  
То же, что и в 4.
Добавить запросы с агрегацией из нескольких коллекций. Разобраться с
оператором $explain, продемонстрировать его работу на примере вашего
запроса и прокомментировать.

# Что может помочь для выполнения домашки.

### Образы:

- [официальный сайт](https://hub.docker.com/_/mongodb): там же можно
  найти команды, которые запускали на уроке

### Теория и документация.

**Документация по монге**
- [официальная документация](https://docs.mongodb.com/): всё, что вам
  нужно есть здесь, с кучей примеров, для всего остального есть гугл;
- [14 вещей, которые я хотел бы знать перед началом работы с MongoDB](https://habr.com/ru/company/otus/blog/520412/):
  просто интересная статья для общего развития.

# Команды консоли.

**Референс команд докера**:  
[Официальная документация](https://docs.docker.com/engine/reference/commandline/docker/)

Войти в запущенный инстанс

```
docker exec -it [container_name] sh
# или
docker exec -it [container_name] bash
```

Выполнить в запущенном инстансе команду

```
docker exec [container_name] [command]
```

Посмотреть логи контейнера

```
docker logs -f [container_name]
```

Создать сеть

```
docker network create [network_name]  
```

Прочее

```
# cat somefile.txt - вывести содержимое файла
cat 
# содержимое текущей директории
ls -lah
# запущенные процессы
top
# cat somefile.txt | grep 'some string in file' - найти строку в теле файла с помощью grep
```


```
db.users.dropIndex({"email": 1});
db.users.createIndex({"email": 1}, {"name": "email_unique", "unique": true});
db.users.getIndexes();

db.users.find({email: null});
db.users.find({email: {$exists: true, $eq: null}});
db.users.find({email: {$exists: false, $eq: null}});

db.users.deleteMany({email: {$exists: false, $eq: null}});
db.users.find();

db.users.updateOne({_id: ObjectId('60685568409e16c5b659d2e6')}, {
    $set: {
        phone: [
            {"phone":78889992233, "primary":true, "contactName": "Misha"},
            {"phone":78889992244, "primary":false, "contactName": "Glasha"},
        ]
    }
})

db.contacts.insertMany([
    {"phone": "111111", "email": "111111@vvv.ru", "userId": ObjectId("1111533d409e16c5b659d2e3")},
    {"phone": "222222", "email": "222222@vvv.ru", "userId": ObjectId("2222553d6c6d580d29dbfc3a")}
]
    );


original_id = ObjectId()
db.places.insertOne({
    "_id": original_id,
    "name": "Broadway Center",
    "url": "bc.example.net"
})
db.people.insertOne({
    "name": "Erin",
    "places_id": original_id,
    "url": "bc.example.net/Erin"
})


db.contacts.aggregate(
    [
        {
            $lookup:
                {
                    from: "users",
                    localField: "userId",
                    foreignField: "_id",
                    as: "user"
                },
        },
        {$project: {"_id": 1, "user.name": 1, "email": 1}}
    ]
)
```

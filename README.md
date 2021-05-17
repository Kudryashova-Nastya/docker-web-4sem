**На "5".**  
Провела реверс инжиниринг модели хранения данных для карточки машины на сайте youla.ru. 
Изучила страницу (https://auto.youla.ru/advert/used/bmw/x5/prv--35793d7623d7bb52/), сформировала схему хранения данных представленной на странице информации.  
Составила запросы CREATE TABLE (в файле hw3.sql).   
Создала 4 таблицы, заполнила их данными. 
Составила запрос, который позволит выбрать данные из схемы для отображения информации исследованной страницы.  
Вот он:
-- запрос на вывод данных со страницы юлы
SELECT `brand`, carmodel.`name`, `gearbox`, `body`, `seats`, `drive`, `engine`, `doors`, `rudder`,
`price`, `year`, `casco`, `mileage`, `color`,
`location`, `image_type`, `image_url`, `image_name`
FROM car INNER JOIN carmodel ON car.car_model_id = carmodel.id 
INNER JOIN user ON car.owner_id = user.id 
INNER JOIN image ON car.id = image.car_id 
WHERE car.id=1;


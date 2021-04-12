
CREATE TABLE `car` (
  `id` int(128) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `price` smallint(5) UNSIGNED NOT NULL,
  `year` smallint(5) UNSIGNED NOT NULL,
  `casco` tinyint(1) NOT NULL,
  `mileage` int(10) UNSIGNED NOT NULL,
  `color` varchar(20) NOT NULL,
  `car_model_id` int(32) NOT NULL,
  `owner_id` int(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `carmodel` (
  `id` int(32) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `brand` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gearbox` varchar(15) NOT NULL,
  `body` varchar(15) NOT NULL,
  `seats` smallint(5) UNSIGNED NOT NULL,
  `drive` varchar(10) NOT NULL,
  `engine` varchar(10) NOT NULL,
  `doors` smallint(5) UNSIGNED NOT NULL,
  `rudder` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `car_id` int(128) NOT NULL,
  `image_type` varchar(25) NOT NULL default 'jpg',
  `image` blob NOT NULL,
  `image_size` varchar(25) NOT NULL,
  `image_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `user` (
  `id` int(128) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(100) NOT NULL,
  `location` varchar(200) NOT NULL,
  `phone` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `car`
  ADD KEY `model_id` (`car_model_id`) USING BTREE,
  ADD KEY `owner_id` (`owner_id`) USING BTREE;

ALTER TABLE `carmodel`
  ADD KEY `brand_name` (`brand`, `name`) USING BTREE,
  ADD KEY `brand` (`brand`) USING BTREE,
  ADD KEY `name` (`name`) USING BTREE;

ALTER TABLE `car`
  ADD CONSTRAINT `Car_model_id` FOREIGN KEY (`car_model_id`) REFERENCES `carmodel` (`id`),
  ADD CONSTRAINT `Owner_id` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`);
  
ALTER TABLE `image`
  ADD CONSTRAINT `Car_id` FOREIGN KEY (`car_id`) REFERENCES `car` (`id`);


INSERT INTO `carmodel` (`id`, `brand`, `name`, `gearbox`, `body`, `seats`, `drive`, `engine`, `doors`, `rudder`) VALUES
(1, 'Kia', 'kia rio', 'Механическая', 'универсал', 5, 'Передний', 'бензин', 4, 'слева');
INSERT INTO `carmodel` (`brand`, `name`, `gearbox`, `body`, `seats`, `drive`, `engine`, `doors`, `rudder`) VALUES
('Volkswagen', 'Volkswagen Tiguan 5 поколение', 'Механическая', 'универсал', 5, 'Передний', 'бензин', 4, 'слева');

INSERT INTO `user` (`name`, `location`, `phone`) VALUES
('Дмитрий Н.', 'Подольск', '+7(916)624-98-74');
INSERT INTO `user` (`name`, `location`, `phone`) VALUES
('Татьяна Д.', 'г. Москва, ул. Победы д.50', '+7(916)114-98-94');

INSERT INTO `car` (`id`, `price`, `year`, `casco`, `mileage`, `color`, `car_model_id`, `owner_id`) VALUES
(1, 1380000, 2015, 0, 50000, 'чёрный', 1, 1);
INSERT INTO `car` (`price`, `year`, `casco`, `mileage`, `color`, `car_model_id`, `owner_id`) VALUES
(1330000, 2012, 0, 70000, 'чёрный', 1, 1);


explain SELECT * FROM car, carmodel,  user  WHERE brand='Kia' and carmodel.name='kia rio' and user.id=1 and color='чёрный' and year=2015;
-- более оптимизированный запрос
explain SELECT * FROM car, carmodel IGNORE INDEX (brand),  user  WHERE brand='Kia' and carmodel.name='kia rio' and user.id=1 and color='чёрный' and year=2015;

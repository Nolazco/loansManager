create database if not exists prestamos;

use prestamos;

create table if not exists objetos(
	id int auto_increment primary key,
	name varchar(60) not null,
	location varchar(30) not null,
	notes varchar(60) default null,
	photo varchar(100) not null
)engine=innodb;

CREATE TABLE if not exists subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    endpoint TEXT NOT NULL,
    p256dh VARCHAR(255) NOT NULL,
    auth VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

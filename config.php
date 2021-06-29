<?php
const USER = 'megauser';
const PASSU = '1PassworD_2';
const HOST = 'localhost';
const DBNAME = 'auct';
/*
 *
 *  ->>>>>> For install <<<<<<-
 create table lots
    (
    id int not null auto_increment,
    title varchar(255) not null,
    user_id int not null,
    last_id int,
    price int not null,
    step int not null,
    deadline datetime not null,
    primary key (id)
    );

create table users
(
    id int not null auto_increment,
    login varchar(255) unique,
    role varchar(10) not null,
    passw varchar(255) not null,
    email varchar(255) unique,
    primary key (id)
);
 * */

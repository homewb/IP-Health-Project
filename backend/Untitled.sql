create database iphealth;
use iphealth;
create table users(
	id int not null unique auto_increment primary key,
    email varchar(50) not null default '',
    password varchar(200) not null default '',
    position varchar(10) not null default 'E',
    photo varchar(200) not null default ''
)engine innodb charset utf8;

create table userInfo(
	infoId int not null auto_increment primary key unique,
	firstname varchar(50) default '',
    lastname varchar(50) default '',
    birthday date,
    address varchar(150) default '',
    phone1 int(20) default 0,
    phone2 int(20) default 0,
    userId int not null,
    foreign key(userId) references users(id) on delete cascade
)engine innodb charset utf8;

delimiter $
create trigger createUser 
after insert on users
for each row
begin
insert into userInfo (userId) values (new.id);
end
$ 

use iphealth;
#insert into users (email,password,position) values ('aaa','aaa','A');
#drop database iphealth
#select * from users
insert into users(email,password,position) values ('gzcisco720@gmail.com',md5('gongzheng'),'A');
update userInfo set firstname='zheng',lastname='gong',birthday='1988-07-20',address='rmit',phone1='000',phone2='000' where infoId =1;
#select * from users
#select firstname from userInfo where userId in (select id from users where email = 'gzcisco720@gmail.com')

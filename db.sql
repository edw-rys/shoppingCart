DROP DATABASE IF EXISTS pasteleria;
create DATABASE pasteleria;
use pasteleria;
-- Table - Continent
create table continent(
	id_continent int auto_increment,
	name_ct varchar(25) not null,
	PRIMARY KEY (id_continent)
)ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
insert into continent values(1,"AMÉRICA"),(2,"ASIA"),(3,"EUROPA"),(4,"ANTÁRTIDA"),(5,"ÁFRICA"),(6,"OCEANÍA");

-- tabla de paises
create table country(
	id_country int auto_increment,
	name_cy varchar(25) not null,
	id_continent int not null,
	PRIMARY KEY (id_country),
	FOREIGN KEY (id_continent) REFERENCES continent(id_continent)
)ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
insert into country(name_cy, id_continent)
	values 
	("CHINA",2),("Afganistan ",2),("ECUADOR",1),("COLOMBIA",1),("USA",1),("MEXICO",1),("ARGENTINA",1),("BRASIL",1),("CHILE",1),("ALEMANIA",3),("ESPAÑA",3),
	("PORTUGAL",3),("AUSTRIA",3),("DIANMARCA",3),("HOLANDA",3),("IRALANDA",3),("AUSTRIA",6),("FIYI",6),
	("ANGOLIA",5),("ARGELIA",5),("BENÍN",5),("B",4),("C",4);

-- tabla de genero
create table gender(
	id_gender int auto_increment,
	name_gender varchar(25) not null,
	PRIMARY KEY (id_gender)
)ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
insert into gender values(1,"masculino"),(2,"femenino");
-- tabla tipo de usuario
CREATE TABLE type_user(
    id_typeuser int auto_increment,
	name varchar(25) not null,
	PRIMARY KEY (id_typeuser)
);
insert into type_user values(101,"admin"),(200,"client");

-- tabla de usuarios
create table user(
	id_user int auto_increment,
	username varchar(25) not null,
	password varchar(100) not null,
	name_user varchar(25) not null,
	last_name varchar(25) not null,
	birthdate date not null,
	mail varchar(100) not null,
	id_gender int not null,
	id_country int not null,
    id_typeuser int not null DEFAULT 200,
	PRIMARY KEY (id_user),
	FOREIGN KEY (id_gender) REFERENCES gender(id_gender),
	FOREIGN KEY (id_country) REFERENCES country(id_country),
	FOREIGN KEY (id_typeuser) REFERENCES type_user(id_typeuser)
)ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

insert into user(username,password,name_user, last_name,birthdate, mail,id_gender,id_country ,id_typeuser)
	values
	("admin","TkNOcEc3UlVrQnQ4YTNQVzJ0YjllQT09","Administrador","R", "1998-1-1","adming@gmail.com",1,3,101),
	("user2", "RHZVb0NLUjgyTWp2bmJPYUc4UCtUZz09","Rbt","I","1990-1-1","us1@hotmail.com",1,5, 200),
	("user3","RHZVb0NLUjgyTWp2bmJPYUc4UCtUZz09","Shs","S","1997-1-1","us2@gmail.com",2,3, 200),
	("user4","RHZVb0NLUjgyTWp2bmJPYUc4UCtUZz09","Mss","P","1997-1-1","uss@gmail.com",2,3, 200);

-- ctg productos
create table category_p(
	id_ctg int auto_increment,
	name_ctg varchar(20) not null,
	PRIMARY KEY (id_ctg)
)ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

insert into category_p
	values(1,"cupcakes"),(2,"totas"),(3,"pan"),(4,"tartas");
-- producto
create table product(
	id_prod int auto_increment,
	name_prod varchar(30) not null,
	description varchar(80),
	url_img varchar(200) not null,
	quantity int not null,
	price decimal(10,2) not null,
	discount int DEFAULT 0,
	id_ctg_p int not null,
	PRIMARY KEY (id_prod),
	FOREIGN KEY (id_ctg_p) REFERENCES category_p(id_ctg)
)ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

insert into product values
	(1,"pastel de chocolate","pastel 1","assets/img/picture/img1.jpg",50,20.2,0,2),
	(2,"pastel de frutilla","pastel 1","assets/img/picture/img2.jpg",5,15.2,20,2),
	(3,"cupcake 1","cupcake","assets/img/picture/img3.jpg",100,1.25,0,1),
	(4,"cupcake 2","cupcake","assets/img/picture/img4.jpg",80,1.50,0,1),
	(5,"pan de sal","panes","assets/img/picture/img5.jpg",100,0.5,0,3),
	(6,"brownie","brownie","assets/img/picture/img6.jpg",120,1.50,0,1),
	(7,"tarta de manzana","tarta 1","assets/img/picture/img7.jpg",10,14.2,10,4),
	(8,"tarta de piña","tarta 2","assets/img/picture/img8.jpg",20,12.2,40,4);

-- tabla de ventas
create table sales(
	id_sale int auto_increment,
	id_user int not null,
	id_product int not null,
	price int not null,
	date_sale date not null,
	PRIMARY KEY (id_sale),
	FOREIGN KEY (id_user) REFERENCES user(id_user),
	FOREIGN KEY (id_product) REFERENCES product(id_prod)
)ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

insert into sales values(1,1,1,20.2,now());
-- tabla de deseos
create table i_like(
	id_like int auto_increment,
	id_user int not null,
	id_product int not null,
	PRIMARY KEY (id_like),
	FOREIGN KEY (id_user) REFERENCES user(id_user),
	FOREIGN KEY (id_product) REFERENCES product(id_prod)
)ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

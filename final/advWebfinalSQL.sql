create user advfinaluser identified by 'password';
create  database if not exists advfinal;
use advfinal;
create table items(	itemid int(10) not null auto_increment,
					itemtitle varchar(100) not null,
                    itemdesc varchar(500) not null,
                    itemimage varchar(500) not null default'',
                    primary key(itemid));
create table users(	custid int(10) not null auto_increment,
					custemail varchar(50) not null,
                    primary key(custid));
create table bought(boughtid int(10) not null auto_increment,
					custid int(10) not null,
                    itemid int(10) not null,
                    boughtdate timestamp not null default current_timestamp,
                    primary key(boughtid),
                    foreign key(custid) references users(custid),
                    foreign key(itemid) references items(itemid));
create table comments(	commentid int(10) not null auto_increment,
						commentText varchar(500) not null,
						email varchar(100) not null,
                        timecomment timestamp default current_timestamp,
                        primary key(commentid));
                        
                    
                    
                    
grant select on items to advfinaluser;
grant select on users to advfinaluser;
grant select on bought to advfinaluser;
grant select on comments to advfinaluser;
grant insert on items to advfinaluser;
grant insert on users to advfinaluser;
grant insert on bought to advfinaluser;
grant insert on comments to advfinaluser;


insert into items (itemtitle, itemimage, itemdesc) values ('An Investigation of the Laws of Thought', 'http://georgecolgrove.no-ip.org/final/photos/book.jpg', 'The Laws of Thought, more precisely, An Investigation of the Laws of Thought on Which are Founded the Mathematical Theories of Logic and Probabilities, was an influential 19th century book by George Boole, the second of his two monographs on algebraic logic. It was published in 1854. Boole was Professor of Mathematics of then Queen\'s College, Cork in Ireland.');
                    
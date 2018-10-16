/*
Part of Zajedno.
Written by Tiger Sachse.
*/

USE main_database;
CONNECT main_database;

INSERT INTO universities (name, address, description) VALUES ('University of Graham', '9615 Graham Way, New Matthew, MT 45834', 'Nesciunt quia dolore explicabo in. Dolore animi deleniti dolorum.');
INSERT INTO universities (name, address, description) VALUES ('Michael State College', '36779 Michael Way, New Ian, SD 79492', 'Qui sequi nemo quis placeat. Ad hic officiis id vel nostrum.');
INSERT INTO universities (name, address, description) VALUES ('Ford State College', '6162 Ford Street, Dunnland, MD 58896', 'Optio dolor tempore assumenda ab. Sint exercitationem totam assumenda illum. Exercitationem distinctio fuga ullam impedit quod vero. Ea nobis ipsam delectus rem animi voluptatibus.');
INSERT INTO universities (name, address, description) VALUES ('Oconnor Community College', '761 Oconnor Way, Ericaburgh, HI 13443', 'Sapiente ut vero. Neque nesciunt minima quis ut fugit corporis. Voluptatem eaque quis architecto laborum quibusdam nisi ex.');
INSERT INTO universities (name, address, description) VALUES ('Lyons State College', '857 Lyons Court, Schultzport, NE 79939', 'Soluta perspiciatis velit magnam quidem. Sapiente repudiandae similique quis accusantium minus quas. Quidem odio vel vel impedit id. Debitis voluptates dolorem officiis at.');
INSERT INTO universities (name, address, description) VALUES ('Martin State University', '54873 Martin Boulevard, Stanleyview, NV 05374', 'Libero velit fugiat dolores velit possimus. Vitae iusto voluptatum vel accusantium et.');
INSERT INTO universities (name, address, description) VALUES ('Frederick State University', '786 Frederick Road, Lake Duane, TN 93576', 'Totam ea ut exercitationem ipsam blanditiis. Iusto officiis eligendi ut adipisci mollitia occaecati dicta.');
INSERT INTO universities (name, address, description) VALUES ('Gray Community College', '955 Gray Road, West Andreabury, MO 19524', 'Suscipit fugit cum fugit odit. Aut excepturi facere asperiores sit impedit aliquam.');
INSERT INTO universities (name, address, description) VALUES ('Hicks State College', '0915 Hicks Boulevard, Lake Ericview, NH 89151', 'Illum voluptate nihil minima laboriosam praesentium ab similique. Voluptates aspernatur eum asperiores repellat. Quasi commodi nemo aliquam.');
INSERT INTO universities (name, address, description) VALUES ('Peterson Community College', '3771 Peterson Court, North Kaitlynburgh, RI 18856', 'Earum quod magni doloribus dolorem iste dignissimos ipsum. Temporibus odio quibusdam iste. Soluta repudiandae laboriosam consequuntur eaque. Similique impedit recusandae tempore quisquam porro sed.');
INSERT INTO users (first_name, last_name, password, email, university_id, permission_level) VALUES ('Leslie', 'Sampson', 'he1xFy?dzmkz7e', 'Leslie.Sampson46@yahoo.co.uk', 7, 'superadmin');
INSERT INTO users (first_name, last_name, password, email, university_id, permission_level) VALUES ('Sean', 'Edwards', 'von7v7v!nubGirdnh', 'Sean.Edwards17@gmail.com', 3, 'admin');
INSERT INTO users (first_name, last_name, password, email, university_id, permission_level) VALUES ('Richard', 'Terry', 'gTbjh!kp4igzui9', 'Richard.Terry36@yahoo.com', 3, 'admin');
INSERT INTO users (first_name, last_name, password, email, university_id, permission_level) VALUES ('Christopher', 'Stevenson', '7soos!ucyipdvDo8d', 'Christopher.Stevenson00@yahoo.co.uk', 9, 'admin');
INSERT INTO users (first_name, last_name, password, email, university_id, permission_level) VALUES ('Sylvia', 'Robbins', '2bmr?q0Tqznxziak', 'Sylvia.Robbins43@gmail.com', 6, 'admin');
INSERT INTO users (first_name, last_name, password, email, university_id, permission_level) VALUES ('Sean', 'Rodriguez', 'zC0fr?c3hjzuz', 'Sean.Rodriguez32@outlook.com', 7, 'admin');
INSERT INTO users (first_name, last_name, password, email, university_id, permission_level) VALUES ('Amanda', 'Delgado', 'vcv2gzVnpkqgi.m6iv', 'Amanda.Delgado81@outlook.com', 8, 'superadmin');
INSERT INTO users (first_name, last_name, password, email, university_id, permission_level) VALUES ('Johnny', 'Collins', '?Xpe8ku8xvqpp', 'Johnny.Collins73@outlook.com', 9, 'admin');
INSERT INTO users (first_name, last_name, password, email, university_id, permission_level) VALUES ('Kevin', 'Williams', 'nwrno7ysv.i9ffpvmVc', 'Kevin.Williams84@aol.com', 8, 'admin');
INSERT INTO users (first_name, last_name, password, email, university_id, permission_level) VALUES ('Brett', 'Robinson', '9juGlb3hwvykzgv?', 'Brett.Robinson73@yahoo.com', 2, 'admin');

QUIT
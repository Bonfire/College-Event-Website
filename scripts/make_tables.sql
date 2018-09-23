/*
Part of Zajedno.
Written by Tiger Sachse.
*/

CONNECT 'jdbc:derby:main_table;create=true';
CREATE TABLE universities (
    name VARCHAR(200),
    address VARCHAR(300),
    description VARCHAR(1000),
    student_count INT,
    picture_id INT
);
CREATE TABLE pictures (
    owner_id INT PRIMARY KEY,
    filename VARCHAR(200)
);
CREATE TABLE events (
    name VARCHAR(200),
    category VARCHAR(100),
    description VARCHAR(1000),
    time INT,
    date INT,
    address VARCHAR(300),
    contact_number INT,
    contact_email VARCHAR(100),
    publicity_level VARCHAR(100),
    organization_name VARCHAR(100),
    PRIMARY KEY (name, address)
);
CREATE TABLE users (
    username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(20)
);
DISCONNECT;
EXIT;

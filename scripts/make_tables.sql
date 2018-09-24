/*
Part of Zajedno.
Written by Tiger Sachse.
*/

CONNECT 'jdbc:derby:main_table;create=true';

CREATE TABLE users (
    username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(20),
    permissions INT
);
CREATE TABLE universities (
    name VARCHAR(200) PRIMARY KEY,
    address VARCHAR(300),
    description VARCHAR(1000),
    student_count INT,
    picture_owner_id INT
);
CREATE TABLE organizations (
    name VARCHAR(200) PRIMARY KEY,
    owner VARCHAR(50)
);
CREATE TABLE events (
    name VARCHAR(200) NOT NULL,
    description VARCHAR(1000),
    category VARCHAR(100),
    address VARCHAR(300) NOT NULL,
    publicity_level VARCHAR(100),
    organization_name VARCHAR(100),
    event_time INT,
    event_date INT,
    contact_number INT,
    contact_email VARCHAR(100),
    comment_owner_id INT,
    ratings_count INT,
    ratings_average INT,
    PRIMARY KEY (name, address)
);
CREATE TABLE pictures (
    owner_id INT,
    filename VARCHAR(200)
);
CREATE TABLE comments (
    event_id INT,
    username VARCHAR(50),
    time INT,
    text VARCHAR(300),
    PRIMARY KEY (event_id, time)
);
CREATE TABLE memberships (
    organization VARCHAR(200),
    username VARCHAR(50),
    PRIMARY KEY (username, organization)
);

DISCONNECT;
EXIT;

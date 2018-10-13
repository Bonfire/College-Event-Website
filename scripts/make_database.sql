/*
Part of Zajedno.
Written by Tiger Sachse.
*/

CREATE DATABASE IF NOT EXISTS main_database;
USE main_database;
CONNECT main_database;

CREATE TABLE users (
    id INT IDENTITY,
    username VARCHAR(50),
    password VARCHAR(20),
    email VARCHAR(200),
    university_id INT,
    permission_level VARCHAR(20),
    PRIMARY KEY (id),
    FOREIGN KEY (university_id)
    REFERENCES (universities),
);
CREATE TABLE universities (
    id INT IDENTITY,
    name VARCHAR(200),
    address VARCHAR(300),
    description VARCHAR(1000),
    student_count INT,
    PRIMARY KEY (id),
);
CREATE TABLE organizations (
    id INT IDENTITY,
    name VARCHAR(200),
    owner_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (owner_id)
    REFERENCES (users),
);
CREATE TABLE events (
    id IDENTITY,
    name VARCHAR(200),
    description VARCHAR(1000),
    category VARCHAR(100),
    address VARCHAR(300),
    publicity_level VARCHAR(100),
    organization_id INT,
    event_time INT,
    event_date INT,
    contact_number INT,
    contact_email VARCHAR(100),
    ratings_count INT,
    ratings_average INT,
    PRIMARY KEY (id),
    FOREIGN KEY (organization_id)
    REFERENCES (organizations),
);
CREATE TABLE pictures (
    owner_id INT,
    filename VARCHAR(200),
    FOREIGN KEY (owner_id)
    REFERENCES (events),
);
CREATE TABLE comments (
    event_id INT,
    time INT,
    user_id INT,
    text VARCHAR(300),
    FOREIGN KEY (user_id)
    REFERENCES (users),
    FOREIGN KEY (event_id)
    REFERENCES (events),
);
CREATE TABLE memberships (
    user_id INT,
    organization_id INT,
    PRIMARY KEY (username, organization),
    FOREIGN KEY (user_id)
    REFERENCES (users),
    FOREIGN KEY (organization_id)
    REFERENCES (organizations),
);

QUIT

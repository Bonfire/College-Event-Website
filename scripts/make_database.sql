/*
Part of Zajedno.
Written by Tiger Sachse.
*/

CREATE DATABASE IF NOT EXISTS main_database;
USE main_database;
CONNECT main_database;

CREATE TABLE universities (
    id INT AUTO_INCREMENT,
    name VARCHAR(200),
    address VARCHAR(300),
    description VARCHAR(1000),
    student_count INT,
    PRIMARY KEY (id)
);
CREATE TABLE users (
    id INT AUTO_INCREMENT,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    password VARCHAR(20),
    email VARCHAR(200),
    university_id INT,
    permission_level INT,
    PRIMARY KEY (id),
    FOREIGN KEY (university_id)
    REFERENCES universities(id)
);
CREATE TABLE organizations (
    id INT AUTO_INCREMENT,
    name VARCHAR(200),
    description VARCHAR(1000),
    owner_id INT,
    university_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (owner_id)
    REFERENCES users(id),
    FOREIGN KEY (university_id)
    REFERENCES universities(id)
);
CREATE TABLE events (
    id INT AUTO_INCREMENT,
    name VARCHAR(200),
    description VARCHAR(1000),
    category VARCHAR(100),
    address VARCHAR(300),
    publicity_level INT,
    organization_id INT,
    university_id INT,
    event_time INT,
    event_length INT,
    contact_number VARCHAR(20),
    contact_email VARCHAR(100),
    ratings_count INT,
    ratings_average FLOAT,
    PRIMARY KEY (address, event_time),
    FOREIGN KEY (organization_id)
    REFERENCES organizations(id),
    FOREIGN KEY (university_id)
    REFERENCES universities(id),
    UNIQUE (id)
);
CREATE TABLE pictures (
    owner_id INT,
    filename VARCHAR(200),
    FOREIGN KEY (owner_id)
    REFERENCES events(id)
);
CREATE TABLE comments (
    Id INT AUTO_INCREMENT,
    event_id INT,
    time INT,
    user_id INT,
    comment VARCHAR(300),
    PRIMARY KEY (Id),
    FOREIGN KEY (user_id)
    REFERENCES users(id),
    FOREIGN KEY (event_id)
    REFERENCES events(id)
);
CREATE TABLE memberships (
    user_id INT,
    organization_id INT,
    PRIMARY KEY (user_id, organization_id),
    FOREIGN KEY (user_id)
    REFERENCES users(id),
    FOREIGN KEY (organization_id)
    REFERENCES organizations(id)
);

DELIMITER $
CREATE TRIGGER after_insert_increment_university
AFTER INSERT ON users
FOR EACH ROW
BEGIN
    UPDATE universities
    SET student_count = student_count + 1
    WHERE id = NEW.university_id;
END$
CREATE TRIGGER after_delete_decrement_university
BEFORE DELETE ON users
FOR EACH ROW
BEGIN
    UPDATE universities
    SET student_count = student_count - 1
    WHERE id = OLD.university_id;
END$
CREATE TRIGGER after_update_change_universities
AFTER UPDATE ON users
FOR EACH ROW
BEGIN
    IF OLD.university_id <> NEW.university_id
    THEN
        UPDATE universities
        SET student_count = student_count - 1
        WHERE id = OLD.university_id;
        UPDATE universities
        SET student_count = student_count + 1
        WHERE id = NEW.university_id;
    END IF;
END$
DELIMITER ;

QUIT

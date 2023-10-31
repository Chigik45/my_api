CREATE DATABASE IF NOT EXISTS appDB;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT SELECT, UPDATE, DELETE, INSERT ON appDB.* TO 'user'@'%';
FLUSH PRIVILEGES;

USE appDB;
CREATE TABLE IF NOT EXISTS grants
(
    course_id      INT(11) NOT NULL AUTO_INCREMENT,
    `grant` int(11) NOT NULL,
    PRIMARY KEY (course_id)
);

CREATE TABLE IF NOT EXISTS students
(
    id      INT(11)     NOT NULL AUTO_INCREMENT,
    surname VARCHAR(40) NOT NULL,
    name    VARCHAR(20) NOT NULL,
    course_id  INT(11)     NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT FOREIGN KEY (course_id) REFERENCES grants (course_id)
);

INSERT INTO grants (`grant`)
VALUES (10000);

INSERT INTO grants (`grant`)
VALUES (12500);

INSERT INTO grants (`grant`)
VALUES (15000);

INSERT INTO grants (`grant`)
VALUES (20000);

INSERT INTO students (surname, name, course_id)
VALUES ('Yeen', 'Fillo', 1);

INSERT INTO students (surname, name, course_id)
VALUES ('Tata', 'Rains', 3);

INSERT INTO students (surname, name, course_id)
VALUES ('Himmy', 'Locku', 1);

INSERT INTO students (surname, name, course_id)
VALUES ('Ryte', 'Mahel', 2);
DROP DATABASE IF EXISTS contacts_app;
CREATE DATABASE contacts_app;
USE contacts_app;
CREATE TABLE users(
  id            INT           AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(225),
  email         VARCHAR(225)  UNIQUE  NOT NULL,
  password      VARCHAR(225)
);
INSERT INTO users(name, email, password) VALUES('Yenner', 'fuck@yeah.com', 'peguelomipapa');
CREATE TABLE contacts(
  id            INT       AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(225),
  phone_number  VARCHAR(255)
);
INSERT INTO contacts (name, phone_number) VALUES('Ynner', '321654987');

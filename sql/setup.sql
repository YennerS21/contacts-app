DROP DATABASE IF EXISTS contacts_app;
CREATE DATABASE contacts_app;
USE contacts_app;
CREATE TABLE users(
  id            INT           AUTO_INCREMENT,
  name          VARCHAR(225),
  email         VARCHAR(225)  UNIQUE  NOT NULL,
  password      VARCHAR(225),
  CONSTRAINT pk_users PRIMARY KEY(id)
);
CREATE TABLE contacts(
  id            INT           AUTO_INCREMENT,
  user_id       INT           NOT NULL,
  name          VARCHAR(225), 
  phone_number  VARCHAR(255),
  CONSTRAINT pk_contacts PRIMARY KEY(id),
  CONSTRAINT fk_contact_user FOREIGN KEY(user_id) REFERENCES users(id)
);

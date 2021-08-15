# XML reader

Used core PHP and MVC architecture for both cron link and listing records.
Used singleton pattern for database.
Used Iterator pattern for iterating over files.
Used PostgreSQL database for backend with php user and php database.
All database settings in Config file and folder location to update in the database.

Model = Model folder
View = View folder
Controller = classes folder

Used autoloader file to auto include all classes.

## Cron Working
Iterating over the provided folder location using iterator and reading each XML file to update it in the database.

## Search Working
Get a request for the search hit to the server. Request goes to the Books model and gets a response using a single query.

## Login Credentials:
Username: admin
Password: admin
For login authentication no database is used. It’s saved in the config file.

## Table Schema:

CREATE TABLE authors (
id serial PRIMARY KEY,
author VARCHAR ( 100 ) UNIQUE NOT NULL
);

CREATE TABLE books (
id serial PRIMARY KEY,
auth_id serial NOT NULL,
book VARCHAR ( 100 ) UNIQUE NOT NULL,
    FOREIGN KEY (auth_id)
    REFERENCES authors (id)
);

One to many relationships for Authors and Books tables.

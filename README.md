# benvolio-bookstore

Benvolio Bookstore

This is a project for Database Applications (Summer 2021), Webster University Thailand.
The Benvolio Bookstore database application simulates a bookstore system for managing sales and inventory.
Products are also categorized into series and genres, and author and publisher information is recorded.

-------INSTALLATION--------

1. Go to https://www.uniformserver.com/ to download the Uniform Server.
2. Launch UniController.exe and start Apache and MySQL. Open the MySQL console.
3. Create a database with the command CREATE DATABASE db_name;
4. Switch to this database with the command USE db_name;

5. Download the install.sql script file from this repository.
6. Paste the contents of install.sql into the MySQL console to create/populate all of the tables.
7. Create a user who will use
     create user username identified by "password";
     grant all on db_name.* to username;

8. Create a folder for this application inside the /www folder in Uniform Server.
9. 

To access the application, .

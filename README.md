# benvolio-bookstore

Benvolio Bookstore

This is a project for Database Applications (Summer 2021), Webster University Thailand.
The Benvolio Bookstore database application simulates a bookstore system for managing sales and inventory.
Products are also categorized into series and genres, and author and publisher information is recorded.

-------INSTALLATION--------

1. Find a web host with PHP and MySQL support, or install a web server along with PHP and MySQL.
2. On the MySQL console, create a database with the command: create database db_name;
3. Switch to this database with the command: use db_name;
4. Download the install.sql script file from this repository.
5. Run the contents of install.sql into the MySQL console to create/populate the tables.
6. Create a user who will use/modify this database with the following commands:
     create user username identified by "password";
     grant all on db_name.* to username;
7. Download the index.php file from this repository and place it in a folder in the web directory.
8. In index.php, modify the $username, $password, $dbname parameters to reflect the chosen database name, user, and password for this application.
9. To access the application, navigate to http://localhost/foldername on a browser.

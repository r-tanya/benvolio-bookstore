# benvolio-bookstore

Benvolio Bookstore

This is a project for Database Applications (Summer 2021), Webster University Thailand.
The Benvolio Bookstore database application simulates a bookstore system for managing sales and inventory.
Products are also categorized into series and genres, and author and publisher information is recorded.

-------INSTALLATION--------

1. Go to https://www.uniformserver.com/ to download the Uniform Server.
2. Launch UniController.exe and start Apache and MySQL. Open the MySQL console.
3. Create a database with the command: create database db_name;
4. Switch to this database with the command: use db_name;
5. Download the install.sql script file from this repository.
6. Paste the contents of install.sql into the MySQL console to create/populate all of the tables.
7. Create a user who will use/modify this database with the following commands:
     create user username identified by "password";
     grant all on db_name.* to username;
8. Create a folder for this application inside UniServerZ\www\.
9. Download the index.php file from this repository and save it in this folder.
10. Open index.php. Modify the $username, $password, $dbname parameters to reflect the chosen database name, user, and password for this application.
11. Go to localhost/foldername on a browser to access the application.

To access the application in the future, launch UniController, start Apache and MySQL, and go to localhost/foldername.

*Currently the application displays the ID and title of books sold at Benvolio Bookstore and prompts the user to enter the ID of a book for more information.

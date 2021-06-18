
CREATE TABLE Publishing_House
(
  pub_id INT NOT NULL,
  pub_name VARCHAR(30) NOT NULL,
  year_started INT NOT NULL,
  PRIMARY KEY (pub_id)
);

CREATE TABLE Author
(
  author_id INT NOT NULL,
  author_name VARCHAR(30) NOT NULL,
  author_birth_date DATE NOT NULL,
  author_country CHAR(30) NOT NULL,
  PRIMARY KEY (author_id)
);

CREATE TABLE Genre
(
  genre_name VARCHAR(20) NOT NULL,
  description VARCHAR(200) NOT NULL,
  PRIMARY KEY (genre_name)
);

CREATE TABLE Salesperson
(
  emp_id INT NOT NULL,
  emp_name CHAR(30) NOT NULL,
  salary FLOAT NOT NULL,
  emp_birth_date DATE NOT NULL,
  PRIMARY KEY (emp_id)
);

CREATE TABLE Book
(
  book_id INT NOT NULL,
  ISBN VARCHAR(14) NOT NULL,
  title VARCHAR(150) NOT NULL,
  release_date DATE NOT NULL,
  page_count INT NOT NULL,
  price FLOAT NOT NULL,
  no_in_stock INT NOT NULL,
  pub_id INT NOT NULL,
  PRIMARY KEY (book_id),
  FOREIGN KEY (pub_id) REFERENCES Publishing_House(pub_id)
);

CREATE TABLE Book_In_Series
(
  book_id INT NOT NULL,
  series_name VARCHAR(30) NOT NULL,
  placement INT NOT NULL,
  PRIMARY KEY (series_name, book_id),
  FOREIGN KEY (book_id) REFERENCES Book(book_id)
);

CREATE TABLE Book_Award
(
  book_id INT NOT NULL,
  year INT NOT NULL,
  award_name VARCHAR(100) NOT NULL,
  PRIMARY KEY (award_name, book_id),
  FOREIGN KEY (book_id) REFERENCES Book(book_id)
);

CREATE TABLE Author_Book
(
  author_id INT NOT NULL,
  book_id INT NOT NULL,
  PRIMARY KEY (author_id, book_id),
  FOREIGN KEY (author_id) REFERENCES Author(author_id),
  FOREIGN KEY (book_id) REFERENCES Book(book_id)
);

CREATE TABLE Book_Genre
(
  genre_name VARCHAR(20) NOT NULL,
  book_id INT NOT NULL,
  PRIMARY KEY (genre_name, book_id),
  FOREIGN KEY (genre_name) REFERENCES Genre(genre_name),
  FOREIGN KEY (book_id) REFERENCES Book(book_id)
);

CREATE TABLE Book_Sold
(
  item_sold_id INT NOT NULL,
  date DATE NOT NULL,
  emp_id INT NOT NULL,
  book_id INT NOT NULL,
  PRIMARY KEY (item_sold_id),
  FOREIGN KEY (emp_id) REFERENCES Salesperson(emp_id),
  FOREIGN KEY (book_id) REFERENCES Book(book_id)
);

INSERT INTO publishing_house VALUES (1, "Macmillan", "1843");
INSERT INTO publishing_house VALUES (2, "HarperCollins", "1989");
INSERT INTO author VALUES (1, "Lewis Carroll", "1832-01-27", "United Kingdom");
INSERT INTO author VALUES (2, "C.S. Lewis", "1898-11-22", "United Kingdom");
INSERT INTO genre VALUES ("Children’s", "A genre produced for the entertainment of children and young adults.");
INSERT INTO genre VALUES ("Fantasy", "A genre that typically involves the use of magic or witchcraft or other supernatural elements, often inspired by real world folklore and mythology.");
INSERT INTO salesperson VALUES (1, "Benvolio Benjamin", 15000, "1992-12-12");
INSERT INTO salesperson VALUES (2, "Tybalt Tyler", 15000, "1998-03-29");
INSERT INTO book VALUES (1, "9781447279990", "Alice’s Adventures in Wonderland", "1865-11-26", 146, 210, 50, 1);
INSERT INTO book VALUES (2, "9780064404990", "The Lion, the Witch, and the Wardrobe", "1950-10-16", 208, 270, 60, 2);
INSERT INTO book VALUES (3, "9780064471107", "The Magician’s Nephew", "1955-05-02", 183, 270, 40, 2);
INSERT INTO book_in_series VALUES (2, "The Chronicles of Narnia", 2);
INSERT INTO book_in_series VALUES (3, "The Magician’s Nephew", 1);
INSERT INTO book_award VALUES (1, 1988, "Kurt Maschler Award");
INSERT INTO author_book VALUES (1, 1);
INSERT INTO author_book VALUES (2, 2);
INSERT INTO author_book VALUES (2, 3);
INSERT INTO book_genre VALUES ("Children’s", 1);
INSERT INTO book_genre VALUES ("Children’s", 2);
INSERT INTO book_genre VALUES ("Children’s", 3);
INSERT INTO book_genre VALUES ("Fantasy", 1);
INSERT INTO book_genre VALUES ("Fantasy", 2);
INSERT INTO book_genre VALUES ("Fantasy", 3);
INSERT INTO book_sold VALUES (1, "2021-06-05", 1, 2);
INSERT INTO book_sold VALUES (2, "2021-06-05", 2, 3);

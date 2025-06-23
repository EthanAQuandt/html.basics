CREATE DATABASE IF NOT EXISTS library;
USE library;


CREATE TABLE IF NOT EXISTS books (
  id INT(5) AUTO_INCREMENT PRIMARY KEY,
  titel VARCHAR(100) NOT NULL,
  genre VARCHAR(50) NOT NULL,
  author VARCHAR(50) NOT NULL,
  UNIQUE KEY unik_titel (titel)
);


CREATE TABLE IF NOT EXISTS ratings (
  id INT(5) AUTO_INCREMENT PRIMARY KEY,
  score INT(2) NOT NULL,
  comment TEXT,
  book_id INT(5),
  FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);


INSERT INTO books (titel, genre, author) VALUES
('know no fear', 'action', 'guy haley'),
('horus rising', 'action', 'dan abnet'),
('first heretic', 'action', 'adb');


INSERT INTO ratings (score, comment, book_id) VALUES
(10, 'blue', 1),
(1, 'bald', 2),
(10, 'loken', 2),
(1, 'erebus', 3);

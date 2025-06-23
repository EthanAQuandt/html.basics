CREATE DATABASE IF NOT EXISTS filmclub;
USE filmclub;


CREATE TABLE IF NOT EXISTS film (
  id INT(5) AUTO_INCREMENT PRIMARY KEY,
  titel VARCHAR(100) NOT NULL,
  genre VARCHAR(50) NOT NULL,
  UNIQUE KEY unik_titel (titel)
);


CREATE TABLE IF NOT EXISTS beoordeling (
  id INT(5) AUTO_INCREMENT PRIMARY KEY,
  cijfer INT(2) NOT NULL,
  opmerking TEXT,
  film_id INT(5),
    
);


INSERT INTO film (titel, genre) VALUES
('Inception', 'Sci‑Fi'),
('The Lion King', 'Animation'),
('The Godfather', 'Crime');


INSERT INTO beoordeling (cijfer, opmerking, film_id) VALUES
(9, 'Amazing visuals', 1),
(8, 'Intriguing story', 1),
(7, 'Great for all ages', 2),
(10, 'Classic film', 3);

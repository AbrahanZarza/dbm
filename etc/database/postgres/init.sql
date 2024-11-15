DROP DATABASE IF EXISTS test;
CREATE DATABASE test WITH ENCODING 'UTF8';

\c test;

DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS products;
CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    category_id INT NOT NULL,
    CONSTRAINT fk_product_categories FOREIGN KEY (category_id) REFERENCES categories (id)
);

INSERT INTO categories (id, name) VALUES
(1, 'Food'),
(2, 'Home'),
(3, 'Garden');

INSERT INTO products (id, name, description, category_id) VALUES
(1, 'Pizza', 'A pizza with BBQ sauce.', 1),
(2, 'Rice', 'One kg of rice.', 1),
(3, 'Chart', 'A chart with a boat in the sea.', 2),
(4, 'Mower', 'A mower with steel blades.', 3);
USE products;


CREATE TABLE all_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    price VARCHAR(10000) NOT NULL
);

INSERT INTO all_products (image, name, price) VALUES 
("images/gold-watch.jpg", 'Gold Watch', '1, 999'),
("images/romans-watch.jpg", 'Wrist watch - Roman Numbers', '999'),
("images/round-silver-watch", 'Silver watch (Round)', '1, 099'),
('images/wrist-watch.jpg', 'Wrist Watch', '789'),
('images/watch-1.jpg', 'Watch One', '599'),
('images/watch-2.jpg', 'Watch Two', '1, 200'),
('images/watch-3.jpg', 'Watch Three', '899'),
('images/watch-4.jpg', 'Watch Four', '2, 199'),
('images/watch-5.jpg', 'Watch Five', '689')

CREATE DATABASE blog_app;

USE blog_app;


-- user table 

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);


INSERT INTO users (name, email, password) VALUES
('User 1', 'user1@gmail.com', '123456'),
('User 2', 'user2@gmail.com', '123456'),
('User 3', 'user3@gmail.com', '123456'),
('User 4', 'user4@gmail.com', '123456'),
('User 5', 'user5@gmail.com', '123456'),
('User 6', 'user6@gmail.com', '123456'),
('User 7', 'user7@gmail.com', '123456'),
('User 8', 'user8@gmail.com', '123456'),
('User 9', 'user9@gmail.com', '123456'),
('User 10', 'user10@gmail.com', '123456');




-- post table


CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO posts (user_id, title, content) VALUES
(1, 'Post Title 1', 'This is content for post 1'),
(2, 'Post Title 2', 'This is content for post 2'),
(3, 'Post Title 3', 'This is content for post 3'),
(4, 'Post Title 4', 'This is content for post 4'),
(5, 'Post Title 5', 'This is content for post 5'),
(6, 'Post Title 6', 'This is content for post 6'),
(7, 'Post Title 7', 'This is content for post 7'),
(8, 'Post Title 8', 'This is content for post 8'),
(9, 'Post Title 9', 'This is content for post 9'),
(10, 'Post Title 10', 'This is content for post 10');


-- commment table 


CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO comments (post_id, user_id, comment) VALUES
(1, 2, 'Nice post!'),
(2, 3, 'Very helpful'),
(3, 4, 'Good explanation'),
(4, 5, 'Awesome content'),
(5, 6, 'Loved it'),
(6, 7, 'Very clear'),
(7, 8, 'Good post'),
(8, 9, 'Thanks for sharing'),
(9, 10, 'Great work'),
(10, 1, 'Well written');







-- retrieve a list of all blog posts along with the total number of comments associated with each post.


SELECT
    p.id,
    p.title,
    p.created_at,
    COUNT(c.id) AS comments_count
FROM
    posts p
LEFT JOIN
    comments c ON p.id = c.post_id
GROUP BY
    p.id, p.title, p.created_at  
ORDER BY
    p.created_at DESC;
    
    
    
    
   --  to identify and rank the top three most active users based on the number of blog posts they have created
    
    SELECT
    u.id,
    u.name,
    COUNT(p.id) AS posts_count
FROM
    users u
JOIN
    posts p ON u.id = p.user_id
GROUP BY
    u.id, u.name
ORDER BY
    posts_count DESC
LIMIT 3;




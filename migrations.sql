CREATE DATABASE minigames;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE games (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);


INSERT INTO games (name) VALUES
('Memory Card Match'),
('Typing Speed');


CREATE TABLE difficulties (
    id SERIAL PRIMARY KEY,
    game_id INT REFERENCES games(id) ON DELETE CASCADE,
    name VARCHAR(20) NOT NULL,
    description TEXT
);


-- Memory Game
INSERT INTO difficulties (game_id, name, description) VALUES
(1, 'Easy', '2x2 grid'),
(1, 'Medium', '3x4 grid'),
(1, 'Hard', '4x5 grid');

-- Typing Speed
INSERT INTO difficulties (game_id, name, description) VALUES
(2, 'Easy', '≈50 words'),
(2, 'Medium', '≈100 words'),
(2, 'Hard', '≈150 words'),
(2, 'HardCore', '≈300 words');



CREATE TABLE memory_scores (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    difficulty_id INT REFERENCES difficulties(id) ON DELETE CASCADE,
    time_seconds INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE typing_texts (
    id SERIAL PRIMARY KEY,
    difficulty_id INT REFERENCES difficulties(id) ON DELETE CASCADE,
    content TEXT NOT NULL
);



CREATE TABLE typing_scores (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id) ON DELETE CASCADE,
    difficulty_id INT REFERENCES difficulties(id) ON DELETE CASCADE,
    time_seconds INT NOT NULL,
    words_per_minute INT NOT NULL,
    accuracy DECIMAL(5,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



SELECT u.nickname, ts.words_per_minute, ts.time_seconds
FROM typing_scores ts
JOIN users u ON ts.user_id = u.id
JOIN difficulties d ON ts.difficulty_id = d.id
WHERE d.name = 'Easy'
ORDER BY ts.words_per_minute DESC
LIMIT 10;




SELECT u.nickname, ms.time_seconds
FROM memory_scores ms
JOIN users u ON ms.user_id = u.id
JOIN difficulties d ON ms.difficulty_id = d.id
WHERE d.name = 'Hard'
ORDER BY ms.time_seconds ASC
LIMIT 10;



/*

INSERT INTO users (nickname) VALUES ('Sandis');

INSERT INTO typing_scores (user_id, difficulty_id, time_seconds, words_per_minute)
VALUES (1, 4, 15, 200);

*/

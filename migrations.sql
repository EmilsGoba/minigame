-- 1️⃣ CREATE DATABASE
CREATE DATABASE minigames CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE minigames;

-- 2️⃣ USERS
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3️⃣ GAMES
CREATE TABLE games (
    game_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

INSERT INTO games (name) VALUES
('Memory Card Match'),
('Typing Speed');

-- 4️⃣ DIFFICULTIES (WITH GAME LOGIC SETTINGS)
CREATE TABLE difficulties (
    difficulty_id INT AUTO_INCREMENT PRIMARY KEY,
    game_id INT NOT NULL,
    name VARCHAR(20) NOT NULL,

    -- Memory Card Match settings
    grid_rows INT DEFAULT NULL,
    grid_cols INT DEFAULT NULL,

    -- Typing Speed settings
    word_count INT DEFAULT NULL,

    FOREIGN KEY (game_id) REFERENCES games(game_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Memory Card Match difficulties
INSERT INTO difficulties (game_id, name, grid_rows, grid_cols) VALUES
(1, 'Easy', 2, 2),
(1, 'Medium', 3, 4),
(1, 'Hard', 4, 5);

-- Typing Speed difficulties
INSERT INTO difficulties (game_id, name, word_count) VALUES
(2, 'Easy', 50),
(2, 'Medium', 100),
(2, 'Hard', 150),
(2, 'HardCore', 300);

-- 5️⃣ MEMORY SCORES (TIME BASED)
CREATE TABLE memory_scores (
    score_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    difficulty_id INT NOT NULL,
    time_seconds INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (difficulty_id) REFERENCES difficulties(difficulty_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6️⃣ TYPING SCORES (WPM + TIME + ACCURACY)
CREATE TABLE typing_scores (
    score_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    difficulty_id INT NOT NULL,
    time_seconds INT NOT NULL,
    words_per_minute INT NOT NULL,
    accuracy DECIMAL(5,2),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (difficulty_id) REFERENCES difficulties(difficulty_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 7️⃣ TYPING TEXTS (OPTIONAL, FOR RANDOM TEXT DISPLAY)
CREATE TABLE typing_texts (
    text_id INT AUTO_INCREMENT PRIMARY KEY,
    difficulty_id INT NOT NULL,
    content TEXT NOT NULL,
    FOREIGN KEY (difficulty_id) REFERENCES difficulties(difficulty_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 8️⃣ LEADERBOARD EXAMPLES

-- Memory Game – top 10 fastest times
SELECT
    u.username,
    d.name AS difficulty,
    ms.time_seconds
FROM memory_scores ms
JOIN users u ON ms.user_id = u.user_id
JOIN difficulties d ON ms.difficulty_id = d.difficulty_id
WHERE d.game_id = 1
ORDER BY ms.time_seconds ASC
LIMIT 10;

-- Typing Speed – top 10 words per minute
SELECT
    u.username,
    d.name AS difficulty,
    ts.words_per_minute,
    ts.time_seconds
FROM typing_scores ts
JOIN users u ON ts.user_id = u.user_id
JOIN difficulties d ON ts.difficulty_id = d.difficulty_id
WHERE d.game_id = 2
ORDER BY ts.words_per_minute DESC
LIMIT 10;

<?php require "views/components/header.php"; ?>

<style>
    .navbar {
        display: flex;
        gap: 20px;
        background-color: #333;
        padding: 10px;
        list-style: none;
    }

    .navbar li {
        display: inline;
    }

    .navbar a {
        color: white;
        text-decoration: none;
        padding: 8px 12px;
        border-radius: 4px;
    }

    .navbar a:hover {
        background-color: #555;
    }

    body {
        body: 0;
    }
</style>

<header>
    <nav class="navbar">
        <li><a href="/" class="home">Home</a></li>
        <li><a href="/grades" class="home">Grades</a></li>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'teacher'): ?>
            <li><a href="/create" class="Par-mums">Izveidot</a></li>
        <?php endif; ?>
        <li><a href="/logout" class="home">Logout</a></li>
        <li><a href="/students">Students</a></li>
    </nav>
</header>

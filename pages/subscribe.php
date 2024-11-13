<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Подписки на пользователей</title>
<link rel="stylesheet" href="styles.css">
</head>

<body>

<header>
<h1>Подписки на пользователей</h1>
<nav>
<a href='index.php'>Главная</a>
<a href='view_posts.php'>Просмотр постов</a>
<a href='logout.php'>Выход</a>
</nav>
</header>

<main>

<form method="post">
<label for="subscribe_to">Введите имя пользователя для подписки:</label><br />
<input type="text" id="subscribe_to" name="subscribe_to" required /><br />
<input type="submit" value="Подписаться"/>
</form>

<?php
session_start();
require 'functions.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
$subscribeToUsername = $_POST["subscribe_to"];

// Получаем ID пользователя по имени пользователя
$stmt =  $pdo -> prepare ("SELECT * FROM users WHERE username=?");
$stmt -> execute ([ $subscribeToUsername ]);
$subscribeToUser = $stmt -> fetch();

if ($subscribeToUser) {
$success = subscribeToUser($_SESSION["user_id"], $subscribeToUser["id"]);
if ($success) {
echo "Вы успешно подписались на пользователя " . htmlspecialchars($subscribeToUsername);
} else {
echo "Вы уже подписаны на этого пользователя или не можете подписаться на себя.";
}
} else {
echo "Пользователь не найден.";
}
}
?>

<main />

<footer >
<p>&copy; 2024 Блог. Все права защищены.</p >
<footer >
<body >
<html ></html>
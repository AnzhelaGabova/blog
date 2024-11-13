<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Создание поста</title>
   <link rel="stylesheet" href="styles.css">
</head>
<body>

<header> 
<h1>Создание нового поста</h1> 
<nav> 
<a href='index.php'>Главная</a> 
<a href='view_posts.php'>Просмотр постов</a> 
<a href='logout.php'>Выход</a> 
</nav> 
</header>

<main> 
<form method='post' action='create_post.php'> 
<label for='title'>Заголовок:</label><br> 
<input type='text' id='title' name='title' required><br> 

<label for='content'>Содержание:</label><br> 
<textarea id='content' name='content' required></textarea><br> 

<label for='tags'>Теги:</label><br> 
<input type='text' id='tags' name='tags'><br> 

<label for='is_hidden'>Скрытый пост:</label> 
<input type='checkbox' id='is_hidden' name='is_hidden'><br> 

<input type='submit' value='Создать пост'> 
</form>

<?php
session_start();
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   createPost($_SESSION['user_id'], $_POST['title'], $_POST['content'], $_POST['tags'], isset($_POST['is_hidden']));
   header("Location: view_posts.php");
}
?>
</main>

<footer> 
<p>&copy; 2024 Блог. Все права защищены.</p> 
</footer>

</body> 
</html>

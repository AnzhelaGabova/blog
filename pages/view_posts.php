<!DOCTYPE html>
<html lang='ru'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<title>Просмотр постов</title>
<link rel='stylesheet' href='css/styles.css'>
</head>

<body>

<header>
<h1>Посты блога</h1>
<nav>
<a href='index.php'>Главная</a>
<a href='create_post.php'>Создать пост</a>
<a href='logout.php'>Выход</a>
<a href='subscribe.php'>Подписки</a> <!-- Ссылка на страницу подписок -->
</nav>
</header>

<main>

<!-- Здесь будут отображаться посты -->
<div class='posts'>
<?php
require 'includes/functions.php';
session_start();

$posts = getPublicPosts();
foreach ($posts as $post) {
echo "<h2 class='post-title'>" . htmlspecialchars($post['title']) . "</h2>";
echo "<p class='post-content'>" . nl2br(htmlspecialchars($post['content'])) . "</p>";
echo "<p class='post-tags'>Теги: " . htmlspecialchars($post['tags']) . "</p>";
echo "<p class='post-author'>Автор: " . htmlspecialchars($post['username']) . "</p>";
echo "<a class='edit-link' href='edit_post.php?id=".$post['id']."'>Редактировать</a> | ";
echo "<a class='delete-link' href='delete_post.php?id=".$post['id']."'>Удалить</a><br>";

// Получаем и отображаем комментарии к посту
$comments = getComments($post['id']);
if ($comments): ?>
    <h3>Комментарии:</h3>
    <ul>
        <?php foreach ($comments as $comment): ?>
            <li><strong><?= htmlspecialchars($comment['username']) ?>:</strong> <?= nl2br(htmlspecialchars($comment['content'])) ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Нет комментариев.</p>
<?php endif; ?>

<!-- Форма для добавления нового комментария -->
<?php if (isset($_SESSION['user_id'])): ?>
<form method="post" action="add_comment.php">
    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
    <label for="comment">Добавить комментарий:</label><br>
    <textarea id="comment" name="content" required></textarea><br>
    <input type="submit" value="Отправить">
</form>
<?php else: ?>
<p>Чтобы оставить комментарий, вам нужно <a href="login.php">войти</a>.</p>
<?php endif; ?>

<?php
}
?>
<p>No posts available.</p>

<footer>

<p>&copy; 2024 Блог. Все права защищены.</p>

<footer/>

</body>
</html>


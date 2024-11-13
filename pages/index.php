<?php
session_start();
require 'includes/db.php'; // Подключение к базе данных
require 'includes/functions.php'; // Подключение функций

// Получаем последние публичные посты
$posts = getPublicPosts();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница блога</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<?php include 'includes/header.php'; // Подключение заголовка ?>

<main>
    <h2>Последние посты</h2>

    <?php if (count($posts) > 0): ?>
        <div class="posts">
            <?php foreach ($posts as $post): ?>
                <article class="post">
                    <h3 class="post-title"><?= htmlspecialchars($post['title']) ?></h3>
                    <p class="post-content"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                    <p class="post-tags">Теги: <?= htmlspecialchars($post['tags']) ?></p>
                    <p class="post-author">Автор: <?= htmlspecialchars($post['username']) ?></p>
                    <a class="edit-link" href="edit_post.php?id=<?= $post['id'] ?>">Редактировать</a> |
                    <a class="delete-link" href="delete_post.php?id=<?= $post['id'] ?>">Удалить</a>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Пока нет постов. Будьте первым, кто создаст пост!</p>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; // Подключение подвала ?>

</body>
</html>
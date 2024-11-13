<?php
session_start();
require 'includes/db.php'; // Подключение к базе данных
require 'includes/functions.php'; // Подключение функций

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Перенаправление на страницу входа, если не авторизован
    exit;
}

// Получение ID поста из URL
$postId = $_GET['id'];

// Получение поста из базы данных
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
$stmt->execute([$postId, $_SESSION['user_id']]);
$post = $stmt->fetch();

if (!$post) {
    echo "Пост не найден или у вас нет прав на его редактирование.";
    exit;
}

// Обработка формы редактирования поста
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];

    // Обновление поста в базе данных
    editPost($postId, $title, $content, $tags);
    header("Location: view_posts.php"); // Перенаправление на страницу просмотра постов после успешного редактирования
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование поста</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<?php include 'includes/header.php'; // Подключение заголовка ?>

<main>
    <h1>Редактирование поста</h1>

    <form method="post">
        <label for="title">Заголовок:</label><br>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br>

        <label for="content">Содержание:</label><br>
        <textarea id="content" name="content" required><?= htmlspecialchars($post['content']) ?></textarea><br>

        <label for="tags">Теги:</label><br>
        <input type="text" id="tags" name="tags" value="<?= htmlspecialchars($post['tags']) ?>"><br>

        <input type="submit" value="Обновить пост">
    </form>
</main>

<?php include 'includes/footer.php'; // Подключение подвала ?>

</body>
</html>
<?php
session_start();
require 'includes/functions.php'; // Подключение функций

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['user_id'])) {
        $postId = $_POST['post_id'];
        $content = $_POST['content'];

        // Добавляем комментарий
        if (addComment($postId, $_SESSION['user_id'], $content)) {
            header("Location: view_posts.php"); // Перенаправление на страницу просмотра постов
            exit;
        } else {
            echo "Ошибка при добавлении комментария.";
        }
    } else {
        echo "Вы должны быть авторизованы для добавления комментариев.";
    }
} else {
    header("Location: view_posts.php"); // Перенаправление на страницу просмотра постов
}
?>
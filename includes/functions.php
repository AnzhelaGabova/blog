<?php
require 'db.php'; // Подключение к базе данных

// Функция для регистрации нового пользователя
function registerUser($username, $email, $password) {
    global $pdo;
    
    // Проверка на существующего пользователя
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->rowCount() > 0) {
        return false; // Пользователь с таким именем или email уже существует
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    return $stmt->execute([$username, $email, $hashedPassword]);
}

// Функция для входа пользователя
function loginUser($username, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        return $user; // Возвращаем данные пользователя при успешном входе
    }
    
    return null; // Если вход не удался
}

// Функция для создания нового поста
function createPost($userId, $title, $content, $tags, $isHidden) {
    global $pdo;
    
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content, tags, is_hidden) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$userId, $title, $content, $tags, (bool)$isHidden]);
}

// Функция для получения всех публичных постов
function getPublicPosts() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.is_hidden = FALSE ORDER BY created_at DESC");
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Функция для редактирования поста
function editPost($postId, $title, $content, $tags) {
    global $pdo;
    
    // Проверка на существующий пост
    if (!postExists($postId)) {
        return false; // Пост не найден
    }

    // Обновление поста в базе данных
    $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ?, tags = ? WHERE id = ?");
    return $stmt->execute([$title, $content, $tags, (int)$postId]);
}

// Функция для удаления поста
function deletePost($postId) {
    global $pdo;

    // Проверка на существующий пост
    if (!postExists($postId)) {
        return false; // Пост не найден
    }

    // Удаляем пост по ID
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    return $stmt->execute([(int)$postId]);
}

// Функция для проверки существования поста
function postExists($postId) {
   global $pdo;

   // Проверяем наличие поста в базе данных
   $stmt = $pdo->prepare("SELECT COUNT(*) FROM posts WHERE id = ?");
   $stmt->execute([(int)$postId]);
   return ($stmt->fetchColumn() > 0);
}

// Функция для подписки на пользователя
function subscribeToUser($userId, $subscribeToId) {
   global $pdo;

   // Проверка на существующую подписку
   if ($userId === (int)$subscribeToId) return false; // Нельзя подписаться на себя

   // Проверка на существующую подписку
   if ($pdo->prepare("SELECT * FROM subscriptions WHERE user_id = ? AND subscribed_to = ?")->execute([$userId, (int)$subscribeToId])->rowCount() > 0) {
       return false; // Подписка уже существует
   }

   // Создаем новую подписку
   try {
       $stmt = $pdo->prepare("INSERT INTO subscriptions (user_id, subscribed_to) VALUES (?, ?)");
       return $stmt->execute([$userId, (int)$subscribeToId]);
   } catch (PDOException $e) {
       return false; // Ошибка при добавлении подписки
   }
}

// Функция для получения всех подписок пользователя
function getSubscriptions($userId) {
   global $pdo;

   // Получаем список ID пользователей на которых подписан текущий пользователь
   try {
       $stmt = $pdo->prepare("SELECT subscribed_to FROM subscriptions WHERE user_id = ?");
       stmt->execute([$userId]);

       return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'subscribed_to');
   } catch (PDOException$e) {
       return []; // Возвращаем пустой массив в случае ошибки
   }
}

// Функция для добавления комментария к посту
function addComment($postId, $userId, $content) {
    global $pdo;

    $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
    return $stmt->execute([$postId, $userId, $content]);
}

// Функция для получения комментариев к посту
function getComments($postId) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = ? ORDER BY created_at DESC");
    $stmt->execute([$postId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
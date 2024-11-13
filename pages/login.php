<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Вход</title>
   <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
   <h1>Вход в блог</h1>
</header>
<main>
   <form method="post" action="login.php">
       <label for="username">Имя пользователя:</label><br>
       <input type="text" id="username" name="username" required><br>

       <label for="password">Пароль:</label><br>
       <input type="password" id="password" name="password" required><br>

       <input type="submit" value="Войти">
   </form>

   <?php
   session_start();
   require 'functions.php';

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       if ($user = loginUser($_POST['username'], $_POST['password'])) {
           $_SESSION['user_id'] = $user['id'];
           header("Location: create_post.php");
           exit;
       } else {
           echo "Неверные учетные данные.";
       }
   }
   ?>
</main>
<footer>
   <p>&copy; 2024 Блог. Все права защищены.</p>
</footer>
</body>
</html>
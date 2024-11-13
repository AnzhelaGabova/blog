<!DOCTYPE html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Регистрация</title>
   <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
   <h1>Регистрация</h1>
</header>
<main>
   <form method="post" action="register.php">
       <label for="username">Имя пользователя:</label><br>
       <input type="text" id="username" name="username" required><br>

       <label for="email">Email:</label><br>
       <input type="email" id="email" name="email" required><br>

       <label for="password">Пароль:</label><br>
       <input type="password" id="password" name="password" required><br>

       <input type="submit" value="Зарегистрироваться">
   </form>

   <?php
   require 'functions.php';

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       if (registerUser($_POST['username'], $_POST['email'], $_POST['password'])) {
           echo "Пользователь успешно зарегистрирован!";
           header("Location: login.php");
           exit;
       } else {
           echo "Ошибка регистрации.";
       }
   }
   ?>
</main>
<footer>
   <p>&copy; 2024 Блог. Все права защищены.</p>
</footer>
</body>
</html>
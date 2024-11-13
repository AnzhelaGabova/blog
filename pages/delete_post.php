<?php
session_start();
require 'functions.php';

if (!isset($_SESSION['user_id'])) {
header("Location: login.php");
exit;
}

$postId = $_GET['id'];
deletePost($postId);
header("Location: view_posts.php");
exit;
?>
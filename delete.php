<?php
session_start();
$pdo = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $_SESSION['flash'] = "Post deleted!";
}

header("Location: index.php");
exit;

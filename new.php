<?php
session_start();
$pdo = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($title && $content) {
        $stmt = $pdo->prepare("INSERT INTO posts (title, content, created_at) VALUES (?, ?, ?)");
        $stmt->execute([$title, $content, date('Y-m-d H:i:s')]);
        $_SESSION['flash'] = "Post created!";
        header("Location: index.php");
        exit;
    } else {
        $error = "Both fields are required.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>New Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Create New Post</h1>

    <?php if (!empty($error)): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="post">
        <p><input type="text" name="title" placeholder="Title"></p>
        <p><textarea name="content" rows="5" cols="50" placeholder="Content"></textarea></p>
        <p><button type="submit">Save</button></p>
    </form>

    <p><a href="index.php">Back to Blog</a></p>
</body>
</html>

<?php
session_start();
$pdo = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get post ID
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

// Fetch post
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    $_SESSION['flash'] = "Post not found.";
    header("Location: index.php");
    exit;
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($title && $content) {
        $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $stmt->execute([$title, $content, $id]);
        $_SESSION['flash'] = "Post updated!";
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
    <title>Edit Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Post</h1>

    <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="post">
        <p><input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>"></p>
        <p><textarea name="content" rows="5" cols="50"><?= htmlspecialchars($post['content']) ?></textarea></p>
        <p>
            <button type="submit">Update</button>
            <a href="index.php" class="btn">Cancel</a>
        </p>
    </form>
</body>
</html>

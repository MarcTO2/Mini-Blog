<?php
session_start();
$pdo = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Pagination settings
$perPage = 5; 
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $perPage;

// Search
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

// Count total posts (with search)
if ($search) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM posts WHERE title LIKE :s OR content LIKE :s");
    $stmt->execute([':s' => "%$search%"]);
    $total = $stmt->fetchColumn();
} else {
    $total = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();
}
$totalPages = ceil($total / $perPage);

// Fetch posts for current page (with search)
if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM posts 
                           WHERE title LIKE :s OR content LIKE :s 
                           ORDER BY created_at DESC 
                           LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':s', "%$search%", PDO::PARAM_STR);
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
}
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mini Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>My Mini Blog</h1>

    <?php if (!empty($_SESSION['flash'])): ?>
        <p class="flash"><?= $_SESSION['flash']; unset($_SESSION['flash']); ?></p>
    <?php endif; ?>

    <!-- Search form -->
    <form method="get" action="index.php" class="search-form">
        <input type="text" name="search" placeholder="Search posts..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <p><a href="new.php">+ New Post</a></p>
    <hr>

    <?php if (empty($posts)): ?>
        <p>No posts found.</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <h2><?= htmlspecialchars($post['title']) ?></h2>
                <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                <small>Posted at <?= $post['created_at'] ?></small>
                <br><br>
                <a href="edit.php?id=<?= $post['id'] ?>">Edit</a>
                <a href="delete.php?id=<?= $post['id'] ?>" onclick="return confirm('Delete this post?')">Delete</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?search=<?= urlencode($search) ?>&page=<?= $page - 1 ?>">&laquo; Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?search=<?= urlencode($search) ?>&page=<?= $i ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?search=<?= urlencode($search) ?>&page=<?= $page + 1 ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
</body>
</html>

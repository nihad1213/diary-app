<?php
/* Load functions file */
require __DIR__ . '/inc/functions.inc.php';
/* Load database file */
require __DIR__ . '/inc/db-connect.inc.php';

date_default_timezone_set('Europe/London');

$perPage = 2;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

// Get total number of entries
$totalStmt = $pdo->query('SELECT COUNT(*) FROM entries');
$totalEntries = $totalStmt->fetchColumn();
$totalPages = ceil($totalEntries / $perPage);

$stmt = $pdo->prepare('SELECT * FROM entries ORDER BY date DESC, id DESC LIMIT :perPage OFFSET :offset');
$stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once __DIR__ . '/views/header.php'; ?>

<main class="main">
    <div class="container">
        <h1 class="main-heading">Entries</h1>
        
        <?php foreach($results as $result): ?>
            <div class="card">
                <div class="card__image-container">
                    <img class="card__image" src="images/pexels-canva-studio-3153199.jpg" alt="" />
                </div>
                <div class="card__desc-container">
                    <div class="card__desc-time"><?= e($result['date']) ?></div>
                    <h2 class="card__heading"><?= e($result['title']) ?></h2>
                    <p class="card__paragraph">
                        <?= nl2br(e($result['message'])) ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if ($totalPages > 1): ?>
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="pagination__li">
                    <a class="pagination__link" href="?page=<?= $page - 1 ?>">⏴</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="pagination__li">
                    <a class="pagination__link <?= $i === $page ? 'pagination__link--active' : '' ?>" href="?page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <li class="pagination__li">
                    <a class="pagination__link" href="?page=<?= $page + 1 ?>">⏵</a>
                </li>
            <?php endif; ?>
        </ul>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/views/footer.php'; ?>

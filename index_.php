<?php require __DIR__ . './parts/connect_db.php';
$pageName = 'index';
$title = '首頁';

?>
<?php include __DIR__ . './parts/html-head.php' ?>
<?php include __DIR__ . './parts/navbar.php' ?>
<div class="container">
    <h2>Home</h2>
    <!-- $pdo->quote() 用來跳脫 SQL 裡值的單引號, 避免 SQL injection  -->
    <p><?= $pdo->quote("Alice's cats") ?></p>

</div>
<?php include __DIR__ . './parts/scripts.php' ?>
<?php include __DIR__ . './parts/html-foot.php' ?>

<!-- // 這邊分開放可以方便放tag, 但這種把php當框架用的方法已經比較舊了 -->
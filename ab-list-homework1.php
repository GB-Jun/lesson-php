<?php require __DIR__ . './parts/connect_db.php';

$pageName = 'ab-list';
$title = '้่จๅ่กจ';

$perPage = 20;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    exit;
}

$t_sql = "SELECT count(1) FROM address_book";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

$totalPages = ceil($totalRows / $perPage);
$rows = [];
if ($totalRows > 0) {
    if ($page > $totalPages) {
        header("Location: ?page=$totalPages");
        exit;
    }
    $sql = sprintf("SELECT * FROM address_book ORDER BY sid DESC LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

    $rows = $pdo->query($sql)->fetchAll();
}




?>
<?php include __DIR__ . './parts/html-head.php' ?>

<?php include __DIR__ . './parts/navbar.php'
?>

<!-- server side render -->
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">

                    <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>"><a class="page-link" href="?page=1">
                            <i class="fa-solid fa-angles-left"></i>
                        </a></li>
                    <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>"><a class="page-link" href="?page=<?= $page - 1 ?>"><i class="fa-solid fa-angle-left"></i></a></li>

                    <?php for ($i = $page - 3; $i <= $page + 3; $i++) :
                        if ($i >= 1 and $i <= $totalPages) :
                    ?>

                            <li class="page-item <?= $page == $i ? 'active ' : ''; ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>

                    <?php endif;
                    endfor; ?>

                    <li class="page-item <?= $page == $totalPages ? 'disabled' : ''; ?>"><a class="page-link" href="?page=<?= $page + 1 ?>"><i class="fa-solid fa-angle-right"></i></a></li>
                    <li class="page-item <?= $page == $totalPages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="?page=<?= $totalPages ?>">
                            <i class="fa-solid fa-angles-right"></i>
                        </a>
                    </li>


                </ul>
            </nav>
        </div>
    </div>


    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th scope="col"><i class="fa-solid fa-trash-can"></i></th>
                <th scope="col">#</th>
                <th scope="col">ๅงๅ</th>
                <th scope="col">ๆๆฉ</th>
                <th scope="col">้ป้ต</th>
                <th scope="col">็ๆฅ</th>
                <th scope="col">ๅฐๅ</th>
                <th scope="col"><i class="fa-solid fa-pen-to-square"></i></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td><a href="javascript:" onclick="trasnCanClicked(event); return false;"><i class="fa-solid fa-trash-can"></i></a></td>
                    <td><?= $r['sid'] ?></td>
                    <td><?= $r['name'] ?></td>
                    <td><?= $r['mobile'] ?></td>
                    <td><?= $r['email'] ?></td>
                    <td><?= $r['birthday'] ?></td>
                    <td><?= $r['address'] ?></td>
                    <td><a href="#"><i class="fa-solid fa-pen-to-square"></i></a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
</div>

</table>
<?php include __DIR__ . './parts/scripts.php' ?>
<script>
    // ๅพๅ็ซฏ็งป้ค็function , ็ตๅไบไปถ่็ๅจ, ๅจdom่ฃก็target, remove็็จๆณ
    function trashCanClicked(event) {
        // console.log(event.currentTarget);
        // console.log(event.target);
        const a_tag = event.currentTarget;
        const tr = a_tag.closest('tr');
        console.log(tr);
        tr.remove();
    }
</script>
<?php include __DIR__ . './parts/html-foot.php' ?>
<?php require __DIR__ . './parts/connect_db.php';

// MVC的MC部分在這邊寫
// 這邊是為了方便, 要不然表格不適合用於RWD

//每一頁最多有幾筆
$perPage = 5;

// 用戶要看第幾頁
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1');
    // header('Location: ab-list.php');
    // 轉向自己,但是把參數清空, 一條是原本的頁面但改動參數,一條是直接轉回原網頁
    exit;
}

// 先算總共有幾筆, 再去算總共有幾頁
$t_sql = "SELECT count(1) FROM address_book";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
//總筆數, fetch(PDO::FETCH_NUM)[0] 索引式陣列拿到第一筆

$totalPages = ceil($totalRows / $perPage);
//總共有幾頁, 這邊要無條件進位

// 先給一個預設值, 之後要用可以用, 沒有用到也才不會出錯
$rows = [];
// 在取得最大頁面之後才開始來做限制
if ($totalRows > 0) {
    if ($page > $totalPages) {
        // 頁碼超過總頁數時, 讓他轉向最大頁面
        header("Location: ?page=$totalPages");
        exit;
    }
    $sql = sprintf("SELECT * FROM address_book LIMIT %s, %s", ($page - 1) * $perPage, $perPage);

    $rows = $pdo->query($sql)->fetchAll();
}


// echo $totalRow; exit; //暫時show出內容 看完註解掉








?>
<?php include __DIR__ . './parts/html-head.php' ?>

<?php include __DIR__ . './parts/navbar.php'
// 這條開始是html的內容, 可以看成是呈現的部分MVC的V
?>

<!-- server side render -->
<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="Page navigation example">
                <ul class="pagination">

                    <!-- php寫在class裡面, 讓使用者按頁術限定在1到最大頁面之間 -->
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
                <th scope="col">#</th>
                <th scope="col">姓名</th>
                <th scope="col">手機</th>
                <th scope="col">電郵</th>
                <th scope="col">生日</th>
                <th scope="col">地址</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td><?= $r['sid'] ?></td>
                    <td><?= $r['name'] ?></td>
                    <td><?= $r['mobile'] ?></td>
                    <td><?= $r['email'] ?></td>
                    <td><?= $r['birthday'] ?></td>
                    <td><?= $r['address'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
</div>

</table>
<?php include __DIR__ . './parts/scripts.php' ?>
<?php include __DIR__ . './parts/html-foot.php' ?>
<div>
    <?php require __DIR__ . '/parts/connect_db.php';
    exit;  // 需要時註解, 用完記得打開, 以避免一次又加很多筆資料

    echo microtime(true) . "<br/>";
    $lname = ['陳', '李', '吳', '王', '林', '周', '鄭'];
    $fname = ['小明', '小華', '怡君', '雅玲', '振翰', '曉君'];


    // 幾個問號就要搭配幾個值
    $sql = "INSERT INTO `address_book`(
    `name`, `email`, `mobile`, 
    `birthday`, `address`, `created_at`
    ) VALUES (
        ?, ?, ?,
        ?, ?, NOW()
    )";

    // prepare 和 execute是搭配使用的
    $stmt = $pdo->prepare($sql);

    for ($i = 0; $i < 100; $i++) {
        shuffle($lname);
        shuffle($fname);
        $ts = rand(strtotime('1980-01-01'), strtotime('1995-12-31'));
        $stmt->execute([
            $lname[0] . $fname[0],
            "ming{$i}@test.com",
            '0918' . rand(100000, 999999),
            date('Y-m-d', $ts),
            '南投市',
        ]);
    }


    echo microtime(true) . "<br/>";
    ?>
</div>
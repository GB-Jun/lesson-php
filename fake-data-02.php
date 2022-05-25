<?php require __DIR__ . '/parts/connect_db.php';

// 新增資料時, 如果資料從外面來的, 一律用prepare, 以避免SQL injection, 新增, 修改都會用到
$sql = "INSERT INTO `address_book`(
    `name`, `email`, `mobile`, 
    `birthday`, `address`, `created_at`
    ) VALUES (
        ?, ?, ?,
        ?, ?, NOW()
    )";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    "李小明's pen",
    'ming@test.com',
    '0918123456',
    '1987-11-23',
    '南投市',
]);


echo $stmt->rowCount();

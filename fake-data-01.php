<?php require __DIR__ . '/parts/connect_db.php';


$sql = "INSERT INTO `address_book`(
    `name`, `email`, `mobile`, 
    `birthday`, `address`, `created_at`
    ) VALUES (
        '李小明', 'ming@test.com', '0918123456',
        '1987-11-23', '南投市', NOW()
    )";

$stmt = $pdo->query($sql);

echo $stmt->rowCount();

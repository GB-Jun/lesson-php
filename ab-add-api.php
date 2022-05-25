<?php require __DIR__ . './parts/connect_db.php';

$output = [
    'success' => 'false',
    'postData' => $_POST,
    'code' => 0, // 一個辨識資料
    'error' => ''

];

// TODO 欄位檢查, 後端檢查, 原則上後端檢查是比較重要的, 但前端也要做, 和UX, 用戶體驗相關

if (empty($_POST['name'])) {
    $output['error'] = '沒有姓名資料';
    $output['code'] = 400; // 自己定的規則, 這邊是沒有資料
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    echo json_encode($stmt->rowCount());
    exit;
}




$sql = "INSERT INTO `address_book`(
    `sid`, `name`, `email`, 
    `mobile`, `birthday`, `address`, `created_at`
    ) VALUES (
        ?, ?, ?
        ?, ?, NOW()
    )";

// 用一個變數去接sql的statment, 拿到pdo statment的物件
$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_POST['name'],
    $_POST['email'],
    $_POST['mobile'],
    empty($_POST['birthday']) ? NULL : $_POST['birthday'],
    $_POST['address'],
]);

// 一個輸出看有沒有成功
// $output['success'] = $stmt->rowcount() == 1;
// $output['success'] = $stmt->rowcount();

if ($stmt->rowCount() == 1) {

    $output['success'] = true;
} else {
    $output['error'] = '資料無法新增';
}



echo json_encode($output, JSON_UNESCAPED_UNICODE);

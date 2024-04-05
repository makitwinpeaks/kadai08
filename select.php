<?php


$sql = "SELECT * FROM user_signup";
$conditionSet = false;

// 生年月日で降順にソート
if (isset($_POST['sort_by_birthdate'])) {
    $sql .= " ORDER BY birthdate DESC";
    $conditionSet = true;
}

// 未婚で絞り込み
if (isset($_POST['filter_unmarried'])) {
    $sql .= " WHERE marital_status = '未婚'";
    $conditionSet = true;
}

// 既婚で絞り込み
if (isset($_POST['filter_married'])) {
    $sql .= " WHERE marital_status = '既婚'";
    $conditionSet = true;
}

try {
    $pdo = new PDO('mysql:dbname=bridal_db;charset=utf8;host=localhost','root','');
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("データベースエラー: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録情報一覧</title>
   
    <style>
  div{padding: 10px;font-size:16px;}
  td{border: 1px solid black;}
</style>
</head>
<body>
    <h1>登録情報一覧</h1>

    <button onclick="location.href='./index.php'">ユーザー情報登録画面に戻る</button>
    

    <form action="select.php" method="post">
        <button type="submit" name="sort_by_birthdate">生年月日で降順にソート</button>
        <button type="submit" name="filter_unmarried">未婚で絞り込み</button>
        <button type="submit" name="filter_married">既婚で絞り込み</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ニックネーム</th>
                <th>性別</th>
                <th>生年月日</th>
                <th>都道府県</th>
                <th>交際ステータス</th>
                <th>子どもの人数</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['nickname'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($user['gender'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($user['birthdate'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($user['prefecture'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($user['marital_status'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($user['children'], ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
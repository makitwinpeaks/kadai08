<?php
//1. POSTデータ取得
//＊TODO＊受け取りの項目を増減する。

$nickname = $_POST['nickname'];
$gender = $_POST['gender'];
$birthdate = $_POST['birthdate'];
$prefecture = $_POST['prefecture'];
$marital_status = $_POST['marital_status'];
$children = $_POST['children'];

// エラーはvar_dampで確認。
// var_dump($_POST); // formの送信方法に合わせて出力
// exit();

//2. DB接続します 
//＊TODO＊以下は今後もコピーして使用する。何に接続するかだけ変更する。
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=bridal_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DB_CONNECT:'.$e->getMessage());
}


//３．データ登録SQL作成
//一度受け取った変数をbindValueでクリーニング（怪しいコマンド等を削除）して、入れなおすための記述。
//*TODO*コピペして使用し、SQLの項目と、bindValueの項目だけ変える。
$sql = "INSERT INTO user_signup(nickname, gender, birthdate, prefecture, marital_status, children)VALUES(:nickname, :gender, :birthdate, :prefecture, :marital_status, :children);";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':nickname',        $nickname,         PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':gender',          $gender,           PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':birthdate',       $birthdate,        PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':prefecture',      $prefecture,       PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':marital_status',  $marital_status,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':children',        $children,         PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
// $stmt->bindValue(':indate',          $indate,           PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)

$status = $stmt->execute(); //true or false 

//４．データ登録処理後
//*TODO*これはこのままコピペ。
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}else{
  //５．index.phpへリダイレクト Locationの後の半角スペースを忘れない。
  //うまく処理されていれば、index.phpに遷移しているはず。
  //*TODO*遷移先を変更する。
  header("Location: index.php");
  exit();
}
?>

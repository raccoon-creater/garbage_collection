<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

require_once __DIR__ . '/../classes/list_db.php';

$list_db = new List_db();
$userId = 1; //ログイン完成後、$_SESSION['userId']に変更

$lists = $list_db->get_lists($userId); //ログイン完成後、$_SESSION['userId']に変更

//ステッカー情報を出力
foreach($lists as $list){
?>
    <!-- 出力テスト　結合後削除お願いします -->
    <li><?= $list['image'] ?></li>
    <li><?= $list['rarity'] ?></li>
    <li><?= $list['get_place'] ?></li>
<?php

}
?>
</body>
</html>


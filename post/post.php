<?php

//画像投稿・透過・編集機能
require_once __DIR__ . '/uploader.php';
require_once __DIR__ . '/../util.php';

ini_set('display_errors',1);
define('MAX_FILE_SIZE',1 * 1024 * 2048);    //2MB
define('THUMBNAIL_WIDTH',480);  //画像横幅
define('THUMBNAIL_HEIGHT',480);  //画像縦幅
define('IMAGES_DIR', __DIR__ . '/images');  //投稿された画像のディレクトリ
define('THUMBNAIL_DIR', __DIR__ . '/thumbs');  //投稿され形を整えられた画像のディレクトリ

//GD関数がインストールされているか確認
if(!function_exists('imagecreatetruecolor')){
    echo 'GD not installed';
    exit;
}

$uploader = new ImageUploader();

// uploadボタンが押されているか判定
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $uploader->upload();
}
?>

<!-- 投稿画面 -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>garbage collection</title>
    <!-- 仮　デザイン実装後削除 ↓-->
    <style>
    body{
        text-align: center;
        font-family: Arial,sans-serif;
    }
    </style>
    <!-- ここまで -->
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
        <input type="file" name="image"><br>
        レア度：<input type="radio" name="rarity">1
            <input type="radio" name="rarity">2
            <input type="radio" name="rarity">3
            <input type="radio" name="rarity">4
            <input type="radio" name="rarity">5<br>
        入手場所：<input type="text" name="get_place"><br>
        <input type="submit" value="upload">
    </form>
</body>
</html>
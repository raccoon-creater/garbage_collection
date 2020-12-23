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
require_once __DIR__ . '/../header.php';
?>
    <!-- メイン画像部分 -->
    <div class="main">
        <div class="main_image">    <!-- メイン画面の画像クラス -->
            <img src="../photos/POST.png">　<!--　メイン画面のタイトル画像  -->
        </div>
    </div>
    <!-- 投稿部分 -->
    <div class="post_form">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>"　class="file_select">
            <input type="file" name="image"><br>
            Rearity：<input type="radio" name="rarity" value="1">1
            <input type="radio" name="rarity" value="2">2
            <input type="radio" name="rarity" value="3">3
            <input type="radio" name="rarity" value="4">4
            <input type="radio" name="rarity" value="5">5<br>
            Get Place：<input type="text" name="get_place"><br>
            <input type="submit" value="upload" class="upload">
        </form>
    </div>
<?php
require_once __DIR__ . '/../footer.php';
?>

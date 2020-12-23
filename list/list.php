<?php

require_once __DIR__ . '/../header.php'; 
require_once __DIR__ . '/../classes/list_db.php';

$list_db = new List_db();
$userId = 1; //ログイン完成後、$_SESSION['userId']に変更

$lists = $list_db->get_lists($userId); //ログイン完成後、$_SESSION['userId']に変更
?>

<div class="wrapper">  <!--全体のクラス-->
    <div class="contents"><!--メインのブロック -->
        <div class="main_image">     <!--メインタイトル（background-imageで指定） -->
            <img src="../photos/material/LIST.png" alt=""><!--機能のタイトル画像（例：LIST） -->
        </div>
        <div class="main_list"><!--ステッカー一覧 -->
        <?php   //繰り返してステッカーを表示する
            $cnt=1;
            // $image_names=array('エース.png','安室.png','ゼニガメ.png','車.png','女.png','安室.png','エース.png','ゼニガメ.png','車.png','女.png','安室.png','エース.png','ゼニガメ.png','車.png','女.png');
            // foreach ($image_names as $image_name) {
            //ステッカー情報を出力
            foreach($lists as $list){
                $id='img'.$cnt;
        ?>
                <div class="sticker"><!--ステッカー表示(繰返し部分) -->
                    <!--↓画像のサイズを一定にするためidを指定し、その名前をonloadの関数の引数に入れる-->
                    <img src="../post/images/<?= $list['image'] ?>"  id="<?= $id ?>" onload="resizeByWidth('<?= $id ?>');">
                    <div class="mask">
                        <div class="caption"><!--mainの画像（backgroundで指定） -->
                            <table>
                                <tr>
                                    <td>＜rarity＞</td><!--レアリティ -->
                                </tr>
                                <tr>
                                    <th><span style="color: gold;"><?= $list['rarity'] ?></span></th>
                                </tr>
                                <tr>
                                    <td>＜place＞ </td><!--場所 -->
                                </tr>
                                <tr>
                                    <th><?= $list['get_place'] ?></th>
                                </tr>
                                </table>
                        </div>
                    </div>
                </div>
            <?php $cnt=$cnt+1;
            }?>
        </div>
        <div class="page_button">   <!--ページングの時のボタンや文字-->
            <button><img src="../photos/material/left.png" alt=""></button>
            <p>1</p>
            <button><img src="../photos/material/right.png" alt=""></button>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../footer.php'; ?>
</body>
</html>

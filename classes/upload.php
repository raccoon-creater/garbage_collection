<?php
//ステッカーの情報をデータベースに登録する
//スーパークラスであるDbDataを利用する
require_once __DIR__ . '/dbdata.php';

class Upload extends DbData{

    //ステッカーの情報を登録する
    public function addPost($userId,$image,$rarity,$get_place){
        $sql = "insert into post(user_id,image,rarity,get_place) values(?,?,?,?)";
        $result = $this->exec($sql,[$userId,$image,$rarity,$get_place]);
    }
}
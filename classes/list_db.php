<?php
//ステッカーの情報をデータベースから取り出す
//スーパークラスであるDbDataを利用する
require_once __DIR__ . '/dbdata.php';

class List_db extends DbData{

    public function get_lists($userId){
        $sql = "select image,rarity,get_place from post where user_id = ?";
        $stmt = $this->query($sql,[$userId]);
        $lists = $stmt->fetchAll();
        return $lists;
    }
}
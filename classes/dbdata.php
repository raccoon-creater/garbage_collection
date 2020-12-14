<?php
    class DbData{   //DbDataクラスの宣言

        protected $pdo; //PDOオブジェクト用のプロパティ

        public function __construct(){
            //PDOオブジェクト生成する
            $dsn = 'mysql:host=localhost;dbname=データベース名;charset=utf8';
            $user = 'ユーザー名';
            $password = 'パスワード';
            try{
                $this->pdo = new PDO($dsn,$user,$password);
            }catch(Exception $e){
                echo 'Error:' . $e->getMessage();
                die();
            }
        }

        //SELECT文実行用メソッド
        protected function query($sql,$array_params){
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($array_params);
            return $stmt;
        }

        //INSERT、UPDATE、DELETE文実行用のメソッド
        protected function exec($sql,$array_params){
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($array_params);
        }
    }
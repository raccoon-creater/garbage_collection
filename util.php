<?php
//エスケープ処理
function h($s){
    return htmlspecialchars($s,ENT_QUOTES,'UTF-8');
}
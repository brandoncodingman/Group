<?php
/**
 * エスケープ用の関数
 * エスケープ：HTMLとかJSをただの文字にする。
 * xss攻撃をサニタイジング（無毒化）する
 * 
 * htmlspecialchars()
 * htmlentities()
 * strip_tags()
 */

 
function e(string $str , string $charset ='UTF-8'):string{
    return htmlspecialchars($str,ENT_QUOTES | ENT_HTML5,$charset,false);
}
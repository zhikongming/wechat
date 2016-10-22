<?php
require_once("../api/menu.php");
function create_menu(){
    $obj = new W_Menu();
    $menu = array(
         "button" => array(
             array(
                "type" => "click",
                "name" => "今日歌曲",
                "key" => "music"
             ),
             array(
                 "name" => "菜单",
                 "sub_button" => array(
                     array(
                         "type" => "view",
                         "name" => "搜索",
                         "url" => "http://www.baidu.com/"
                     ),
                     array(
                         "type" => "click",
                         "name" => "点赞",
                         "key" => "good"
                     )
                 )
             )
         )
    );
    $obj->create_menu($menu);
}

create_menu();
?>
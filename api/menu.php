<?php
    /*
    *Author: zhaozhiyang
    * Date: 2016-10-08
    * Version: 1.0
    *
    * W_Menu: deal with menu.
    *         自定义菜单
    */
    ini_set("display_errors","On");
    error_reporting(E_ALL);
    require_once("../api/object.php");
    class W_Menu extends WeChat{
        function __construct(){
            parent::__construct();
        }

        /*
        * create_menu
        * @data: menu array.
        */
        public function create_menu($data){
            $url = sprintf($this->config_info["menu_create"], $this->access_token);
            $this->post_to_wechat($url, $data);
        }

        /*
        * search menu
        */
        public function search_menu(){
            
        }
        
    }
?>
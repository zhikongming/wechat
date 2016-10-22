<?php
    /*
    * Author: zhaozhiyang
    * Date: 2016-10-08
    * Version: 1.0
    * 
    * WeChat: base class of wechat.
    */
    ini_set("display_errors","On");
    error_reporting(E_ALL);
    date_default_timezone_set("PRC");
    class WeChat{
        protected $appid;
        protected $appsecret;
        protected $access_token;
        protected $config_info;

        function __construct(){
            $config_info = parse_ini_file("../config.ini");
            $this->appid = $config_info["appid"];
            $this->appsecret = $config_info["appsecret"];
            $this->config_info = $config_info;
            $this->access_token = $this->get_access_token();
        }

        /*
          access token will be stored in a file.
        */
        private function get_access_token(){
            $store_file = dirname(__FILE__)."access_token.txt";
            if(file_exists($store_file)){
                $json_data = json_decode(file_get_contents($store_file));
                // Check whether the access token is expired.
                $now_time = time();
                if($now_time < $json_data->expire_time){
                    return $json_data->access_token;
                }
            }
            $url = sprintf($this->config_info["access_token_get"], $this->appid, $this->appsecret);
            $json_data = json_decode(file_get_contents($url));
            $data = array();
            $data["access_token"] = $json_data->access_token;
            $now_time = time();
            $data["expire_time"] = $json_data->expires_in + $now_time;
            $json_string = json_encode($data);
            file_put_contents($store_file, $json_string);
            return $json_data->access_token;
        }

        /*
        * Post data to wechat server.
        */
        public function post_to_wechat($url, $data){
            $data_string = json_encode($data, JSON_UNESCAPED_UNICODE);
            //echo $data_string;exit();
            $cUrl = curl_init();
            curl_setopt($cUrl, CURLOPT_URL, $url);
            curl_setopt($cUrl, CURLOPT_POST, true);
            curl_setopt($cUrl, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($cUrl,CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($cUrl);
            curl_close($cUrl);
            $json_result = json_decode($result);
            if($json_result->errcode == 0){
                echo "Successful!";
            }else{
                echo "Fail, Reason:" . $json_result->errmsg;
            }
        }

        /*
        * print an array or object for debuging.
        */
        public function w_print($print){
            echo "<pre>";
            print_r($print);
            exit();
        }
    }
?>
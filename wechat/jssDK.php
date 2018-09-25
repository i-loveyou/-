<?php
    require_once "ticket.php";
    //获取签名算法的方法
    function getSignPackage() {
        //获取ticket
        $ticket = getTicket();

    $url = $_GET["uri"];

    $timestamp = time();
    $nonceStr = createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);
        
        $signPackage = array(
            "appId"     => "wx31325261f851fbc6",
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
         );
         return json_encode($signPackage); 
    }
    
    echo getSignPackage();
    
    function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
     }
?>
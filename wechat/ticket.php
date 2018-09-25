<?php
    require_once "accessToken.php";
    
    function getNewTicket() {
        // 获取accessToken
        $at = getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$at}&type=jsapi";
        // 发起网络请求
        $jsonStr = httpGet($url);
        
        //解码
        $jsonObj = json_decode($jsonStr);
        
        //返回ticket
        return $jsonObj->ticket;
    }
    
    
    function getTicket() {
        //链接数据库
         $mysqli = new mysqli("qsbmcrhtztqj.mysql.sae.sina.com.cn","wyl_wechat01","wyl2314926967","wyl","10472");
         
         if($mysqli->connect_error) {
             exit("数据库连接失败");
         }
         
         $mysqli->set_charset("utf8");
         
         //先查询是否是第一次使用ticket
         $selectSql = "select * from ticket";
         
         $res = $mysqli->query($selectSql);
         
         $arr = mysqli_fetch_all($res, MYSQLI_NUM);
         
         if (count($arr) == 0) {
             //第一次使用
             $ticket = getNewTicket();
             $time = time();
             
             $insertSql = "insert into ticket (ticket, time) values ('{$ticket}', '{$time}')";
             if(!$mysqli->query($insertSql)) {
                 exit("数据插入失败");
             }
             return $ticket;
         }else {
             //之后使用
             //判断是否过期
             $obj = $arr[0];
             //取出时间
             $time = $obj[1];
             //获取当前时间
             $now = time();
             if ($now - $time > 10) {
                 //过期
                 $ticket = getNewTicket();
                 $updateStr = "update ticket set ticket = '{$ticket}', time = '{$now}'";
                 if(!$mysqli->query($updateStr)) {
                     exit("更新数据失败");
                 }
                 return $ticket;
             }else {
                 return $obj[0];
             }
         }
    }
?>

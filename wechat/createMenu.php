<?php
    require_once "accessToken.php";
    
    //创建菜单的方法
    function createMenu() {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".getAccessToken();
        
        //用定界符书写菜单结构
        $jsonMenu = <<<AAA
        {
    		"button": [
		        {
		            "name": "点击事件", 
		            "sub_button": [
		                {    
		                    "type":"click",
		                    "name":"发送文字",
		                    "key":"sendText"
		                }, 
		                {    
		                    "type":"click",
		                    "name":"发送图片",
		                    "key":"sendImg"
		                },
		                {    
		                    "type":"click",
		                    "name":"发送语音",
		                    "key":"sendVoice"
		                },
		                {    
		                    "type":"click",
		                    "name":"发送视频",
		                    "key":"sendVideo"
		                },
		                {    
		                    "type":"click",
		                    "name":"发送图文",
		                    "key":"sendArticles"
		                }
		            ]
		        }, 
		        {
		            "name": "扫码相机", 
		            "sub_button": [
		                {
		                    "type": "pic_sysphoto", 
		                    "name": "系统拍照发图", 
		                    "key": "rselfmenu_1_0"
		                   
		                 }, 
		                {
		                    "type": "pic_photo_or_album", 
		                    "name": "拍照或者相册发图", 
		                    "key": "rselfmenu_1_1"
		                }, 
		                {
		                    "type": "pic_weixin", 
		                    "name": "微信相册发图", 
		                    "key": "rselfmenu_1_2"
		                },
		                {
		                    "type": "scancode_push", 
		                    "name": "扫码推事件", 
		                    "key": "rselfmenu_1_3"
		                },
		                {
		                    "type": "scancode_waitmsg", 
		                    "name": "扫码带提示", 
		                    "key": "rselfmenu_1_4"
		                }
		            ]
		        },
		        {
		            "name": "位置跳转", 
		            "sub_button": [
		                {    
		                    "type":"location_select",
		                    "name":"发送位置",
		                    "key":"location"
		                }, 
		                {    
		                    "type":"view",
		                    "name":"百度首页",
		                    "url":"http://www.baidu.com"
		                },
		                {    
		                    "type":"view",
		                    "name":"获取用户信息",
		                    "url":"http://1.wechatwyl.applinzi.com/shouquan.html"
		                },
		                {    
		                    "type":"view",
		                    "name":"来玩啊",
							"url":"https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx31325261f851fbc6&redirect_uri=http://1.wechatwyl.applinzi.com/game.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect"
		                },
		                {    
		                    "type":"view",
		                    "name":"JSSDK",
		                    "url":"http://1.wechatwyl.applinzi.com/jssDK.html"
		                }
		            ]
		        }
   			]
		}
AAA;
       //发起网络请求, 将菜单结构发送给微信服务器
       $res = httpPost($url, $jsonMenu, true);
       echo $res;
    }
    createMenu();
	
	//上传图片的方法
	function uploadImg(){
		$token = getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$token&type=image";
		$file = "1.jpg";
		
		$data = array(
			'media'=>new CURLFile($file)
		);
		$res = httpPost($url, $data);
		echo $res;
	}
	uploadImg();
	
	//上传视频的方法
	function uploadVideo(){
		$token = getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$token&type=video";
		$file = "movie.mp4";
		
		$data = array(
			'media'=>new CURLFile($file)
		);
		$res = httpPost($url, $data);
		echo $res;
	}
	uploadVideo();
?>

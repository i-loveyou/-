$("title").text(nickName);
//图片名数组
var loadingImg =  ["img/activity_rule.png", "img/bg.jpg", "img/bg2.png", "img/close.png", "img/p1_btns_wrap.png", "img/p1_first.png", "img/p1_from.png", "img/p1_second.png", "img/p1_sub.png", "img/p1_third.png", "img/p2_kuang.png", "img/p2_qian.jpg", "img/p2_scoring.png", "img/p2_shou.png", "img/p2_txt1.png", "img/p2_txt2.png", "img/p2_txt3.png", "img/p2_zhuan.png", "img/p3_acquire.png", "img/p3_again.png", "img/p3_bg.jpg", "img/p3_share.png", "img/p3_share_btn.png", "img/prize.png", "img/qian.png", "img/ranking.png", "img/ranking_bg.png", "img/shiyong.png", "img/shizhong.png", "img/shou.png", "img/start_game.png", "img/tiaozhan.png", "img/yingqu.png"];

//预加载函数
function preload(imgArr,callback){
	var count = 0;
	for(var i = 0;i < imgArr.length;i++){
		var newImg = new Image();
		newImg.src = imgArr[i];
		newImg.onload = function(){
			count++;
			var precent = Math.floor(count / imgArr.length * 100);
			$(".progress").text(precent + "%");
			if(count == imgArr.length){
				//图片加载完毕
				callback();
			}
		}
	}
}

//预加载函数
preload(loadingImg,function(){
	//1.隐藏预加载页,显示第一页
	$(".preload").css("display","none");
	$(".page1").css("display","block");
	
	//2.给第一页添加动画效果
	$(".page1>img:first-child").addClass("animated bounceIn");
	$(".page1>img:nth-child(2)").addClass("animated wobble");
	
	$("#start").addClass("animated pulse infinite");
	$("#start+img").addClass("animated fadeOut infinite");
});
	
		
//关联数钱榜点击事件
$(".menuBar>img:first-child").tap(function(){
	$(".rank").css({
		"display":"block",
		"opacity":0
	});
	$(".rank").animate({
		"opacity":1
	},200);
	//请求数据库里分数最高的前5名数据
	$.ajax({
		type:"get",
		url:"rank.php",
		async:true,
		dataType:"json",
		success:function(data){
			console.log(data);
			$(".rank ul>li").each(function(i,v){
				$(this).find(".name").text(data[i].name);
				$(this).find(".score").text(data[i].score);
				$(this).find(".clock").prop("src",data[i].head);
			});
		}
	});
});
//关联关闭按钮事件
$(".closeBtn").tap(function(){
	$(this).parent().parent().animate({
		"opacity":0
	},200,function(){
		$(this).css("display","none");
	});
});
	
//给开始游戏按钮关联点击事件
$("#start").tap(function(){
	$(".page1").css("display","none");
	$(".page2").css("display","block");
	//开始游戏函数
	startGame();
});

	
//阻止系统的默认滑动事件
document.querySelector(".wrap").ontouchmove = function(e){
	var even = e || event;
	even.preventDefault();
	return false;
}

//声明一个变量存储总分数
var score = 0;

function startGame(){
	$(".shou").addClass("animated fadeOutUp infinite");
	
	//更换图片的函数
	changeImage();
	//倒计时函数
	countDown();
	//游戏区域向上滑动效果
	$(".moneyRoom").swipeUp(function(){
		score++;
		//分别获取score数值的百位,十位,个位上的数
		var ge = score % 10;
		var shi = Math.floor(score % 100 /10);
		var bai = Math.floor(score / 100);
		var sArr = [bai,shi,ge];
		$(".count").each(function(i,v){
			$(v).text(sArr[i]);
		});
		var newImg = $("<img />").prop("src","img/p2_qian.jpg").addClass("mFly").appendTo($(".moneyRoom"));
		setTimeout(function(){
			newImg.remove();
		},1000);
	});
};

//记录是第几张图片
var index = 1;
//延缓换图的频率
var flag = 0;
//换图函数
function changeImage(){
	/*
	 * 计时器的缺点:
	 * 1.间隔时间固定
	 * 2.不清除计时器,计时器会一直存在.
	 */
	
//	var index = 1;
//	setInterval(function(){
//		index++;
//		if(index > 3){
//			index = 1;
//		}
//		$(".message>img").prop("src","img/p2_txt"+index+".png");
//	},500);
	
	//延缓换图的频率
	flag++;
	if(flag == 80){
		//换图
		flag = 0;
		index++;
		if(index>3){
			index = 1;
		}
		$(".message>img").prop("src","img/p2_txt"+index+".png");
	}
	requestAnimationFrame(changeImage);
}

//倒计时函数
var timer;
var totalTime = 20;
function countDown(){
	timer = setInterval(function(){
		totalTime--;
		$(".time").text(totalTime);
		if(totalTime < 0){
			clearInterval(timer);
			//发起网络请求,将本次的成绩存储数据库
			$.ajax({
				type:"get",
				url:"uploadScore.php",
				async:true,
				data:{
					id:openId,
					head:headUrl,
					name:nickName,
					score:score
				},
				success:function(data){
					//发起网络请求,请求本人的排名和最好成绩
					$.ajax({
						type:"get",
						url:"getBest.php",
						async:true,
						data:{id:openId},
						dataType:"json",
						success:function(data){
							$("#score").text("¥" + data.score);
							$("#best").text("我的辉煌战绩:" + data.best + "排名:" + data.rank + "位");
						}
					});
				}
			});
			
			
			$(".page2").css("display","none");
			$(".page3").css("display","block");
			//发起网络请求,请求本人的排名和最好的成绩
			
		}
	},1000);
}

$("#again").tap(function(){
	//刷新页面
	window.location.reload();
})

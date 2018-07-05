var showDiv = document.getElementsByClassName("slide-show")[0];
var conDiv = document.getElementsByClassName("slide-con")[0];

var dots = document.getElementsByClassName("pagenation")[0].getElementsByTagName("span");

var prevBtn = document.getElementById("slide-prev");
var nextBtn = document.getElementById("slide-next");

//定义一个变量：记录当前图片的下标
var index = 0;

//自动播放功能
function autoplay(){
	//判断 当切换到最后一张是 重置为第一张
	if(index == 5){
		index = 0;
		conDiv.style.left = "0";
	}
	index++;
	//切换图片到下一张
	play();
	//修改分页器点的位置
	switchDot();
}
//开启自动轮播
var t = setInterval(autoplay,3000);

//鼠标移入时 暂停播放
showDiv.onmouseover = function(){
	clearInterval(t);
}
//鼠标移出时  继续开始播放
showDiv.onmouseout = function(){
	t = setInterval(autoplay,3000);
}

//下一张按钮切换
nextBtn.onclick = autoplay;
//上一张按钮切换
prevBtn.onclick = function(){
	if(index == 0){
		index = 5;
		conDiv.style.left = -520*index + "px";
	}
	index --;
	play();
	switchDot();
}

//点击分页器实现切换
for(var i=0;i<dots.length;i++){
	dots[i].biao = i;
	dots[i].onclick = function(){
		index = this.biao;
		play();
		switchDot();
	}
}

//切换图片
var timer;
function play(){
	var t = 0;
	var b = conDiv.offsetLeft;
	var c = -520*index - b;	//-520也行，注意点击上一张按钮时的问题;每次切换自己一张图片
	var d = 10;
	
	//先清除上一次的计时器，避免用于短时间频繁点击切换时的问题
	clearInterval(timer);
	var timer =	setInterval(function(){
		t++;
		if(t == d){
			clearInterval(timer);
		}
		conDiv.style.left = Tween.Quad.easeOut(t,b,c,d) + "px";
	},30)
}
//更改分页器的位置
function switchDot(){
	for(var i = 0;i<dots.length;i++){
		dots[i].className = "";
	}
//	dots[index].className = "cur";

	//特殊处理
	if(index == 5){		//此时显示的是最后一张后面多添加的第一张，此时对于分页器第一个点
		dots[0].className = "cur";
	}else{
		//让对应第index个点处于活跃状态
		dots[index].className = "cur";
	}
}

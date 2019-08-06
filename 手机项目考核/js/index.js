$('.wrap_inner').fullpage({
	change:function(){
		var i = $.fn.fullpage.getCurIndex();
		if(i == 1){
			$("#zi1").addClass("slideInLeft animated");
			$("#zi2").addClass("slideInRight animated");
		}
		if(i == 3){
			$(".page4 span:nth-child(1)").addClass("slideInLeft animated");
			$(".page4 span:nth-child(2)").addClass("slideInLeft animated");
			$(".img4 img:nth-child(1)").addClass("zoomIn animated");
			$(".img4 img:nth-child(2)").addClass("zoomIn animated");
			$(".img4 img:nth-child(3)").addClass("zoomIn animated");
			$(".img4 img:nth-child(4)").addClass("zoomIn animated");
			$(".img4 img:nth-child(5)").addClass("zoomIn animated");
			$(".img4 img:nth-child(6)").addClass("zoomIn animated");
			$(".img4 img:nth-child(7)").addClass("zoomIn animated");
			$(".img4 img:nth-child(8)").addClass("zoomIn animated");
			$(".img4 img:nth-child(9)").addClass("zoomIn animated");
			$(".img4 img:nth-child(10)").addClass("zoomIn animated");
		}
	}
});



//page1	
function star(){
	var star1 = $(".star1");
	var star2 = $(".star2");
	var star3 = $(".star3");
	
	left1 = star1.position().left;
	top1 = star1.position().top;
	left2 = star2.position().left;
	top2 = star2.position().top;
	left3 = star3.position().left;
	top3 = star3.position().top;
	
	if(left1>400){
		left1 = -150;
		top1 = 300;
	}
	if(left2<-100){
		left2 = 450;
		top2 = 300;
	}
	if(left3<-100){
		left3 = 450;
		top3 = 300;
	}
	
	star1.css("left",left1+8+"px");
	star1.css("top",top1+6+"px");
	star2.css("left",left2-5+"px");
	star2.css("top",top2-3+"px");
	star3.css("left",left3-5+"px");
	star3.css("top",top3+3+"px");
}
setInterval(star,15);

$(".bgm img").click(function(){
	$(".bgm img").attr("src",$(".bgm img").attr("src") == "img/img/music.png"? "img/img/musicoff.png" : "img/img/music.png")
});

//page2

var n = 1;
setInterval(function(){
	n++;
	$(".earth img").removeClass("active");
	$(".earth img:nth-child("+n+")").addClass("active");
	if(n >= 47){
		n = 1;
	}
},75)

//page4
for(var n = 2;n < 10;n++){
	$(".img4 img:eq("+n+")").click(function(){
		$(".page4 span:nth-child(1)").css("display","none");
		$(".page4 span:nth-child(2)").css("display","none");
		$(".img4 img:nth-child(3)").css("display","none");
		$(".img4 img:nth-child(4)").css("display","none");
		$(".img4 img:nth-child(5)").css("display","none");
		$(".img4 img:nth-child(6)").css("display","none");
		$(".img4 img:nth-child(7)").css("display","none");
		$(".img4 img:nth-child(8)").css("display","none");
		$(".img4 img:nth-child(9)").css("display","none");
		$(".img4 img:nth-child(10)").css("display","none");
		$("#preButton").css("display","block");
		$("#netButton").css("display","block");
		$("#closePf").css("display","block");
		$(".contain").css("display","block");
		
		var index = $(this).index();
		switch (index){
			case 2:
				$(".contain").css("left",-56 + "px");
				break;
			case 3:
				$(".contain").css("left",-2856 + "px");
				break;
			case 4:
				$(".contain").css("left",-456 + "px");
				break;
			case 5:
				$(".contain").css("left",-2456 + "px");
				break;
			case 6:
				$(".contain").css("left",-856 + "px");
				break;
			case 7:
				$(".contain").css("left",-2056 + "px");
				break;
			case 8:
				$(".contain").css("left",-1256 + "px");
				break;
			case 9:
				$(".contain").css("left",-1656 + "px");
				break;
			default:
				break;
		}
		
	})
}


$("#closePf").click(function(){
	$("#preButton").css("display","none");
	$("#netButton").css("display","none");
	$("#closePf").css("display","none");
	$(".contain").css("display","none");
//	$(".contain").css("left",-56 + "px");
	$(".page4 span:nth-child(1)").css("display","block");
	$(".page4 span:nth-child(2)").css("display","block");
	$(".img4 img:nth-child(3)").css("display","block");
	$(".img4 img:nth-child(4)").css("display","block");
	$(".img4 img:nth-child(5)").css("display","block");
	$(".img4 img:nth-child(6)").css("display","block");
	$(".img4 img:nth-child(7)").css("display","block");
	$(".img4 img:nth-child(8)").css("display","block");
	$(".img4 img:nth-child(9)").css("display","block");
	$(".img4 img:nth-child(10)").css("display","block");
})

$("#preButton").click(function(){
 	var btnleft = $(".contain").offset().left;
 	if(btnleft <= -2856){
 		btnleft = -56;
 	}
 	$(".contain").css("left",btnleft - 400 + "px");
 	console.log($(".contain").offset().left);
})

$("#netButton").click(function(){
	var btnleft = $(".contain").offset().left;
	if(btnleft >= -56){
		btnleft = -2856;
	}
 	$(".contain").css("left",btnleft + 400 + "px");
 	console.log($(".contain").offset().left);
})
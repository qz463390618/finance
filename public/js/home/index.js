$(function(){
	var sliderSquare = $(".sliderSquare ul li");
	var sliderPic=$(".sliderPic ul li");
	var  sliderPicUl= $(".sliderPic ul");
	var slderWidth=sliderPic.eq(0).width();
	//用来计数
	var count=0;
	var time=null;
	sliderSquare.on('click',function(){
		$(this).addClass('active').siblings().removeClass('active');
		var index =$(this).index();
		count=index;
		sliderPicUl.animate({"left":-count*slderWidth});

	})
	time =setInterval(function(){
		count++;
		if(count>sliderSquare.length-1){
			count=0;
		}
		// trigger()触发某个事件
		sliderSquare.eq(count).trigger('click');
	},3000)
});

// 导航栏分栏翻转
$(function(){
        cases();
     function cases(){         
         $(".five").hide();   
         $(".menu_icon").hover(     
  function(){
      $(this).children(".name").hide();   
      $(this).children(".five").show();     
    },function(){

      $(this).children(".five").hide();    
      $(this).children(".name").show();

       }
        );
     }
 })
// 导航栏固定

$(function(){
	var a = $('.nav'),
		b =a.offset();
	$(document).on('scroll',function(){
		var	c = $(document).scrollTop();
		if(b.top<=c){
			a.css({'position':'fixed','top':'-10px'})
			}else{
				a.css({'position':'absolute','top':'77px'})
				}
		})
	})



// 图片按钮轮播
function Scroll(obj,speed,interval){ //父级容器，轮播速度，切换间隔
   $("."+obj).each(function(){
       var $box = $(this),
       $imgUl = $box.children(".imgList"),
       $imgLi = $imgUl.children("li"),
       $btnUl = $box.children(".btnList"),
       $btnLi = $btnUl.children("li"),
       $btnPreNex = $(".pre-nex"),
       $btnPre = $(".prev"),
       $btnNex = $(".next"),
       n = $imgLi.length,
       width = $imgLi.width(),
       left = parseFloat($imgUl.css("left")),
       k = 0,
       Player;
       $imgUl.css("width",n*width);
 function scroll(){ //轮播事件
   $imgUl.stop().animate({left:-width},speed,function(){
      k += 1;
      $imgUl.css("left",0);
      $imgUl.children("li:first").appendTo($(this));
      $btnLi.removeClass('cur');
      if(k >= n){
          k = 0;
      }
      $btnUl.children("li").eq(k).addClass('cur'); 
   });
 } 
 $btnPreNex.click(function(){ //左右按钮点击事件
   var index = $btnLi.index(this); 
       if($(this).hasClass('next')){
        if(!$imgUl.is(":animated")){
        k += 1;
        $imgUl.animate({left:-width},speed,function(){
        $imgUl.css("left",0);
        $imgUl.children("li:first").appendTo($(this));
        if(k >= n){
        k = 0;
        }
        $btnUl.children("li").removeClass('cur').eq(k).addClass('cur');
      });
    }
 }
 else {
    if(!$imgUl.is(":animated")){
      k += -1;
      $imgUl.css("left",-width);
      $imgUl.children("li:last").prependTo($imgUl);
      $imgUl.stop().animate({left:0},speed);
      if(k < 0){
      k = n-1;
      }
      $btnUl.children("li").removeClass('cur').eq(k).addClass('cur');
      }
   }
 }); 
 $box.hover(  //鼠标移入、移出事件
   function(){
      clearInterval(Player);
      $btnPreNex.addClass('show');
   },
   function(){
    Player = setInterval(function(){scroll()},interval);
    $btnPreNex.removeClass('show');
   }
 );
 Player = setInterval(function(){scroll()},interval);
 });
 } 
 $(function () {  //读取轮播事件
 Scroll("bannerCon",600,4000);
 });

//table框切换
jQuery(function(){
      var list = jQuery('#t1, #t2, #t3, #t4');
      list.click(function(){
        list.removeClass('active');
        jQuery(this).addClass('active');
        // return false;
      });
    });
//电子书

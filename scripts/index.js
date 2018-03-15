$(function(){
	   $("#skin li").click(function(){
	   	    var index=$("#skin").find("li").index(this);/*获得的值是0,1,2,34，从0开始*/
	        $(this).addClass("selected").siblings().removeClass("selected");
	        $("#skinStyle").attr("href","./css/skin/skin_"+index+".css");
	        $.cookie("MyCssSkin",index,{path:'/',expires:10});
	   })
		var cookieSkin=$.cookie("MyCssSkin");
		if (cookieSkin) {
			  $("#skin_"+cookieSkin).addClass("selected").siblings().removeClass("selected");
			  $("#skinStyle").attr("href","./css/skin/skin_"+cookieSkin+".css");
	   }
	/*input.js  输入框效果*/
	$("#my").focus(function(){
		/*有默认情况，不用再改变边框了*/
		if($(this).val()==this.defaultValue){
			$(this).val("");
		}
	}).blur(function(){
		if ($(this).val()=="") {
			$(this).val(this.defaultValue);
		}

	}).keyup(function(e){
		if (e.which==13) {
			alert("开始搜索");
		}
	})
   /*skin.js  换肤效果*/


   /*nav.js  导航效果*/
   $(".nav li").hover(function(){
   	    $(this).find(".subItem").show();
     }, function(){
    	$(this).find(".subItem").hide();
   })
   /*addhot.js热销效果*/
   $(".classification .promoted").append("<s class='hot'></s>")/*jquery添加元素*/
   /*  ad.js 大屏广告*/
   var index=0;
   var timer1=null;
   var len=$("#RsidePictureTurn div a").length;
   $("#RsidePictureTurn div a").mouseover(function(){
          index=$("#RsidePictureTurn div a").index(this);
          showImage(index);
   }).eq(0).mouseover();/*用来初始化，显示第一个。eq：a在div中的索引*/
   $("#RsidePictureTurn").hover(function(){
          if (timer1) {
          	clearInterval(timer1)
          }
	   },function(){
          timer1=setInterval(function(){
             showImage(index);
             index++;
             if (index==len) {
             	index=0;
             }
          },3000)
	   }).trigger("mouseleave");
   function showImage(num){
   	    var iNow=$("#RsidePictureTurn").find("div>a")
        var iNowHref=iNow.eq(num).attr("href");
        $("#RsidePictureTurn>a").attr("href",iNowHref).find("img").eq(num).stop(true,true).fadeIn()
        .siblings().fadeOut();
        iNow.removeClass("chos").css("opacity","0.7").eq(num).addClass("chos").css("opacity","1")
   }

  /* 超链接提示，tooltip.js*/
  var x=10;
  var y=10;
  $("#RsideBrand a").mouseover(function(e){
  	  this.myTitle=this.title;
  	  var tooltip="<div id='tooltip'>"+this.myTitle+"</div>";
  	  $("body").append(tooltip);
  	  $("#tooltip").css({
           "top":(e.pageY+y)+"px",
           "left":(e.pageX+x)+"px"
  	  }).show("fast");
  }).mousemove(function(e){
      $("#tooltip").css({
           "top":(e.pageY+y)+"px",
           "left":(e.pageX+x)+"px"
  	  })
  }).mouseout(function(){
  	 $("#tooltip").remove();

  })
  /*imgSlide.js横向滚动效果*/

  $("#jnBrandTab a").click(function(){
        $(this).parent().addClass("chos").siblings().removeClass("chos");
        var index=$("#jnBrandTab a").index(this);
        showBrandList(index);
  })
  function showBrandList(num){
      var moveLeft=$("#jnBrandList").find("li").outerWidth()+10;
      var totalMove=moveLeft*4;
      $("#jnBrandList").stop(true,false).animate({left:-totalMove*num},1000)/*不需要单位*/
  }

  /*imgHover.js 光标划过*/
  $("#jnBrandList li").each(function(index){
      var $img=$(this).find("img");
      var imgW=$img.width();
      var imgH=$img.height();
      var spanHTML='<span style="position:absolute;top:0;left:0;width:'+imgW+'px;height:'+imgH+'px;" class="imageMask"></span>';
      $(spanHTML).appendTo(this);
  })
  $("#jnBrandList").delegate(".imageMask","hover",function(){
  	  $(this).toggleClass("imageOver");
  })

})
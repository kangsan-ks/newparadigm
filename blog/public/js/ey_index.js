function page(page){		
	var f = document.search_form;
	f.page.value = page;
	f.submit();
}

$(function(){
    var nav_dep1 = $('.nav_img');
    var nav_dep2 = $('.dep2');
    var bars = $('.bars');
    var n_con = $('#nav');
    var c_con = $('#con');
    var n_width = $('#nav').width();
    var c_width = $('#con').width();
    //if($('#nav').width() == "0px")
    $(bars).click(function(){
        if(n_width == $('#nav').width()){
            $(n_con).animate({
                left:-200,
				width:-200
            },300);
			$(".nav_space").animate({
                width:-200
            },300);
            $(c_con).animate({
                width:"100%"
            },300)
        }else{
            $(c_con).animate({
                width:c_width
            },300)
            $(n_con).animate({
                left:0,
				width:200
            },300);
			$(".nav_space").animate({
                width:200
            },300);
        }
    });
    console.log(n_width);
    console.log(c_width);
    $(nav_dep2).hide();
    $(nav_dep1).click(function(){
        $(nav_dep1).not(this).removeClass('on').next().slideUp(500);
        $(this).toggleClass('on')
        $(this).next().slideToggle(500);
    });
});
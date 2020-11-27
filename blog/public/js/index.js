$(document).ready(function(){
    $('a').click(function(){
		var check_none = $(this).attr('href');
		if(check_none == '#none'){
			alert('준비중입니다.');
		}
    });
});
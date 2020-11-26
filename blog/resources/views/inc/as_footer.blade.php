</div>
</body>
</html>
<script type="text/javascript">

	$(function () {
		
		var removeData = setInterval(function(){
			//console.log($(".fr-wrapper > div > a").text());
			if($(".fr-wrapper").children().eq(0).text() == "Unlicensed copy of the Froala Editor. Use it legally by purchasing a license.") {
				//$(".fr-wrapper > div > a").text("");
				//$(".fr-wrapper").children().eq(0).remove();
				//$(".fr-wrapper").children().eq(0).css("height","0");
				//$(".fr-wrapper").children().eq(0).css("width","0");
				//$(".fr-wrapper").children().eq(0).css("z-index","-999");
				$(".fr-wrapper").children().eq(0).css('visibility','hidden');
			}
			//count++;
			//if(count >= 1000) {
			//	clearInterval(removeData);
			//	setInterval(function(){removeData}, 1000)
			//}
		}, 100);

	})

</script>
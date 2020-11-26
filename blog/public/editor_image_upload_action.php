<?php
	session_start();
	error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

	if ($_FILES["upload"]["size"] > 0 ){

		// 현재시간 추출
		$date_filedir = date("YmdHis");

		//오리지널 파일 이름.확장자
		$ext = substr(strrchr($_FILES["upload"]["name"],"."),1);
		//$ext : 확장자를 저장하는 변수
		// strrchr(): . 이후의 문자열을 return, substr(): 두 번째 문자에서 끝까지 return
		//즉 확장자만 return시킨다.
		$ext = strtolower($ext); //소문자로 바꾼다.
		//$savefilename = $date_filedir."_".str_replace(" ", "_", $_FILES["upload"]["name"]);
		$savefilename = $date_filedir."_".str_replace(" ", "_", "images.".$ext);

		//$savefilename : 날짜를 덧붙여서 파일 이름을 만든다.
		//str_replace(): 파일명에 " "공백이 있으면 "_"로 대치한다.

		$uploadpath = $_SERVER['DOCUMENT_ROOT']."/storage/app/images";//이거 안 됨.
		$uploadpath = "./storage/app/images/";
		//$uploadpath :  upload.php가 있는 폴더를 기준으로 이미지가 저장 될 폴더를 지정한다.
		//즉 upload.php가 upload 폴더 안에 있다면 upload/안에 images폴더를 만들면 된다.

		$uploadsrc = $_SERVER['HTTP_HOST']."/storage/app/images/";
		//내 호스트(즉 root 디렉토리)아래에 이미지가 저장될 "/upload/images/"가 있어야 한다.

		$http='http'.((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')?'s':'').'://';
		//$_SERVER['HTTPS']의 값이 on인지 아닌지에 따라 https:// 또는 http://가 된다.
		//CKEditor에서는 이미지를 호출할 때 url을 http(또는 https)부분부터 표기해야 한다.

		//php 파일 업로드 하는 부분
		if($ext=="jpg" or $ext=="gif" or $ext =="png"){

			if(move_uploaded_file($_FILES['upload']['tmp_name'],$uploadpath.iconv("UTF-8","EUC-KR",$savefilename))){
			//move_uploaded_file( $_FILES['upload']['tmp_name'], 저장 경로+파일명) : 업로드 파일을 저장 경로로 옮긴다.
			//iconv(기존셋, 바꿀셋, 바꿀 문자열) : 문자셋을 바꾸어준다.(호스트에 따라 한글이 안 될 수도 있다.)
				$uploadfile = $savefilename;
				//echo "<script>alert('업로드성공: ".$savefilename."');</script>;";//성공 메세지 출력.
			}//move_upload_file() if문 닫기

		}else{
			//echo "<script>alert('jpg, gif, png파일만 업로드 가능함.');</script>;";
		} //확장자확인 if문 닫기

	}else{

		exit;

	}
	
	//echo "<script> window.parent.CKEDITOR.tools.callFunction({$_GET['CKEditorFuncNum']}, '".$http.$uploadsrc."$uploadfile');</script>";

	
	$array['fileName'] = $uploadfile;
	$array['uploaded'] = 1;
	$array['url'] = "/storage/app/images/".$uploadfile;
	
	echo json_encode($array);
		
?>
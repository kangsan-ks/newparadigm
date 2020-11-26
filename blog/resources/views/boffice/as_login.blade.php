<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="/css/ey_index.css">
        <script src="https://kit.fontawesome.com/7f5faa19ba.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="/js/ey_index.js"></script>
    </head>
	<body>
		<div id="login_con">
			<div id="login_box">
				<h1><img src="/img/logo.png" style="filter: brightness(0);"></h1>
		        <form name="login_form" action="/as_admin/login_action" method="post" onsubmit="javascript:login_check();">
					{{ csrf_field() }}
		            <input type="text" name="id" placeholder="아이디" required>
		            <input type="password" name="pw" placeholder="비밀번호" required>
		            <input type="submit" value="LOGIN">
		        </form>
				<script type="text/javascript">
					function ey_login_action() {
						var form = document.login_form;
						
						if(form.id.value == "") {
							alert("아이디를 입력해주세요.");
							return false;
						}

						if(form.pw.value == "") {
							alert("비밀번호를 입력해주세요.");
							return false;
						}

					}
				</script>
		    </div>
		</div>
	</body>
</html>
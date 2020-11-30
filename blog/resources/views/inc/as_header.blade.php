@if(!session('user_id'))
	<script type="text/javascript">
		alert('로그인 해주세요.');
		location.href = '/as_admin/login';
	</script>
@endif
<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/css/ey_index.css">
        <script src="https://kit.fontawesome.com/7f5faa19ba.js" crossorigin="anonymous"></script>
        <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="/js/ey_index.js"></script>
        <script src="/js/ckeditor4/ckeditor.js"></script>
    </head>
    <body>
        <div id="container">
            <div class="nav_space"></div>
            <div id="nav">
                <div class="logo">
                    <a href="/as_admin/connect/list">
                        <img src="/img/logo.png" alt="로고" width="100%">
                    </a>
                </div>
                <div class="nav_title">
                    <span>{{session('user_id')}}</span><a href="/as_admin/logout"><i class="fas fa-sign-out-alt"></i></a>
                </div>
                <div class="nav_con">
                    @if (session('user_id') == 'admin')
                    {{-- <div class="na_title nav_img"><i class="fas fa-desktop"></i>메인페이지 설정</div>
                    <div class="na_title dep2">
                        <div class="nav_sub"><a href="/as_admin/slide/list">메인 슬라이드</a></div>
                        <div class="nav_sub"><a href="/as_admin/popup/list">팝업</a></div>
                    </div> --}}
                    <div class="na_title nav_img"><i class="fas fa-tasks"></i>사이트 관리</div>
                    <div class="na_title dep2">
                        <div class="nav_sub"><a href="/as_admin/connect/list">Connect with</a></div>
                        {{-- <div class="nav_sub"><a href="/as_admin/about/list">일정 게시판</a></div> --}}
                        <div class="nav_sub"><a href="/as_admin/gallery/list">갤러리</a></div>
                        {{-- <div class="nav_sub"><a href="/as_admin/member/list">계정 관리</a></div> --}}
                    </div>
                    @else
                    <div class="na_title nav_img"><i class="fas fa-tasks"></i>사이트 관리</div>
                    <div class="na_title dep2">
                        <div class="nav_sub"><a href="/as_admin/gallery/list">갤러리</a></div>
                        <div class="nav_sub"><a href="/as_admin/member/list">계정 관리</a></div>
                    </div>
                    @endif
                    
                </div>
            </div>
            <div id="con">
                <div class="header">
                    <div class="bars">
                        <i class="fas fa-bars"></i>
                    </div>
                    <div class="top_nav">
                        <ul>
                            <a href="/">
                                <li>
                                    <i class="fas fa-desktop"></i>홈페이지
                                </li>
                            </a>
                            <a href="#none">
                                <li>
                                    <i class="fas fa-sign-out-alt"></i><a href="/as_admin/logout">로그아웃</a>
                                </li>
                            </a>
                        </ul>
                    </div>
                </div>
                <div class="con_title">
                    <h2>
                    @if(request()->segment(2) == 'slide' || request()->segment(2) == 'popup')
                    메인페이지 설정
                    @else
                    사이트 관리
                    @endif
					</h2>
                    <div class="title_nav">
					@if(request()->segment(2) == 'gallery')
					갤러리
                    @elseif(request()->segment(2) == 'connect')
                    Connect With
                    @elseif(request()->segment(2) == 'member')
                    계정 관리
                    @elseif(request()->segment(2) == 'slide')
                    메인 슬라이드
                    @elseif(request()->segment(2) == 'popup')
                    팝업
					@endif</div>
                </div>
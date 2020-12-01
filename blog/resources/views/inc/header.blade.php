<body>
    <div id="container">
        <div id="header">
            <div class="flex_box">
                <div class="logo">
                    <a href="/"><img src="/img/logo.png" alt="로고"></a>
                </div>
                <div class="nav_wrap">
                    <ul class="nav_box">
                        <li class="nav_list">
                            <a href="/about">About</a>
                        </li>
                        <li class="nav_list">
                            <a style="cursor: pointer;">Event</a>
                            <div class="sub_nav_box">
                                <a href="/event01">Introduction &<br/>Register</a>
                                <a href="/event02">Day 1 -<br/>Healthcare</a>
                                <a href="/event03">Day 2 –<br/>
                                    Virtual Company Visit</a>
                                <a href="/event04">Day 3 –<br/>
                                    Sustainability</a>
                                <a href="/event05">Speakers</a>
                            </div>
                        </li>
                        <li class="nav_list">
                            <a href="#none">Archive</a>
                            <div class="sub_nav_box">
                                <a href="/archive01">2020 Sept Forum<br/></a>
                                <a href="#none">Presentations &<br/>Articles</a>
                            </div>
                        </li>
                        <li class="nav_list">
                            <a href="#none">Community</a>
                        </li>
                        <li class="nav_list">
                            <a href="/connect">Connect with us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function(){

                $('.nav_list').mouseenter(function(){
                    nav_item = $(this);
                    $(nav_item).addClass('on');
                });

                $('#header').mouseleave(function(){
                    $('.nav_list').removeClass('on');
                });
                
            });
        </script>
        <div id="section">
            
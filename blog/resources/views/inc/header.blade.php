<body>
    <div id="container">
        <div id="header">
            <div class="flex_box">
                <div class="logo">
                    <a href="/"><img src="/img/logo.png" alt="로고"></a>
                </div>
                <div class="nav_wrap mo_none">
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
                            <a style="cursor: pointer;">Archive</a>
                            <div class="sub_nav_box">
                                <a href="https://sustainrt.com/" target="_blank">2020 Sep. Forum<br/></a>
                                <a href="/archive01">Presentations &<br/>Articles</a>
                            </div>
                        </li>
                        <li class="nav_list">
                            <a href="#none">Community</a>
                        </li>
                        <li class="nav_list">
                            <a href="/connect">Connect With us</a>
                        </li>
                    </ul>
                </div>

                <div class="mo_block bar_3" onclick="mo_nav_bar(this)">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>
                <div class="mo_block mo_nav_bg">
                    <div class="mo_nav_box">
                        <ul>
                            <li>
                                <p><a href="/about">About</a></p>
                            </li>
                            <li>
                                <p>Event</p>
                                <div class="sub_nav_box">
                                    <a href="/event01">Introduction & Register</a>
                                    <a href="/event02">Day 1 - Healthcare</a>
                                    <a href="/event03">Day 2 – Virtual Company Visit</a>
                                    <a href="/event04">Day 3 – Sustainability</a>
                                    <a href="/event05">Speakers</a>
                                </div>
                            </li>
                            <li>
                                <p>Archive</p>
                                <div class="sub_nav_box">
                                    <a href="https://sustainrt.com/" target="_blank">2020 Sep. Forum</a>
                                    <a href="/archive01">Presentations & Articles</a>
                                </div>
                            </li>
                            <li>
                                <p><a href="/community">Community</a></p>
                            </li>
                            <li>
                                <p><a href="/connect">Connect With us</a></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function mo_nav_bar(e) {
                e.classList.toggle("change");
                $('#header .mo_nav_bg').toggle();
            }
            $(function(){

                $('#header .mo_nav_box li').click(function(){
                    $(this).next().toggleClass('on');
                    $(this).children('div').toggle();
                });

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
            
@include('inc/head')
<div id="main">
    <div class="main_banner">
        <img src="/img/main_banner01.png" alt="메인배너">
    </div>
    <div class="wwa_box">
        <img src="/img/main_img01.png" alt="">
        <h1>Who We Are</h1>
    </div>
    <div class="main_event_box">
        <h2>Event</h2>
        <div class="inner">
            <ul class="flex_box">
                <li data-aos="fade-up">
                    <a href="/event01">
                        <div class="img_box">
                            <img src="/img/main_event_img01.png" alt="">
                        </div>
                        <div class="text_box">
                            <p>Introduction &<br/>Register</p>
                        </div>
                    </a>
                </li>
                <li data-aos="fade-up" data-aos-delay="200">
                    <a href="event02">
                        <div class="img_box">
                            <img src="/img/main_event_img02.png" alt="">
                        </div>
                        <div class="text_box">
                            <p>Day1<br/>Healthcare</p>
                        </div>
                    </a>
                </li>
                <li data-aos="fade-up" data-aos-delay="400">
                    <a href="event03">
                        <div class="img_box">
                            <img src="/img/main_event_img03.png" alt="">
                        </div>
                        <div class="text_box">
                            <p>Day 2<br/>Virtual Company Visit</p>
                        </div>
                    </a>
                </li>
                <li data-aos="fade-up" data-aos-delay="600">
                    <a href="event04">
                        <div class="img_box">
                            <img src="/img/main_event_img04.png" alt="">
                        </div>
                        <div class="text_box">
                            <p>Day3<br/>Sustainability</p>
                        </div>
                    </a>
                </li>
                <li data-aos="fade-up" data-aos-delay="800">
                    <a href="#none">
                        <div class="img_box">
                            <img src="/img/main_event_img05.png" alt="">
                        </div>
                        <div class="text_box">
                            <p>Speakers</p>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="archive_box">
        <h2>Archive</h2>
        <div class="inner">
            <ul class="flex_box">
                <li data-aos="fade-right">
                    <a href="/archive01">
                        <div class="img_box">
                            <img src="/img/main_archive_img01.png" alt="">
                        </div>
                    </a>
                </li>
                <li data-aos="fade-left">
                    <a href="#none">
                        <div class="img_box">
                            <img src="/img/main_archive_img02.png" alt="">
                        </div>
                    </a>
                </li>
                </ul>
            </div>
        </a>
    </div>
    <div class="connect_box">
        <div class="flex_box">
            <div class="left">
                <div class="img_bg_box">
                    <div class="text_box">
                        <h3>COMMUNITY</h3>
                        <p>Impact & Sustainability</p>
                        <a href="#none">view more</a>
                    </div>
                </div>
            </div>
            <div class="right">
                
                <form action="connect_action" method="POST">
                    <h3>Connect With Us</h3>
                    {{ csrf_field() }}
                    <input type="hidden" name="board_type" value="connect">
                    <div class="input_line mt10">
                        <input type="text" name="company" placeholder="Company" required>
                    </div>
                    <div class="input_line">
                        <input type="text" name="writer" placeholder="Name" required>
                    </div>
                    <div class="input_line">
                        <input type="text" name="subject" placeholder="Title" required>
                    </div>
                    <div class="input_line">
                        <input type="text" name="email" placeholder="E-mail" required>
                    </div>
                    <div class="input_line">
                        <input type="text" name="contact_number" placeholder="Phone" required>
                    </div>
                    <div class="submit_box">
                        <input type="image" src="/img/submit_btn.png" alt="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('inc/footer')
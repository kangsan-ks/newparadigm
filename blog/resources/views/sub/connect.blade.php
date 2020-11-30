@include('inc/head')
<div id="sub" class="connect">
    <div class="sub_top_bg">
        <img src="/img/sub_connect_top01.png" alt="">
    </div>
    <div class="sub_sec">
        <div class="inner">
            <div class="form_outer connect_form">
                <h2>Connect With Us</h2>
                <form action="connect_action" method="POST">
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
                    <div class="submit_box flex_box">
                        <button type="submit">SUBMIT<img src="/img/submit_arrow.png" alt="이미지"></button>
                        <button type="submit">MESSAGE<img src="/img/submit_arrow.png" alt="이미지"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('inc/footer')
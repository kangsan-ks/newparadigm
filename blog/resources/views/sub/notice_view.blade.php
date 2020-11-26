@include('inc/head')
<div id="sub">
    <div class="sub_top">
        <div class="sub_title_box">
            <p>CAU FINE ART<span class="bar"></span></p>
            <h1>NOTICE</h1>
        </div>
    </div>
    <div class="sub_content_box">
        <h2 class="content_subject">공지사항</h2>
        <div class="contents">
            <div class="notice_view">
                <div class="notice_subject">
                    <h3>{{ $data->subject }}</h3>
                    <p>Date : {{ substr($data->reg_date, 0, 10) }}</p>
                </div>
                <div class="contents">
                    {!! $data->contents !!}
                </div>
            </div>
            <div class="go_list_box">
                <a href="javascript:history.go(-1);">목록</a>
            </div>
        </div>
    </div>
</div>
@include('inc/footer')
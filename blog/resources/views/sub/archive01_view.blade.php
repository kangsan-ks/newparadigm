@include('inc/head')
<div id="sub" class="archive_view archive01">
    <div class="sub_top_bg">
        <img src="/img/sub_archive_top01.png" alt="">
    </div>
    <div class="sub_sec">
        <div class="inner">
            <div class="view_title">
                <h1>{{ $data->subject }}</h1>
                <p>{{ substr($data->reg_date, 0, 10) }}</p>
            </div>
            <div class="view_content">
                <div class="img_box">
                    <img src="/storage/app/images/{{ $data->real_file_name }}" alt="">
                </div>
                {!! $data->contents !!}
            </div>
            <div class="prev_box">
                <a href="javascript:history.go(-1)">LIST</a>
            </div>
        </div>
    </div>
</div>
@include('inc/footer')
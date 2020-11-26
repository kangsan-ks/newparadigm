@include('inc/head')
<div id="sub">
    <div class="sub_top">
        <div class="sub_title_box">
            <p>CAU FINE ART<span class="bar"></span></p>
            <h1>GALLERY</h1>
        </div>
    </div>
    <div class="sub_content_box">
        <h2 class="content_subject">전시소개</h2>
        <div class="contents">
            <div class="gallery_info">
                <div class="left">
                    @if($flag != 0)
                    <img src="/storage/app/images/{{$data3->real_file_name}}" alt="">
                    @else
                    <img src="/storage/app/images/{{$data->real_file_name}}" alt="">
                    @endif
                </div>
                <div class="right">
                    <div class="subject_box">
                        <h2 class="name">{{$data->member_name}}<span>_{{$data->member_name_en}}</span></h2>
                        <p>{{$data->member_email}}</p>
                    </div>
                    <div class="text_box">
                        {!! $data->contents !!}
                    </div>
                </div>
            </div>
            <ul class="gallery_box view">
                @foreach ($data2 as $data2)
                <li>
                    <a href="/gallery_view?idx={{$data->idx}}&img_idx={{$data2->idx}}">
                        <div class="img_box">
                            <img src="/storage/app/images/{{$data2->real_file_name}}" alt="갤러리 이미지">
                        </div>
                    </a>
                </li>
                @endforeach
                
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(window).on('load', function(){
        var con_width = $('.sub_content_box').width();
        var left_width = con_width - $('.sub_content_box .left').width();
        var right_width_set = ((left_width/con_width)*100) - 5;
        $('.sub_content_box .right').css({width: right_width_set+'%'});
        //console.log(left_width/con_width);
    });
    
</script>
@include('inc/footer')
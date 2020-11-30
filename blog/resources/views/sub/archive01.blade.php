@include('inc/head')
<div id="sub" class="archive archive01">
    <div class="sub_top_bg">
        <img src="/img/sub_archive_top01.png" alt="">
    </div>
    <div class="sub_sec">
        <div class="inner">
            <ul class="gallery_list_box flex_box">
                @foreach ($data as $data)
                @if(($loop->index % 3) == 0)
                <li class="items" data-aos="fade-up" data-aos-delay="0">
                @elseif(($loop->index % 3) == 1)
                <li class="items" data-aos="fade-up" data-aos-delay="200">
                @else
                <li class="items" data-aos="fade-up" data-aos-delay="400">
                @endif
                    <a href="#none">
                        <div class="img_box">
                            <img src="/storage/app/images/{{$data->real_file_name}}" alt="아카이브 썸네일">
                        </div>
                        <div class="text_box">
                            <p>{{ $data->subject }}</p>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@include('inc/footer')
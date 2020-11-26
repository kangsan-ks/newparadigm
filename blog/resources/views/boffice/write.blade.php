@include('inc/as_header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
<div class="con_main">
    @if(request()->segment(3) == 'modify')
    <form action="/as_admin/{{ request()->segment(2) }}/write_action" name="board_write_form" method="post" enctype="multipart/form-data" @if(request()->segment(2) == 'member') onsubmit="return passcheck()" @endif>
        {{ csrf_field() }}
        <input type="hidden" name="board_idx" value="{{ request()->idx }}" />
		<input type="hidden" name="board_type" value="{{ request()->segment(2) }}" />
        <input type="hidden" name="write_type" value="{{ request()->segment(3) }}" />
        <input type="hidden" name="writer" value="{{ session('user_id') }}" />
        <input type="hidden" name="parent_idx" value="{{ session('user_idx') }}" />
        @if (request()->segment(2) != 'member')
        <div class="write_box">
            <div class="write_line">
                <div class="all_line all_line_top">
                    <div class="line_title">
                        제목
                    </div>
                    <div class="line_content">
                    <input type="text" name="subject" value="{{ $data->subject }}" />
                    </div>
                </div>
            </div>
			@if(request()->segment(2) == 'gallery')
			<div class="write_line">
                <div class="all_line">
                    <div class="line_title">
                        연도선택
                    </div>
                    <div class="line_content">
					<select name="category">
						<option value="2020"@if($data->category == '2020') selected @endif>2020</option>
						<option value="2021"@if($data->category == '2021') selected @endif>2021</option>
						<option value="2022"@if($data->category == '2022') selected @endif>2022</option>
					</select>
                    </div>
                </div>
            </div>
			@endif
            @if(request()->segment(2) != 'slide')
            <div class="write_line">
                <div class="all_line">
                    <div class="line_title" style="vertical-align: top;">
                        내용
                    </div>
                    <div class="line_content">
                    <textarea id="editor" name="contents" cols="60" rows="10" style="">{!! $data->contents !!}</textarea>
                    </div>
                </div>
            </div>
            @endif
            @if(request()->segment(2) == 'slide')
            <div class="write_line">
                <div class="all_line">
                    <div class="line_title">
                        슬라이드 이미지 PC
                    </div>
                    <div class="line_content">
                        <input type="file" name="writer_file2[]" /> <span class="set">사이즈 : [1920x1080]</span> <span><a href="/storage/app/images/{{$data->real_file_name}}" target="_blank">[이미지 보기]</a></span>
                    </div>
                </div>
            </div>
            <div class="write_line">
                <div class="all_line">
                    <div class="line_title">
                        슬라이드 이미지 MOBILE
                    </div>
                    <div class="line_content">
                        <input type="file" name="writer_file_mobile2[]" /> <span class="set">사이즈 : [1080x1080]</span> <span><a href="/storage/app/images/{{$data->real_file_name2}}" target="_blank">[이미지 보기]</a></span>
                    </div>
                </div>
            </div>
            @endif
            @if(request()->segment(2) == 'gallery')
            <span id="append_target">
                <div class="write_line">
                    <div class="all_line">
                        <div class="line_title">
                            이미지 선택
                        </div>
                        <div class="line_content">
                            <input type="file" name="writer_file2[]" /> <span class="set">사이즈 : [1:1 비율 ex) 500x500]</span>
                            <span style="cursor: pointer" class="add_file2">이미지 추가 +</span>
                        </div>
                    </div>
                </div>
            </span>
            <div class="write_line">
                <div class="all_line">
                    <div class="line_title" style="vertical-align: top">
                        이미지 정보
                    </div>
                    <div class="line_content">
                        @foreach ($data_img_info as $data_img_info)
                        
                        <span class="img_info">- 이미지 {{$data_img_info_num++}} <a href="/storage/app/images/{{ $data_img_info->real_file_name }}" target="_blank">[이미지 보기]</a> <a href="javascript: control2({{$data_img_info->idx}})" style="color: #ff0000;">[삭제]</a></span>
                        <br/>
                        
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            <div class="write_line">
                <div class="all_line all_line_bottom">
                    <div class="line_title">
                        작성자
                    </div>
                    <div class="line_content">
                        <input type="text" value="{{ $data->writer }}" readonly />
                    </div>
                </div>
            </div>
            <div class="submit_box" style="text-align:center;margin-top:10px;">
                <input type="submit" value="등록">
                <input type="reset" value="취소" onclick="history.go(-1);">
            </div>
        </div>
        @else
        <div class="write_box">
            <div class="write_line">
                <div class="all_line all_line_top">
                    <div class="line_title">
                        아이디
                    </div>
                    <div class="line_content">
                        <input type="text" name="user_id" value="{{$data2->user_id}}" readonly/>
                    </div>
                </div>
            </div>
            <div class="write_line">
                <div class="all_line">
                    <div class="line_title">
                        새 패스워드
                    </div>
                    <div class="line_content">
                        <input type="password" name="passwd_new"/>
                    </div>
                </div>
            </div>
            <div class="write_line">
                <div class="all_line">
                    <div class="line_title">
                        새 패스워드 확인
                    </div>
                    <div class="line_content">
                        <input type="password" name="passwd_new2"/>
                    </div>
                </div>
            </div>
            <div class="write_line">
                <div class="all_line">
                    <div class="line_title">
                        이름
                    </div>
                    <div class="line_content">
                        <input type="text" name="name" value="{{$data2->name}}"/>
                    </div>
                </div>
            </div>
            <div class="write_line">
                <div class="all_line">
                    <div class="line_title">
                        영문 이름
                    </div>
                    <div class="line_content">
                        <input type="text" name="name_en" value="{{$data2->name_en}}"/>
                    </div>
                </div>
            </div>
            <div class="write_line">
                <div class="all_line all_line_bottom">
                    <div class="line_title">
                        이메일
                    </div>
                    <div class="line_content">
                        <input type="text" name="email" value="{{$data2->email}}"/>
                    </div>
                </div>
            </div>
            <div class="submit_box" style="text-align:center;margin-top:10px;">
                <input type="submit" value="등록">
                <input type="reset" value="취소" onclick="history.go(-1);">
            </div>
        @endif
    </form>
    <script type="text/javascript">
        function passcheck(){
            var obj = document.board_write_form;

            if(obj.passwd_new.value != obj.passwd_new2.value){
                alert('변경하려는 패스워드가 다릅니다.')
                return false;
            }

        }

    </script>
    @else
    <form action="/as_admin/{{ request()->segment(2) }}/write_action" name="board_write_form" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="board_idx" value="{{ request()->idx }}" />
		<input type="hidden" name="board_type" value="{{ request()->segment(2) }}" />
        <input type="hidden" name="write_type" value="{{ request()->segment(3) }}" />
        <input type="hidden" name="writer" value="{{ session('user_id') }}" />
        <input type="hidden" name="parent_idx" value="{{ session('user_idx') }}" />
        @if (request()->segment(2) != 'member')
        <div class="write_box">
            <div class="write_line">
                <div class="all_line all_line_top">
                    <div class="line_title">
                        제목
                    </div>
                    <div class="line_content">
                    <input type="text" name="subject" value="" />
                    </div>
                </div>
            </div>
			@if(request()->segment(2) == 'gallery')
			<div class="write_line">
                <div class="all_line">
                    <div class="line_title">
                        연도선택
                    </div>
                    <div class="line_content">
					<select name="category">
						<option value="2020">2020</option>
						<option value="2021">2021</option>
						<option value="2022">2022</option>
					</select>
                    </div>
                </div>
            </div>
			@endif
            @if(request()->segment(2) != 'slide')
            <div class="write_line">
                <div class="all_line ">
                    <div class="line_title" style="vertical-align: top;">
                        @if(request()->segment(2) == 'gallery')
                        작품설명
                        @else
                        내용
                        @endif
                    </div>
                    <div class="line_content">
                    <textarea id="editor" name="contents" cols="60" rows="10" style=""></textarea>
                    </div>
                </div>
            </div>
            @endif
            @if(request()->segment(2) == 'slide')
            <div class="write_line">
                <div class="all_line">
                    <div class="line_title">
                        이미지 PC
                    </div>
                    <div class="line_content">
                        <input type="file" name="writer_file2[]" /> <span class="set">사이즈 : [1920x1080]</span>
                    </div>
                </div>
            </div>
            <div class="write_line">
                <div class="all_line">
                    <div class="line_title">
                        이미지 MOBILE
                    </div>
                    <div class="line_content">
                        <input type="file" name="writer_file_mobile2[]" /> <span class="set">사이즈 : [1080x1080]</span>
                    </div>
                </div>
            </div>
            @endif
            @if(request()->segment(2) == 'gallery')
            <span id="append_target">
                <div class="write_line">
                    <div class="all_line">
                        <div class="line_title">
                            이미지 선택
                        </div>
                        <div class="line_content">
                            <input type="file" name="writer_file2[]" /> <span class="set">사이즈 : [1:1 비율 ex) 500x500]</span>
                            <span style="cursor: pointer" class="add_file2">이미지 추가 +</span>
                        </div>
                    </div>
                </div>
            </span>
            @endif
            <div class="write_line">
                <div class="all_line all_line_bottom">
                    <div class="line_title">
                        작성자
                    </div>
                    <div class="line_content">
                        <input type="text" value="{{ session('user_id') }}" readonly />
                    </div>
                </div>
            </div>
            <div class="submit_box" style="text-align:center;margin-top:10px;">
                <input type="submit" value="등록">
                <input type="reset" value="취소" onclick="history.go(-1);">
            </div>
        </div>
        @else
        <div class="write_box">
            <div class="write_line">
                <div class="all_line all_line_top">
                    <div class="line_title">
                        아이디
                    </div>
                    <div class="line_content">
                        <input type="text" name="user_id" value="" readonly/>
                    </div>
                </div>
            </div>
            <div class="write_line">
                <div class="all_line">
                    <div class="line_title">
                        이름
                    </div>
                    <div class="line_content">
                        <input type="text" name="name" value=""/>
                    </div>
                </div>
            </div>
            <div class="write_line">
                <div class="all_line">
                    <div class="line_title">
                        영문 이름
                    </div>
                    <div class="line_content">
                        <input type="text" name="name_en" value=""/>
                    </div>
                </div>
            </div>
            <div class="write_line">
                <div class="all_line">
                    <div class="line_title">
                        이메일
                    </div>
                    <div class="line_content">
                        <input type="text" name="email" value=""/>
                    </div>
                </div>
            </div>
            <div class="submit_box" style="text-align:center;margin-top:10px;">
                <input type="submit" value="등록">
                <input type="reset" value="취소" onclick="history.go(-1);">
            </div>
        @endif
        
    </form>
    @endif
</div>
<script type="text/javascript">   

    function control(idx) {

        if(confirm("삭제하시겠습니까?")) {
            var formData = new FormData();
            formData.append("idx", idx);
            formData.append("table_type", "board");
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: 'post',
                url: '/as_admin/{{ request()->segment(2) }}/control',
                processData: false,
                contentType: false,
                data: formData,
                success: function(result) {
                    alert("삭제되었습니다.");
                    location.reload();
                },
                error: function(xhr, status, error) {
                    //$("#loading").hide();
                    return false;
                }
            });
        }
    }

    function control2(idx) {

        if(confirm("삭제하시겠습니까?")) {
            var formData = new FormData();
            formData.append("idx", idx);
            formData.append("table_type", "file_list");
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: 'post',
                url: '/as_admin/{{ request()->segment(2) }}/control',
                processData: false,
                contentType: false,
                data: formData,
                success: function(result) {
                    alert("삭제되었습니다.");
                    location.reload();
                },
                error: function(xhr, status, error) {
                    //$("#loading").hide();
                    return false;
                }
            });
        }
    }

    $(function(){
        CKEDITOR.replace('editor',{
            filebrowserUploadUrl: '/editor_image_upload_action.php?type=Files&CKEditorFuncNum=2',
            extraPlugins: 'image'
        });
        CKEDITOR.config.width = 1000;
        CKEDITOR.config.allowedContent = true;
    });

    var append_item = '<div class="write_line"><div class="all_line"><div class="line_title">이미지 선택</div> <div class="line_content"> <input type="file" name="writer_file2[]" /><span style="cursor: pointer" class="add_file2"> 이미지 추가 +</span></div></div></div>';
    $('.add_file2').click(function(){
        $(append_item).appendTo("#append_target")
    });

</script>
@include('inc/as_footer')
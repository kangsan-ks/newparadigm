@include('inc/as_header')
{{-- PC슬라이더 --}}
<div class="con_main">
    <form action="">
        @if(request()->segment(2) == 'gallery')
		{{-- <div class="select_outer">
			<a href="/as_admin/gallery/list?year=2020">2020</a>
			<a href="/as_admin/gallery/list?year=2021">2021</a>
			<a href="/as_admin/gallery/list?year=2022">2022</a>
		</div> --}}
        <table>
            <colgroup>
                <col width="100">
                <col width="75">
                <col width="600">
				<col width="70">
                <col width="180">
                <col width="100">
                <col width="180">
            </colgroup>
            <thead>
                <tr>
                    <th>번호</th>
                    <th>이미지</th>
                    <th>제목</th>
					<th>연도</th>
					<th>우선순위</th>
                    <th>등록일</th>
                    <th>기능</th>
                </tr>
            </thead>
            <tbody>
                @if ($totalCount == 0)
                    <tr>
                        <td colspan="7">게시글이 없습니다.</td>
                    </tr>
                @else
                    @foreach ($data as $data)
                    <tr>
                        <td>{{ $number-- }}</td>
                        <td><img width="75" height="75" src="/storage/app/images/{{ $data->real_file_name }}" alt=""></td>
                        <td>{{ $data->subject }}</td>
                        <td>{{ $data->category }}</td>
                        <td>
                            <span class="list_arrow first" style="cursor: pointer;" onclick="javascript:location.href='/as_admin/priority_change?status=2up&board_idx={{ $data->idx }}&board_type={{ request()->segment(2) }}';"><i style="color: #555" class="fas fa-arrow-up"></i></span>
                            <span class="list_arrow second" style="cursor: pointer;" onclick="javascript:location.href='/as_admin/priority_change?status=up&board_idx={{ $data->idx }}&board_type={{ request()->segment(2) }}';"><i style="color: #ddd" class="fas fa-arrow-up"></i></span>
                            <span class="list_arrow third" style="cursor: pointer;" onclick="javascript:location.href='/as_admin/priority_change?status=down&board_idx={{ $data->idx }}&board_type={{ request()->segment(2) }}';"><i style="color: #ddd" class="fas fa-arrow-down"></i></span>
                            <span class="list_arrow four" style="cursor: pointer;" onclick="javascript:location.href='/as_admin/priority_change?status=2down&board_idx={{ $data->idx }}&board_type={{ request()->segment(2) }}';"><i style="color: #555" class="fas fa-arrow-down"></i></span>
                        </td>
                        <td>{{ substr($data->reg_date, 0, 10) }}</td>
                        <td class="delete_box"><a href="javascript: control({{$data->idx}})">삭제</a><a href="/as_admin/{{ request()->segment(2) }}/modify?idx={{ $data->idx }}" style="background-color: #08AEEA; border:1px solid #0faeea; color: #fff;">수정</a></td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @elseif(request()->segment(2) == 'notice' || request()->segment(2) == 'connect')
        <table>
            <colgroup>
                <col width="100">
                <col width="700">
                <col width="250">
                <col width="180">
            </colgroup>
            <thead>
                <tr>
                    <th>번호</th>
                    <th>제목</th>
                    <th>등록일</th>
                    <th>기능</th>
                </tr>
            </thead>
            <tbody>
                @if ($totalCount == 0)
                    <tr>
                        <td colspan="4">게시글이 없습니다.</td>
                    </tr>
                @else
                    @foreach ($data as $data)
                    <tr>
                        <td>{{ $number-- }}</td>
                        <td>{{ $data->subject }}</td>
                        <td>{{ substr($data->reg_date, 0, 10) }}</td>
                        <td class="delete_box"><a href="javascript: control({{$data->idx}})">삭제</a><a href="/as_admin/{{ request()->segment(2) }}/modify?idx={{ $data->idx }}" style="background-color: #08AEEA; border:1px solid #0faeea; color: #fff;">수정</a></td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @elseif(request()->segment(2) == 'member')
        <table>
            <colgroup>
                <col width="100">
                <col width="520">
                <col width="150">
                <col width="250">
                <col width="180">
            </colgroup>
            <thead>
                <tr>
                    <th>번호</th>
                    <th>아이디</th>
                    <th>이름</th>
                    <th>이메일</th>
                    <th>기능</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $data)
                <tr>
                    <td>{{ $number-- }}</td>
                    <td>{{ $data->user_id }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->email }}</td>
                    <td class="delete_box"><a href="javascript: control({{$data->idx}})">삭제</a><a href="/as_admin/{{ request()->segment(2) }}/modify?idx={{ $data->idx }}" style="background-color: #08AEEA; border:1px solid #0faeea; color: #fff;">수정</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @elseif(request()->segment(2) == 'slide')
        <table>
            <colgroup>
                <col width="100">
                <col width="75">
                <col width="600">
                <col width="200">
                <col width="180">
            </colgroup>
            <thead>
                <tr>
                    <th>번호</th>
                    <th>이미지</th>
                    <th>제목</th>
                    <th>등록일</th>
                    <th>기능</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $data)
                <tr>
                    <td>{{$number--}}</td>
                    <td><img width="75" height="75" src="/storage/app/images/{{$data->real_file_name}}" alt=""></td>
                    <td>{{$data->subject}}</td>
                    <td>{{substr($data->reg_date, 0, 10)}}</td>
                    <td class="delete_box"><a href="javascript: control({{$data->idx}})">삭제</a><a href="/as_admin/{{ request()->segment(2) }}/modify?idx={{ $data->idx }}" style="background-color: #08AEEA; border:1px solid #0faeea; color: #fff;">수정</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @elseif(request()->segment(2) == 'popup')
        <table>
            <colgroup>
                <col width="100">
                <col width="75">
                <col width="750">
                <col width="100">
                <col width="180">
            </colgroup>
            <thead>
                <tr>
                    <th>번호</th>
                    <th>이미지</th>
                    <th>등록일</th>
                    <th>사용여부</th>
                    <th>기능</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>5</td>
                    <td class="delete_box"><a href="javascript: control({{$data->idx}})">삭제</a><a href="/as_admin/{{ request()->segment(2) }}/modify" style="background-color: #08AEEA; border:1px solid #0faeea; color: #fff;">수정</a></td>
                </tr>
            </tbody>
        </table>
        @endif
        <div class="paging">
			{!! $paging_view !!}
        </div>
        @if (request()->segment(2) != 'member')
        <div class="create" style="padding-bottom:10px;">
			<a href="/as_admin/{{ request()->segment(2) }}/write">등록</a>
            <!-- <a href="/ey_write_gallery">등록</a> -->
        </div>
        @endif
        
    </form>
</div>
<form name="search_form" action="{{ $_SERVER['REQUEST_URI'] }}" class="board_search_con" onsubmit="return search();">
    <input type="hidden" name="page" />
    <button></button>
</form>
<script>
    function control(idx) {

        if(confirm("삭제하시겠습니까?")) {
            var formData = new FormData();
            formData.append("idx", idx);
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
</script>
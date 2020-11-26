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
            <div class="table_box notice">
                <table>
                    <caption class="blind">공지사항</caption>
                    <colgroup>
                        <col width="10%">
                        <col width="*">
                        <col width="150px">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($totalCount == 0)
                            <tr>
                                <td colspan="3">게시글이 없습니다.</td>
                            </tr>
                        @else
                            @foreach ($data as $data)
                            <tr>
                                <td>{{ $number-- }}</td>
                                <td class="text-left">
                                    <a href="/notice_view?idx={{$data->idx}}">
                                        {{ $data->subject }}
                                    </a>
                                </td>
                                <td>{{ substr($data->reg_date, 0, 10) }}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('inc/footer')
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Classes\CommonFunction;
use App\Classes\PagingFunction;
use App\Admin;
use App\User;
use Auth;
use DB;
use App\Classes\jsonRPCClient;

class Front extends Controller

{
    
    public function main(Request $request) {

        $notice = DB::table('board') 
                    ->select(DB::raw('*'))
                    ->where('board_type', 'notice')
                    ->limit(2)
					->get();
		$slide = DB::table('board') 
                    ->select(DB::raw('*'))
                    ->where('board_type', 'slide')
                    ->get();					
        $gallery = DB::table('board')
                    ->select(DB::raw('*, (SELECT real_file_name FROM file_list WHERE parent_idx = board.idx LIMIT 1) AS real_file_name, (SELECT name FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_name, (SELECT name_en FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_name_en, (SELECT email FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_email'))
                    ->where('board_type', 'gallery')
                    ->orderBy('prino', 'desc')
                    ->get();


        $return_list["slide"] = $slide;
        $return_list["gallery"] = $gallery;
        $return_list['notice'] = $notice;

		return view('index', $return_list);

    }

    public function about(Request $request) {

        $return_list = array();

		return view('sub/about', $return_list);

    }

    public function event(Request $request) {

        $return_list = array();

        $url = request()->segment(1);

		return view('sub/'.$url, $return_list);

    }

    public function archive_list(Request $request) {

        $list = DB::table('board')
                    ->select(DB::raw('*, (SELECT real_file_name FROM file_list WHERE parent_idx = board.idx LIMIT 1) AS real_file_name, (SELECT name FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_name, (SELECT name_en FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_name_en, (SELECT email FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_email'))
                    ->where('category', $request->year)
                    ->where('board_type', 'gallery')
                    ->orderBy('prino', 'desc')
                    ->get();

		$list_cnt = DB::table('board')
                    ->select(DB::raw('*, (SELECT real_file_name FROM file_list WHERE parent_idx = board.idx LIMIT 1) AS real_file_name, (SELECT name FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_name, (SELECT name_en FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_name_en, (SELECT email FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_email'))
                    ->where('category', $request->year)
					->where('board_type', 'gallery')
                    ->get()->count();

        $return_list["data"] = $list;
		$return_list["list_cnt"] = $list_cnt;

		return view('sub/archive01', $return_list);

    }

    public function archive01(Request $request) {

        $list = DB::table('board')
                    ->select(DB::raw('*, (SELECT real_file_name FROM file_list WHERE parent_idx = board.idx LIMIT 1) AS real_file_name, (SELECT name FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_name, (SELECT name_en FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_name_en, (SELECT email FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_email'))
                    ->where('board_type', 'gallery')
                    ->orderBy('prino', 'desc')
                    ->get();

		$list_cnt = DB::table('board')
                    ->select(DB::raw('*, (SELECT real_file_name FROM file_list WHERE parent_idx = board.idx LIMIT 1) AS real_file_name, (SELECT name FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_name, (SELECT name_en FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_name_en, (SELECT email FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_email'))
					->where('board_type', 'gallery')
                    ->get()->count();

        $return_list["data"] = $list;
		$return_list["list_cnt"] = $list_cnt;

		return view('sub/archive01', $return_list);

    }

    public function gallery_view(Request $request) {

        $list = DB::table('board')
                    ->select(DB::raw('*, (SELECT real_file_name FROM file_list WHERE parent_idx = board.idx LIMIT 1) AS real_file_name, (SELECT name FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_name, (SELECT name_en FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_name_en, (SELECT email FROM admin_member WHERE idx = board.parent_idx LIMIT 1) AS member_email'))
                    ->where('idx', $request->idx)
                    ->first();

        $list2 = DB::table('file_list')
                    ->select(DB::raw('*'))
                    ->where('parent_idx', $request->idx)
                    ->get();

        if($request->img_idx != null){
            $list3 = DB::table('file_list')
                        ->select(DB::raw('*'))
                        ->where('parent_idx', $request->idx)
                        ->where('idx', $request->img_idx)
                        ->first();
            $return_list["data3"] = $list3;
            $flag = 1;
        }else{
            $flag = 0;
        }
        $return_list["data"] = $list;
        $return_list["data2"] = $list2;
        $return_list["flag"] = $flag;
        

		return view('sub/gallery_view', $return_list);

    }

    public function notice(Request $request) {

        $boardType = request()->segment(1);

		if($boardType == 'member'){
			$boardType = 'admin_member';
		}

		$paging_option = array(
			"pageSize" => 10,
			"blockSize" => 5
		);

		$thisPage = ($request->page) ? $request->page : 1 ;
		$paging = new PagingFunction($paging_option);


        $totalQuery = DB::table('board');	
        $totalQuery->where('board_type', $boardType);

        $totalCount = $totalQuery->get()->count();
        
        $paging_view = $paging->paging($totalCount, $thisPage, "page");
		

        $query = DB::table('board')
        ->select(DB::raw('*'))
        ->where('board_type', 'notice')
        ->orderBy('idx', 'desc');
        // $query->where(function($query_set2) {
        //         $query_set2->where('top_type', 'Y')
        //         ->orWhere('top_type', null);
        // });
		
		//$query->where('top_type', '<>', 'Y');
		//$query->orWhere('top_type', null);
		
		// if($request->category_type) {
		// 	$query->where('category', $request->category_type);
		// }

		// if(request()->segment(2) == "ey_data_room" && !$request->category_type) {
		// 	$query->where('category', 1);
		// }

		if($request->page != "" && $request->page > 1) {
			$query->skip(($request->page - 1) * $paging_option["pageSize"]);
		}

		$list = $query->take($paging_option["pageSize"])->get();
		
		// 게시판 출력 글 번호 계산
		$number = $totalCount-($paging_option["pageSize"]*($thisPage-1));

		$board_top_count = DB::table('board') 
					->select(DB::raw('*'))
					->where('board_type', $boardType)
					->where('top_type', 'Y')
					->get()->count();

		$board_top_list = DB::table('board') 
					->select(DB::raw('*, substr(reg_date, 1, 10) as reg_date_cut'))
					->where('board_type', $boardType)
					->where('top_type', 'Y')
					->get();

		$return_list = array();
		$return_list["board_top_count"] = $board_top_count;
		$return_list["board_top_list"] = $board_top_list;
		$return_list["data"] = $list;
		$return_list["data2"] = $list;
		$return_list["number"] = $number;
		$return_list["key"] = $request->key;
		$return_list["totalCount"] = $totalCount;
		$return_list["paging_view"] = $paging_view;
		$return_list["page"] = $thisPage;
		$return_list["key"] = $request->key;

		return view('sub/notice', $return_list);

    }

    public function notice_view(Request $request) {

        $list = DB::table('board')
                    ->select(DB::raw('*'))
                    ->where('idx', $request->idx)
                    ->first();

        $return_list["data"] = $list;

		return view('sub/notice_view', $return_list);

    }

    public function about_list(Request $request) {

        $boardType = request()->segment(1);

		if($boardType == 'member'){
			$boardType = 'admin_member';
        }
        
        if($boardType == 'about_list'){
			$boardType = 'about';
        }
        

		$paging_option = array(
			"pageSize" => 10,
			"blockSize" => 5
		);

		$thisPage = ($request->page) ? $request->page : 1 ;
		$paging = new PagingFunction($paging_option);


        $totalQuery = DB::table('board');	
        $totalQuery->where('board_type', $boardType);

        $totalCount = $totalQuery->get()->count();
        
        $paging_view = $paging->paging($totalCount, $thisPage, "page");
		

        $query = DB::table('board')
        ->select(DB::raw('*'))
        ->where('board_type', 'about')
        ->orderBy('idx', 'desc');
        // $query->where(function($query_set2) {
        //         $query_set2->where('top_type', 'Y')
        //         ->orWhere('top_type', null);
        // });
		
		//$query->where('top_type', '<>', 'Y');
		//$query->orWhere('top_type', null);
		
		// if($request->category_type) {
		// 	$query->where('category', $request->category_type);
		// }

		// if(request()->segment(2) == "ey_data_room" && !$request->category_type) {
		// 	$query->where('category', 1);
		// }

		if($request->page != "" && $request->page > 1) {
			$query->skip(($request->page - 1) * $paging_option["pageSize"]);
		}

		$list = $query->take($paging_option["pageSize"])->get();
		
		// 게시판 출력 글 번호 계산
		$number = $totalCount-($paging_option["pageSize"]*($thisPage-1));

		$board_top_count = DB::table('board') 
					->select(DB::raw('*'))
					->where('board_type', $boardType)
					->where('top_type', 'Y')
					->get()->count();

		$board_top_list = DB::table('board') 
					->select(DB::raw('*, substr(reg_date, 1, 10) as reg_date_cut'))
					->where('board_type', $boardType)
					->where('top_type', 'Y')
					->get();

		$return_list = array();
		$return_list["board_top_count"] = $board_top_count;
		$return_list["board_top_list"] = $board_top_list;
		$return_list["data"] = $list;
		$return_list["data2"] = $list;
		$return_list["number"] = $number;
		$return_list["key"] = $request->key;
		$return_list["totalCount"] = $totalCount;
		$return_list["paging_view"] = $paging_view;
		$return_list["page"] = $thisPage;
		$return_list["key"] = $request->key;

		return view('sub/about_list', $return_list);

    }

    public function connect(Request $request) {

		return view('sub/connect');

    }

    public function connect_action(Request $request) {

		DB::table('board')->insert(
            [
                'subject' => $request->subject,
                'company' => $request->company,
                'email' => $request->email,
                'writer' => $request->writer,
                'contact_number' => $request->contact_number,
                'ip_addr' => request()->ip(),
                'board_type' => $request->board_type,
                'reg_date' => \Carbon\Carbon::now(),
            ]
        );

        echo '<script>alert("접수가 완료됐습니다. 감사합니다.");</script>';

        return view('/');

    }

}
?>
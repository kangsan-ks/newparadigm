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

class Back extends Controller

{

	public function file_upload(Request $request) {

		if($request->upfiles) {
			$file = $request->upfiles->store('images');
			$file_array = explode("/", $file);
			copy("../storage/app/images/".$file_array[1], "./sample/editor/html/popular/".$file_array[1]);
		} else {
			$file_array[1] = null;
		}

		$response = new \StdClass;
		//$response->link = Director::absoluteBaseURL() . "" . $file->Filename;
		$response->link = "/sample/editor/html/popular/" . $file_array[1];
		echo stripslashes(json_encode($response));
	}

    public function as_login(Request $request) {

		return view('/boffice/as_login'); 

    }

    public function priority_change(Request $request) {
		
		//echo $request->status;

        $pri_list = Array();

        $priority_list_this = DB::table('board') 
                        ->select(DB::raw('prino'))
                        ->where('board_type',$request->board_type)
                        ->where('idx',$request->board_idx)
                        ->orderBy('prino','asc')
                        ->orderBy('reg_date','asc')
                        ->first();

        $priority_this = $priority_list_this->prino;

        echo $priority_this.'<br/>';

        $priority_list_up2 = DB::table('board') 
                        ->select(DB::raw('max(prino) as max_pri'))
                        ->where('board_type',$request->board_type)
                        ->where('prino','>', $priority_this)
                        ->orderBy('prino','asc')
                        ->orderBy('reg_date','asc')
                        ->first();

        $priority_list_up1 = DB::table('board') 
                        ->select(DB::raw('prino'))
                        ->where('board_type',$request->board_type)
                        ->where('prino','>=', $priority_this)
                        ->orderBy('prino','asc')
                        ->orderBy('reg_date','asc')
                        ->first();


        // $priority_list_down1_cnt = DB::table('board') 
        //                 ->select(DB::raw('prino'))
        //                 ->where('board_type',$request->board_type)
        //                 ->where('prino','<=', $priority_this)
        //                 ->orderBy('prino','desc')
        //                 ->orderBy('reg_date','asc')
        //                 ->get()
        //                 ->count();

        $priority_list_down1 = DB::table('board') 
                        ->select(DB::raw('prino'))
                        ->where('board_type',$request->board_type)
                        ->where('prino','<=', $priority_this)
                        ->orderBy('prino','desc')
                        ->orderBy('reg_date','asc')
                        ->first();


        

        $priority_list_down2 = DB::table('board') 
                        ->select(DB::raw('min(prino) as min_pri'))
                        ->where('board_type',$request->board_type)
                        // ->where('prino','>', $priority_this)
                        ->orderBy('prino','asc')
                        ->orderBy('reg_date','asc')
                        ->first();

        $priority_up2_num = $priority_list_up2->max_pri+1;
        $priority_up1_num = $priority_list_up1->prino+1;
        $priority_down1_num = $priority_list_down1->prino-1;
        $priority_down2_num = $priority_list_down2->min_pri-1;

		if($request->status == "2up") {
		
			$priority_infom = DB::table('board') 
						->select(DB::raw('prino'))
						->where('idx', $request->board_idx)
						->first();

			DB::table('board')->where('idx', $request->board_idx)->update(
				[
					'prino' => $priority_up2_num,
				]
			);
		
		}

		if($request->status == "up") {
		
			$priority_infom = DB::table('board') 
						->select(DB::raw('prino'))
						->where('idx', $request->board_idx)
						->first();

			DB::table('board')->where('idx', $request->board_idx)->update(
				[
					'prino' => $priority_up1_num,
				]
			);
		
		}

		if($request->status == "2down") {
		
			$priority_infom = DB::table('board') 
						->select(DB::raw('prino'))
						->where('idx', $request->board_idx)
						->first();

			DB::table('board')->where('idx', $request->board_idx)->update(
				[
					'prino' => $priority_down2_num,
				]
			);
		
		}

		if($request->status == "down") {
		
			$priority_infom = DB::table('board') 
						->select(DB::raw('prino'))
						->where('idx', $request->board_idx)
						->first();

			DB::table('board')->where('idx', $request->board_idx)->update(
				[
					'prino' => $priority_down1_num,
				]
			);
		
		}

		echo "<script>alert('노출순위 수정이 완료되었습니다.');location.href = '/as_admin/".$request->board_type."/list';</script>";
		exit;

    }
    
    public function as_login_action(Request $request) {
		
		$member_infom_count = DB::table('admin_member') 
				->select(DB::raw('*'))
				->where('user_id', $request->id)
				->get()->count();
		
		if($member_infom_count > 0) {
			
			$member_infom = DB::table('admin_member') 
					->select(DB::raw('*'))
					->where('user_id', $request->id)
					->first();

			if (Hash::check($request->pw, $member_infom->passwd)) {

				session(['user_id' => $member_infom->user_id]);
				session(['user_idx' => $member_infom->idx]);

				echo "<script>alert('로그인되었습니다.');location.href='/as_admin/connect/list';</script>";

			} else {
				echo "<script>alert('비밀번호가 잘못되었습니다.');location.href='/as_admin/login';</script>";

			}
			
		} else {
			echo "<script>alert('등록되어 있지 않은 아이디입니다.');location.href='/as_admin/login';</script>";

		}
		
    }
    
    public function as_logout(Request $request) {
		$request->session()->flush();
		echo "<script>alert('로그아웃 되었습니다.');location.href='/as_admin/login';</script>";
		exit;
	}

	public function main_set(Request $request) {

		$main_data_inform = DB::table('main_data_control') 
                    ->select(DB::raw('*'))
                    ->where('lang', 'kr')
                    ->first();

        $return_list['data'] = $main_data_inform;
		return view("/boffice/main_set", $return_list);
    }

    public function change_main_set(Request $request) {

        DB::table('main_data_control')
        ->where('lang', 'kr')
        ->update(    
            [
                'video_link1' => $request->video_link1,
                'video_link2' => $request->video_link2,
                'video_link3' => $request->video_link3,
                'video_link4' => $request->video_link4,
                
            ]
        );

    	echo "<script>alert('수정됐습니다.');location.href='/as_admin/main_set';</script>";
    	exit;
	}

	public function delete_action(Request $request) {

        if($request->table_type){
            DB::table($request->table_type)
            ->where('idx', $request->idx)
            ->delete();
            exit;
        }elseif(request()->segment(2) == 'member'){
            DB::table('admin_member')
            ->where('idx', $request->idx)
            ->delete();
            exit;
        }else{
            DB::table('board')
            ->where('idx', $request->idx)
            ->delete();
            exit;
        }
	}

	public function list(Request $request) {

		$boardType = request()->segment(2);

		$user_id = session('user_id');

		if($boardType != 'member' && $boardType != 'gallery'){
			if($user_id != 'admin'){
				echo "<script>alert('접근권한이 없습니다.');location.href='/as_admin/gallery/list';</script>";
				exit;
			}
		}

		if($boardType == 'member'){
			$boardType = 'admin_member';
		}

		$paging_option = array(
			"pageSize" => 10,
			"blockSize" => 5
		);

		$thisPage = ($request->page) ? $request->page : 1 ;
		$paging = new PagingFunction($paging_option);

		if($boardType == 'admin_member'){

			$totalQuery = DB::table('admin_member');

			if($request->category_type) {
				$totalQuery->where('category', $request->category_type);
			}

			if(request()->segment(2) == "ey_data_room" && !$request->category_type) {
				$totalQuery->where('category', 1);
			}
			if($user_id != "admin"){
				$totalQuery->where('user_id', session('user_id'));
			}
			$totalCount = $totalQuery->get()->count();
			
			$paging_view = $paging->paging($totalCount, $thisPage, "page");

		}else{

			$totalQuery = DB::table('board');	
			$totalQuery->where('board_type', $boardType);
			$totalQuery->where(function($query_set) {
					$query_set->where('top_type', 'Y')
					->orWhere('top_type', null);
            });

			if($request->year){
				$totalQuery->where('category', $request->year);
			}

			if($request->category_type) {
				$totalQuery->where('category', $request->category_type);
			}

			if(request()->segment(2) == "ey_data_room" && !$request->category_type) {
				$totalQuery->where('category', 1);
			}

			$totalCount = $totalQuery->get()->count();
			
			$paging_view = $paging->paging($totalCount, $thisPage, "page");

		}
						  
		if($request->key != "") {
			$totalQuery->where(function($totalQuery) use($request){
				$totalQuery->where('subject', 'like', '%' . $request->key . '%')
				->orWhere('contents', 'like', '%' . $request->key . '%');
			});
		}

		

		if($boardType == 'gallery'){

			$query = DB::table('board')
					->select(DB::raw('*, substr(reg_date, 1, 10) as reg_date_cut, (SELECT real_file_name FROM file_list WHERE parent_idx = board.idx LIMIT 1) AS real_file_name'));
			if($user_id != "admin"){
				$query->where('parent_idx', session('user_idx'));
			}
			if($request->year){
				$query->where('category', $request->year);
			}
			$query->orderBy('prino', 'desc');

		}elseif($boardType == 'admin_member'){

			$query = DB::table('admin_member')
				->select(DB::raw('*'));

			if($user_id != "admin"){
				$query->where('user_id', session('user_id'));
			}

			$query->orderBy('idx', 'desc');
				
				
		}else{
			$query = DB::table('board')
				->select(DB::raw('*, substr(reg_date, 1, 10) as reg_date_cut'))
				->orderBy('idx', 'desc');
		}
				
		if($request->key != "") {
			$query->where(function($query) use($request){
				$query->where('subject', 'like', '%' . $request->key . '%')
				->orWhere('contents', 'like', '%' . $request->key . '%');
			});
		}
		if($boardType != 'admin_member'){
			$query->where('board_type', $boardType);
		}
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
		
		return view("/boffice/list", $return_list);
	}

	public function write(Request $request) {

		if(request()->segment(3) == "modify") {

			$boardType = request()->segment(2);

			$list = DB::table('board')
								->select(DB::raw('*'))
								->where('board_type', $boardType)
								->where('idx', $request->idx)
								->first();
			
			$list2 = DB::table('admin_member')
						->select(DB::raw('*'))
						->where('user_id', session('user_id'))
                        ->first();
			
			if(session('user_id') != 'admin'){
				if($list2->user_id != session('user_id')){
					echo "<script>alert('접근권한이 없습니다.');location.href='/as_admin/member/list'</script>";
					exit;
				}
			}
			$data_img_info = DB::table('file_list')
							->select(DB::raw('*'))
							->where('parent_idx', $request->idx)
							->get();

			$data_img_info_num = 0;						

			$return_list["data_img_info_num"] = $data_img_info_num;
			$return_list["data_img_info"] = $data_img_info;
			$return_list["data"] = $list;
			$return_list["data2"] = $list2;

			return view("/boffice/write", $return_list);
		}else{
			return view("/boffice/write");
		}

		
	}

	public function write_action(Request $request) {

		if($request->write_type == 'modify') {

			$boardType = request()->segment(2);

			if($boardType == 'member'){

				if($request->passwd_new != ''){
					DB::table('admin_member')->where('idx', $request->board_idx)->update(
						[
							'passwd' => Hash::make($request->passwd_new),
							'name' => $request->name,
							'name_en' => $request->name_en,
							'email' => $request->email,
						]
					);
				}else{
					DB::table('admin_member')->where('idx', $request->board_idx)->update(
						[
							'name' => $request->name,
							'name_en' => $request->name_en,
							'email' => $request->email,
						]
					);
				}
				echo '<script>alert("계정 정보 수정이 완료됐습니다.");location.href="/as_admin/'.$boardType.'/list";</script>';
				exit;
			}elseif($boardType == 'slide'){

				$file = array();
				$i = 0;
				foreach($_FILES['writer_file2']['name'] as $key => $value) {

					$file['name'] = $_FILES['writer_file2']['name'][$key];
					$file['tmp_name'] = $_FILES['writer_file2']['tmp_name'][$key];
					$file['size'] = $_FILES['writer_file2']['size'][$key];

					$file2['name'] = $_FILES['writer_file_mobile2']['name'][$key];
					$file2['tmp_name'] = $_FILES['writer_file_mobile2']['tmp_name'][$key];
					$file2['size'] = $_FILES['writer_file_mobile2']['size'][$key];

					$upload_directory = './storage/app/images/';


					$ext_str = "jpg,jpeg,gif,png,JPG,JPEG,GIF,PNG";
					$allowed_extensions = explode(',', $ext_str);

					$max_file_size = 5242880000000000;
					$ext = substr($file['name'], strrpos($file['name'], '.') + 1);

					// 확장자 체크
					if(!in_array($ext, $allowed_extensions) && $file['name'] != "") {
						echo "<script>alert('업로드할 수 없는 확장자 입니다.');history.go(-1);</script>";
						exit;
					}

					// 파일 크기 체크
					if($file['size'] >= $max_file_size && $file['name'] != "") {
						echo "<script>alert('5MB 까지만 업로드 가능합니다.');history.go(-1);</script>";
						exit;
					}

					$ext2 = substr($file2['name'], strrpos($file2['name'], '.') + 1);

					// 확장자 체크
					if(!in_array($ext2, $allowed_extensions) && $file2['name'] != "") {
						echo "<script>alert('업로드할 수 없는 확장자 입니다.');history.go(-1);</script>";
						exit;
					}

					// 파일 크기 체크
					if($file2['size'] >= $max_file_size && $file2['name'] != "") {
						echo "<script>alert('5MB 까지만 업로드 가능합니다.');history.go(-1);</script>";
						exit;
					}

					$path = md5(microtime()) . '.' . $ext;
					$path2 = md5(microtime()) . '.' . $ext2;
					if(move_uploaded_file($file['tmp_name'], $upload_directory.$path) && move_uploaded_file($file2['tmp_name'], $upload_directory.$path2)) {

						$file_id = md5(uniqid(rand(), true));
						$name_orig = $file['name'];
						$name_save = $path;

					}

					$i++;

				}

				DB::table('board')->where('idx', $request->board_idx)->update(
					[
						'attach_file' => $file['name'],
						'attach_file2' => $file2['name'],
						'real_file_name' => $path,
						'real_file_name2' => $path2,
						'subject' => $request->subject,
						'contents' => $request->contents,
						'top_type' => $request->top_type,
						'use_status' => $request->use_status,
						'link_value' => $request->link_value,
					]
				);

				echo '<script>alert("게시글 수정 완료됐습니다.");location.href="/as_admin/'.$boardType.'/list";</script>';
				exit;

			}elseif($boardType == 'gallery'){

				$insert_id = $request->board_idx;

				DB::table('board')->where('idx', $request->board_idx)->update(
					[
						'subject' => $request->subject,
						'category' => $request->category,
						'contents' => $request->contents,
						'ip_addr' => request()->ip(),
						'board_type' => $request->board_type,
						'parent_idx' => $request->parent_idx,
					]
				);
				$file = array();
				$i = 0;
				foreach($_FILES['writer_file2']['name'] as $key => $value) {

					$file['name'] = $_FILES['writer_file2']['name'][$key];
					$file['tmp_name'] = $_FILES['writer_file2']['tmp_name'][$key];
					$file['size'] = $_FILES['writer_file2']['size'][$key];

					$upload_directory = './storage/app/images/';


					$ext_str = "jpg,jpeg,gif,png,JPG,JPEG,GIF,PNG";
					$allowed_extensions = explode(',', $ext_str);

					$max_file_size = 5242880000000000;
					$ext = substr($file['name'], strrpos($file['name'], '.') + 1);

					// 확장자 체크
					if(!in_array($ext, $allowed_extensions) && $file['name'] != "") {
						echo "<script>alert('업로드할 수 없는 확장자 입니다.');history.go(-1);</script>";
						exit;
					}

					// 파일 크기 체크
					if($file['size'] >= $max_file_size && $file['name'] != "") {
						echo "<script>alert('5MB 까지만 업로드 가능합니다.');history.go(-1);</script>";
						exit;
					}

					$path = md5(microtime()) . '.' . $ext;
					if(move_uploaded_file($file['tmp_name'], $upload_directory.$path)) {

						DB::table('file_list')->insert(
							[
								'file_name' => $file['name'],
								'real_file_name' => $path,
								'parent_idx' => $insert_id,
							]
						);

						$file_id = md5(uniqid(rand(), true));
						$name_orig = $file['name'];
						$name_save = $path;

					}

					$i++;

				}
				echo '<script>alert("갤러리 수정 완료됐습니다.");location.href="/as_admin/'.$boardType.'/list";</script>';
				exit;

			}else{

				DB::table('board')->where('idx', $request->board_idx)->update(
					[
						'subject' => $request->subject,
						'category' => $request->category,
						'contents' => $request->contents,
						'top_type' => $request->top_type,
						'use_status' => $request->use_status,
						'link_value' => $request->link_value,
						'writer' => $request->writer,
					]
				);

			}

			

			echo '<script>alert("게시글 작성이 완료됐습니다.");location.href="/as_admin/'.$boardType.'/list";</script>';
		}else{

			$boardType = request()->segment(2);



			

			if($boardType == 'gallery'){

				$insert_id = DB::table('board')->insertGetId(
					[
						'subject' => $request->subject,
						'category' => $request->category,
						'contents' => $request->contents,
						'writer' => $request->writer,
						'ip_addr' => request()->ip(),
						'board_type' => $request->board_type,
						'parent_idx' => $request->parent_idx,
						'reg_date' => \Carbon\Carbon::now(),
					]
				);

				
				$file = array();
				$i = 0;
				foreach($_FILES['writer_file2']['name'] as $key => $value) {

					$file['name'] = $_FILES['writer_file2']['name'][$key];
					$file['tmp_name'] = $_FILES['writer_file2']['tmp_name'][$key];
					$file['size'] = $_FILES['writer_file2']['size'][$key];

					$upload_directory = './storage/app/images/';


					$ext_str = "jpg,jpeg,gif,png,JPG,JPEG,GIF,PNG";
					$allowed_extensions = explode(',', $ext_str);

					$max_file_size = 5242880000000000;
					$ext = substr($file['name'], strrpos($file['name'], '.') + 1);

					// 확장자 체크
					if(!in_array($ext, $allowed_extensions) && $file['name'] != "") {
						echo "<script>alert('업로드할 수 없는 확장자 입니다.');history.go(-1);</script>";
						exit;
					}

					// 파일 크기 체크
					if($file['size'] >= $max_file_size && $file['name'] != "") {
						echo "<script>alert('5MB 까지만 업로드 가능합니다.');history.go(-1);</script>";
						exit;
					}

					$path = md5(microtime()) . '.' . $ext;
					if(move_uploaded_file($file['tmp_name'], $upload_directory.$path)) {

						DB::table('file_list')->insert(
							[
								'file_name' => $file['name'],
								'real_file_name' => $path,
								'parent_idx' => $insert_id,
							]
						);

						$file_id = md5(uniqid(rand(), true));
						$name_orig = $file['name'];
						$name_save = $path;

					}

					$i++;

				}
				echo '<script>alert("게시글 작성이 완료됐습니다.");location.href="/as_admin/'.$boardType.'/list";</script>';
				exit;

			}elseif($boardType == 'slide'){
				$file = array();
				$i = 0;
				foreach($_FILES['writer_file2']['name'] as $key => $value) {

					$file['name'] = $_FILES['writer_file2']['name'][$key];
					$file['tmp_name'] = $_FILES['writer_file2']['tmp_name'][$key];
					$file['size'] = $_FILES['writer_file2']['size'][$key];

					$file2['name'] = $_FILES['writer_file_mobile2']['name'][$key];
					$file2['tmp_name'] = $_FILES['writer_file_mobile2']['tmp_name'][$key];
					$file2['size'] = $_FILES['writer_file_mobile2']['size'][$key];

					$upload_directory = './storage/app/images/';


					$ext_str = "jpg,jpeg,gif,png,JPG,JPEG,GIF,PNG";
					$allowed_extensions = explode(',', $ext_str);

					$max_file_size = 5242880000000000;
					$ext = substr($file['name'], strrpos($file['name'], '.') + 1);

					// 확장자 체크
					if(!in_array($ext, $allowed_extensions) && $file['name'] != "") {
						echo "<script>alert('업로드할 수 없는 확장자 입니다.');history.go(-1);</script>";
						exit;
					}

					// 파일 크기 체크
					if($file['size'] >= $max_file_size && $file['name'] != "") {
						echo "<script>alert('5MB 까지만 업로드 가능합니다.');history.go(-1);</script>";
						exit;
					}

					$ext2 = substr($file2['name'], strrpos($file2['name'], '.') + 1);

					// 확장자 체크
					if(!in_array($ext2, $allowed_extensions) && $file2['name'] != "") {
						echo "<script>alert('업로드할 수 없는 확장자 입니다.');history.go(-1);</script>";
						exit;
					}

					// 파일 크기 체크
					if($file2['size'] >= $max_file_size && $file2['name'] != "") {
						echo "<script>alert('5MB 까지만 업로드 가능합니다.');history.go(-1);</script>";
						exit;
					}

					$path = md5(microtime()) . '.' . $ext;
					$path2 = md5(microtime()) . '.' . $ext2;
					if(move_uploaded_file($file['tmp_name'], $upload_directory.$path) && move_uploaded_file($file2['tmp_name'], $upload_directory.$path2)) {

						$file_id = md5(uniqid(rand(), true));
						$name_orig = $file['name'];
						$name_save = $path;

					}

					$i++;

				}

				DB::table('board')
				->insert(
					[
						'board_type' => $boardType,
						'attach_file' => $file['name'],
						'attach_file2' => $file2['name'],
						'real_file_name' => $path,
						'real_file_name2' => $path2,
						'subject' => $request->subject,
						'contents' => $request->contents,
						'top_type' => $request->top_type,
						'use_status' => $request->use_status,
						'link_value' => $request->link_value,
						'writer' => $request->writer,
						'reg_date' => \Carbon\Carbon::now(),
					]
				);

				echo '<script>alert("게시글 작성이 완료됐습니다.");location.href="/as_admin/'.$boardType.'/list";</script>';
				exit;
			}
			DB::table('board')
			->insert(
				[
					'board_type' => $boardType,
					'subject' => $request->subject,
					'contents' => $request->contents,
					'top_type' => $request->top_type,
					'use_status' => $request->use_status,
					'link_value' => $request->link_value,
					'writer' => $request->writer,
					'reg_date' => \Carbon\Carbon::now(),
				]
			);
			echo '<script>alert("게시글 작성이 완료됐습니다.");location.href="/as_admin/'.$boardType.'/list";</script>';
		}

		// $return_list = array();

		// return view("/boffice/write", $return_list);
	}

}
?>
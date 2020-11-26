<?php
namespace App\Classes;
use DB;

class CommonFunction
{
	public function __construct() {}
	
	function get_random_string($type = '', $len = 10) {
		$lowercase = 'abcdefghijklmnopqrstuvwxyz';
		$uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$numeric = '0123456789';
		$special = '!@#$%^&-_';
		$key = '';
		$token = '';
		if ($type == '') {
			$key = $lowercase.$uppercase.$numeric;
		} else {
			if (strpos($type,'09') > -1) $key .= $numeric;
			if (strpos($type,'az') > -1) $key .= $lowercase;
			if (strpos($type,'AZ') > -1) $key .= $uppercase;
			if (strpos($type,'$') > -1) $key .= $special;
		}
		for ($i = 0; $i < $len; $i++) {
			$token .= $key[mt_rand(0, strlen($key) - 1)];
		}
		return $token;
	}
	
	function remove_zero($val, $int) {
		$val_devide = explode(".", $val);
		$devide_length = strlen($val_devide[1]);		
		$break_point = 0;
		if($devide_length > 1) {
			
			//$m_dl = $device_length * -1;
			for($i = -1; $i >= (-$devide_length + 1); $i--) {
				if(substr($val_devide[1], $i, 1) != 0) {						
					$break_point = $i;
					break;
				}
			}				
			if($break_point == 0) {
				$break_point = (-$devide_length + $int);
			}
			if($break_point != -1) {
				$value = $val_devide[0] . "." . substr($val_devide[1], 0, ($break_point + 1));
			} else {
				$value = $val_devide[0] . "." . substr($val_devide[1], 0);
			}

			return $value;
			
		} else {
			$value = $val;
		}
		
		return $value;
	}
	
	function getBrowser() 
	{ 
		$u_agent = $_SERVER['HTTP_USER_AGENT']; 
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version= "";
	 
		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) { $platform = 'linux'; }
		elseif (preg_match('/macintosh|mac os x/i', $u_agent)) { $platform = 'mac'; }
		elseif (preg_match('/windows|win32/i', $u_agent)) { $platform = 'windows'; }
		 
		// Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) { $bname = 'Internet Explorer'; $ub = "MSIE"; }
		elseif(preg_match('/Firefox/i',$u_agent)) { $bname = 'Mozilla Firefox'; $ub = "Firefox"; } 
		elseif(preg_match('/Chrome/i',$u_agent)) { 			 
			if(preg_match('/Edge/i',$u_agent)) {
				$bname = 'Edge'; $ub = "Edge";
			} else {
				$bname = 'Google Chrome'; $ub = "Chrome";
			}
		}
		elseif(preg_match('/Safari/i',$u_agent)) { $bname = 'Apple Safari'; $ub = "Safari"; } 
		elseif(preg_match('/Opera/i',$u_agent)) { $bname = 'Opera'; $ub = "Opera"; } 
		elseif(preg_match('/Netscape/i',$u_agent)) { $bname = 'Netscape'; $ub = "Netscape"; } 
		elseif(preg_match('/Trident/i',$u_agent)) { $bname = 'Internet Explorer11'; $ub = "MSIE"; } 
		else{ $ub = "Mobile"; }
		
		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>' . join('|', $known) .
		')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}
		 
		// see how many we have
		$i = count($matches['browser']);
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){ $version= $matches['version'][0]; }
			elseif($ub == "Mobile"){$version = "0";}
			elseif($ub == "MSIE"){$version = "0";}
			else { $version= $matches['version'][1]; }
		}
		else { $version= $matches['version'][0]; }
		 
		// check if we have a number
		if ($version==null || $version=="") {$version="?";}
		return array('userAgent'=>$u_agent, 'name'=>$bname, 'version'=>$version, 'platform'=>$platform, 'pattern'=>$pattern);
	}

	function exdebug($str) {
		if ($_SERVER['REMOTE_ADDR'] == "202.136.150.103"
		|| $_SERVER['REMOTE_ADDR'] == "112.112.112.112"
		||$_SERVER['REMOTE_ADDR'] == "112.112.112.112" ||$_SERVER['REMOTE_ADDR'] == "112.112.112.112") {
				print "<xmp style=\"font:8pt 'Courier New';background:#000000;color:#00ff00;padding:10\">";
				print_r($str);
				print "</xmp>";
		}
    }

	function count_decimal($float) {
		if(gettype($float) != 'double' || $float == 0) {
			return $float;
		} else {
			if(strpos($float, '.') !== false) {
				$float = explode('.', $float);
				return mb_strlen($float[1], 'UTF-8');
			} else {
				return 0;
			}
		}
	}

	function getCurrencyInfo(){
		$currencyInfo = DB::table('currency')
							->select("*")
							->where("enable",'Y')
							->orderByRaw('id desc')
							->get();
		return $currencyInfo;
	}

	function make_file($file_path, $file_name, $file_content)
    {
        // 해당 DIR이 존재 하는지 확인
        if ( ! is_dir($file_path)) exit("파일 생성 경로가 올바르지 않습니다.");
        if ($file_name === NULL) exit("파일명이 올바르지 않습니다.");

        $real_file = $file_path . $file_name;
  
        $fp = fopen($real_file, "a+");
        fwrite($fp, $file_content . "\n");
        fclose($fp);
  
        return true;
    }
}
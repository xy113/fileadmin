<?php
if(!defined('IN_SONG')) {exit('Access Denied');}
function cutstr($string, $length, $dot = ' ...') {
	global $charset;

	if(strlen($string) <= $length) {
		return $string;
	}

	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);

	$strcut = '';
	if(strtolower($charset) == 'utf-8') {

		$n = $tn = $noc = 0;
		while($n < strlen($string)) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t <= 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}

			if($noc >= $length) {
				break;
			}

		}
		if($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		for($i = 0; $i < $length; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}

	$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

	return $strcut.$dot;
}

function daddslashes($string, $force = 0) {
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force);
			}
		} else {
			$string = addslashes($string);
		}
	}
	return $string;
}
function dexit($message = '') {
	echo $message;
	exit();
}
function writetofile($file,$data){
	if($fp = @fopen($file, 'wb')) {
		fwrite($fp,$data);
		fclose($fp);
	} else {
		exit("Can not write to file:$file.");
	}	
}
function readfromfile($file){
	if($fp = fopen($file,"r")){
		$text = @fread($fp,filesize($file));
		fclose($fp);
	}else{
	    exit("Can not read from file:$file.");
	}
	return $text;
}
function showlogin(){
	global $BASESCRIPT;
	include ROOT_PATH.'/template/login.php';
	exit();
}
function login($username,$password){
	global $_SESSION;
	//echo $username;
	//echo $password;exit();
	if (($username == USERNAME) && ($password == PASSWORD)){
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
	}
	header('location:'.$GLOBALS['BASESCRIPT']);
}
function logout(){
	unset($_SESSION['username'],$_SESSION['password']);
	header('location:'.$GLOBALS['BASESCRIPT']);
}
class removeDir{
	    private $dirnm;
	    function removeDir(){} //构造函数
	    function isEmpty($path) //判断目录是否为空
	    {
	        $handle = opendir($path);
	        $i = 0;
	        while(false !== ($file = readdir($handle)))
	            $i++;
	        closedir($handle);
	        if($i >= 2)
	            return false;
	        else
	            return true;
	    }
	 
	    function deleteDir($dirnm) //删除目录以及子目录的内容
	    {
	        $d = dir($dirnm);
	        while(false !== ($entry = $d->read()))
	        {
	            if($entry == '.' || $entry == '..')
	                continue;
	            $currele = $d->path.'/'.$entry;
	            if(is_dir($currele))
	            {
	                if($this->isEmpty($currele))
	                    @rmdir($currele);
	                else
	                    $this->deleteDir($currele);
	            }
	            else
	                @unlink($currele);
	        }
	        $d->close();
	        rmdir($dirnm);
	        return true;
	    }
}
?>
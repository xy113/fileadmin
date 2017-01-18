<?php
error_reporting(E_ALL & ~E_NOTICE);
set_magic_quotes_runtime(0);
$mtime = explode(' ', microtime());
$starttime = $mtime[1] + $mtime[0];
define('USERNAME','songdewei');
define('PASSWORD','songdewei123abc');
define('IN_SONG', TRUE);
define('ROOT_PATH','.');
define('FILE_PATH','F:/wwwroot/aaa');
define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
if(PHP_VERSION < '4.1.0') {
	$_GET = &$HTTP_GET_VARS;
	$_POST = &$HTTP_POST_VARS;
	$_COOKIE = &$HTTP_COOKIE_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
	$_ENV = &$HTTP_ENV_VARS;
	$_FILES = &$HTTP_POST_FILES;
}
unset($HTTP_COOKIE_VARS,$HTTP_ENV_VARS,$HTTP_GET_VARS,$HTTP_POST_FILES,$HTTP_POST_VARS,$HTTP_SERVER_VARS,$HTTP_SESSION_VARS);
@ini_set('session.gc_maxlifetime',600); 
@ini_set('session.auto_start',0);
@ini_set('session.cache_expire',  180);
@ini_set('session.use_trans_sid', 0);
@ini_set('session.use_cookies',   1);
@ini_set('max_execution_time',600);
@ini_set('session.save_path', 'sessions');
session_start();
include ROOT_PATH.'/function.php';
foreach(array('_POST', '_GET') as $_request) {
	foreach($$_request as $_key => $_value) {
		$_key{0} != '_' && $$_key = $_value;
	}
}
$PHP_SELF = htmlspecialchars($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
$BASESCRIPT = basename($PHP_SELF);
list($BASEFILENAME) = explode('.', $BASESCRIPT);
!$action && $action = 'list';
if ($action == 'login'){
	login($username,$password);
}elseif ($action == 'logout'){
	logout();
}elseif (!isset($_SESSION['username']) || !isset($_SESSION['password'])){
	showlogin();
}elseif ($action == 'mkdir'){
	mkdir(FILE_PATH.$curpath.'/'.$dirname);
	header('location:'.$BASESCRIPT.'?curpath='.$curpath);
	exit();
}elseif ($action == 'mkfile'){
	writetofile(FILE_PATH.$curpath.'/'.$filename,'');
	header('location:'.$BASESCRIPT.'?curpath='.$curpath);
	exit();
}elseif ($action == 'delete'){
	$filepath = FILE_PATH.$curpath.'/'.$filename;
	if (is_dir($filepath)){
		$de = new removeDir();
		$de->deleteDir($filepath);
	}else {
		@unlink($filepath);
	}
	header('location:'.$BASESCRIPT.'?curpath='.$curpath);
	exit();
}elseif ($action == 'savefile'){
	$code = str_replace(array('&lt;','&gt;'),array('<','>'),$code);
	writetofile(FILE_PATH.$curpath.'/'.$filename,$code);
	header('location:'.$BASESCRIPT.'?curpath='.$curpath);
	exit();
}elseif ($action == 'renamefile'){
	rename(FILE_PATH.$curpath.'/'.$filename,FILE_PATH.$curpath.'/'.$newname);
	header('location:'.$BASESCRIPT.'?curpath='.$curpath);
	exit();
}elseif ($action == 'editfile'){
	$code = readfromfile(FILE_PATH.$curpath.'/'.$filename);
	$code = str_replace(array('<','>'),array('&lt;','&gt;'),$code);
}elseif ($action == 'rename'){
	
}elseif ($action == 'list') {
	!$curpath && $curpath = '';
	$curpath = str_replace('.','',$curpath);
	$curpath = ereg_replace('/{1,}','/',$curpath);
	$filetree = $files = $folders = array();
	$inpath = FILE_PATH.$curpath;
	$dir = dir($inpath);
	while($file = $dir->read()) {
		//-----计算文件大小和创建时间
		$filepath = $inpath.'/'.$file;
		if($file == '.'){
			continue;
		}elseif ($file == '..'){
			if ($curpath=='')continue;
			$parent = array(
			   	'filename'=>'上级目录',
			   	'folderlink'=>$BASESCRIPT.'?curpath='.urlencode(eregi_replace("[/][^/]*$","",$curpath)),
			   	'img'=>'image/dir2.gif',
				'filetime'=>date("Y-m-d H:i:s",filemtime($filepath))
		    );
		}elseif(is_dir($filepath)){
			if(eregi("^_(.*)$",$file)){
				continue; 
				//#屏蔽FrontPage扩展目录和linux隐蔽目录
			}
			if(eregi("^\.(.*)$",$file)){
				continue;
			}
			$folders[] = array(
			   	'filename'=>$file,
			   	'folderlink'=>$BASESCRIPT.'?curpath='.urlencode($curpath.'/'.$file),
			   	'img'=>'image/dir.gif',
				'filetime'=>date("Y-m-d H:i:s",filemtime($filepath))
		    );
		}else {
			$filesize = filesize($filepath);
			$filesize = $filesize<(1024*1024) ? round(($filesize/1024),2).'KB' : round(($filesize/(1024*1024)),2).'MB';
			$filetime = date("Y-m-d H:i:s",filemtime($filepath));
			
			$files['filename'] = $file;
			$files['filesize'] = $filesize;
			$files['filetime'] = $filetime;
			$files['filepath'] = $curpath.'/'.$file;
			if (eregi(".(gif|png)",$file)){
				$files['img'] = 'image/gif.gif';
			}elseif (eregi(".(jpg)",$file)){
				$files['img'] = 'image/jpg.gif';
			}elseif (eregi(".(zip|rar)",$file)){
				$files['img'] = 'image/rar.gif';
			}elseif (eregi(".(exe)",$file)){
				$files['img'] = 'image/exe.gif';
			}elseif (eregi(".(css)",$file)){
				$files['img'] = 'image/css.gif';
			}elseif (eregi(".(htm|html)",$file)){
				$files['img'] = 'image/html.gif';
			}elseif (eregi(".(php|php3)",$file)){
				$files['img'] = 'image/php.gif';
			}elseif (eregi(".(txt|asp|jsp)",$file)){
				$files['img'] = 'image/txt.gif';
			}else {
				//continue;
				$files['img'] = 'image/htm.gif';
			}
			if (eregi(".(txt|asp|jsp|js|java|php|htm|html|php|css|info|conf|htaccess|cpp)",$files['filename'])){
				$files['edit'] = TRUE;
			}else {
				$files['edit'] = FALSE;
			}
			$filetree[]=$files;
		}
	}
	//End Loop
	$dir->close();	
}
include ROOT_PATH.'/template/index.php';
?>
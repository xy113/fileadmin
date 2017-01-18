<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>登录</title>
<link rel="stylesheet" type="text/css" href="image/css.css">
</head>

<body>
<div id="login">
<form id="form1" name="form1" method="post" action="<?php echo $BASESCRIPT ?>?action=login">
	<h1>登录在线文件管理系统</h1>
	<div>
		<label>用户名：</label>
		<input type="text" class="txt" name="username" value="" />
	</div>
	<div>
		<label>密　码：</label>
		<input type="password" class="txt" name="password" value="" />
	</div>
	<div class="button"><input type="submit" value="登录" /> <input type="reset" value="重置" /></div>
</form>
</div>
<script type="text/javascript">
document.form1.onsubmit = function(){
	if(document.form1.username.value && document.form1.password.value){
		return true;
	}else{
		return false;
	}
}
</script>
</body>
</html>
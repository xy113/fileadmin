<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�����ļ�����ϵͳ</title>
<link rel="stylesheet" type="text/css" href="image/css.css">
</head>

<body>
<p>
<span id="menu">
<a href="<?php echo $BASESCRIPT ?>?action=createdir&curpath=<?php echo $curpath ?>">�½�Ŀ¼</a>
<a href="<?php echo $BASESCRIPT ?>?action=createfile&curpath=<?php echo $curpath ?>">�½��ļ�</a>
<a href="<?php echo $BASESCRIPT ?>">���ظ�Ŀ¼</a>
<a href="<?php echo $BASESCRIPT ?>?curpath=<?php echo $curpath ?>">���ص�ǰĿ¼</a>
<a href="<?php echo $BASESCRIPT ?>?action=logout">�˳���¼</a>
</span>
��ǰĿ¼��<?php echo $curpath ? $curpath : '/'; ?>
</p>
<?php if ($action=='createfile') {?>
<p>
<form method="post" action="<?php echo $BASESCRIPT ?>?action=mkfile&curpath=<?php echo $curpath ?>" onsubmit="return checkForm(this)">
�ļ�����<input type="text" name="filename" class="text" />
<input type="submit" class="submit" value="�ύ" />
</form>
</p>
<script type="text/javascript">function checkForm(Form){if(Form.filename.value.length>0){return true}else{return false}}</script>
<?php }elseif ($action=='createdir') {?>
<p>
<form method="post" action="<?php echo $BASESCRIPT ?>?action=mkdir&curpath=<?php echo $curpath ?>" onsubmit="return checkForm(this)">
�ļ�����<input type="text" name="dirname" class="text" />
<input type="submit" class="submit" value="�ύ" />
</form>
<script type="text/javascript">function checkForm(Form){if(Form.dirname.value.length>0){return true}else{return false}}</script>
</p>
<?php }elseif ($action=='rename') {?>
<p>ԭ�ļ�����<?php echo $filename ?></p>
<p>
�����������Ŀ��Ϊ�ļ������ļ����������ļ�����չ����
<form method="post" action="<?php echo $BASESCRIPT ?>?action=renamefile&curpath=<?php echo $curpath ?>" onsubmit="return checkForm(this)">
<input type="hidden" name="filename" value="<?php echo $filename ?>" />
���ļ�����<input type="text" name="newname" class="text" />
<input type="submit" class="submit" value="�ύ" />
</form>
<script type="text/javascript">function checkForm(Form){if(Form.dirname.value.length>0){return true}else{return false}}</script>
</p>
<?php }elseif ($action == 'editfile') {?>
<p>
<form action="<?php echo $BASESCRIPT ?>?action=savefile&curpath=<?php echo $curpath ?>" method="post">
<input type="hidden" name="filename" value="<?php echo $filename ?>" />
<textarea name="code" id="code" style="width:99%; height:400px; padding:5px;"><?php echo $code ?></textarea>
<p><input type="submit" value="�������" class="submit" id="save" /></p>
</form>
</p>
<?php }else{?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="table-list">
  <tr>
    <th>�ļ���</th>
    <th width="120">�ļ���С</th>
    <th width="160">�޸�ʱ��</th>
    <th width="160">����ѡ��</th>
  </tr>
  <?php if (is_array($parent)){ ?>
  <tr onmouseover="this.className='hover'" onmouseout="this.className=''">
    <td><img src="<?php echo $parent['img'] ?>" border="0" /><a href="<?php echo $parent['folderlink'] ?>"><?php echo $parent['filename'] ?></a></td>
    <td><em>Ŀ¼</em></td>
    <td><?php echo $parent['filetime'] ?></td>
    <td></td>
  </tr>
  <?php }?>
  <?php foreach($folders as $fd){?>
  <tr onmouseover="this.className='hover'" onmouseout="this.className=''">
    <td><img src="<?php echo $fd['img'] ?>" border="0" /><a href="<?php echo $fd['folderlink'] ?>"><?php echo $fd['filename'] ?></a></td>
    <td><em>Ŀ¼</em></td>
    <td><?php echo $fd['filetime'] ?></td>
    <td>
		<a href="<?php echo $BASESCRIPT ?>?action=rename&curpath=<?php echo $curpath ?>&filename=<?php echo $fd['filename'] ?>">������</a>
		<a href="<?php echo $BASESCRIPT ?>?action=delete&curpath=<?php echo $curpath ?>&filename=<?php echo $fd['filename'] ?>">ɾ��</a>	
	</td>
  </tr>
  <?php }?>
  <?php foreach($filetree as $fl){?>
  <tr onmouseover="this.className='hover'" onmouseout="this.className=''">
    <td><img src="<?php echo $fl['img'] ?>" border="0" /><?php if ($fl['edit']){ ?><a href="<?php echo $BASESCRIPT ?>?action=editfile&curpath=<?php echo $curpath ?>&filename=<?php echo $fl['filename'] ?>"><?php echo $fl['filename'] ?><?php }else{  ?><?php echo $fl['filename'] ?><?php }?></a></td>
    <td><?php echo $fl['filesize'] ?></td>
    <td><?php echo $fl['filetime'] ?></td>
    <td>
		<a href="<?php echo $BASESCRIPT ?>?action=rename&curpath=<?php echo $curpath ?>&filename=<?php echo $fl['filename'] ?>">������</a>	
		<a href="<?php echo $BASESCRIPT ?>?action=delete&curpath=<?php echo $curpath ?>&filename=<?php echo $fl['filename'] ?>">ɾ��</a>
		<?php if ($fl['edit']){ ?><a href="<?php echo $BASESCRIPT ?>?action=editfile&curpath=<?php echo $curpath ?>&filename=<?php echo $fl['filename'] ?>">�޸�</a><?php }?>
	</td>
  </tr>
  <?php }?>
</table>
<?php }?>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<link href="../css/admin_style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#content {
	background-color: #F3F3F3;
	float: left;
	width: 835px;
}
</style>
<script language="javascript">
function reSize(){
　　//parent.document.all.frameid.height=document.body.scrollHeight; 
　　parent.document.getElementById("frm").height=document.body.scrollHeight;
} 
window.onload=reSize;
</script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/date.js"></script>

</head>

<body>
<div id="content">
<div id="top_nav">
<table width="835" border="0" cellpadding="0" cellspacing="0" height="28">
    <tr>
      <td width="21" background="../images/board10.gif">&nbsp;</td>
      <td width="100" background="../images/board04.gif" align="left" style="font-size:0.8em">瀏覽人次 統計</td>
      <td width="701" background="../images/board04.gif" style="font-size:0.8em">&nbsp;</td>
      <td width="13" background="../images/board04.gif">&nbsp;</td>
    </tr>
  </table>
</div>
<table width="835" border="0" cellspacing="0" cellpadding="0" class="cx_admin_table">
  <tr>
    <td width="300">瀏覽人數總計：</td>
    <td width="533">總訪客數：</td>
  </tr>
  <tr>
    <td>今日瀏覽人數：</td>
    <td>本月瀏覽人數：</td>
  </tr>
  <tr>
    <td>搜尋當日統計人數：</td>
    <td><form id="form1" name="form1" method="post" action="admin_viewCount_lint.php" target="frm">
      <select name="f_year" id="f_year">
      <?php for($i= date("Y"); $i > date("Y")-10; $i--){ ?>
        <option value="<?php echo $i ;?>"><?php echo $i ;?></option>
      <?php } ?>
      </select>
      年
      <label for="f_month"></label> 
      <select name="f_month" id="f_month">
      <?php for($i=1;$i<=12;$i++) { ?>
        <option value="<?php echo $i ;?>"><?php echo $i ;?></option>
      <?php } ?>
      </select>
      月
<label for="f_day"></label>
      <select name="f_day" id="f_day">
      </select>
      日
<input type="submit" value="查詢" />
    </form></td>
  </tr>
  <tr>
    <td>搜尋範圍統計人數：</td>
    <td><form id="form2" name="form2" method="post" action="admin_viewCount_lint.php" target="frm">
      <select name="s_year" id="s_year">
      <?php for($i= date("Y"); $i > date("Y")-10; $i--){ ?>
        <option value="<?php echo $i ;?>"><?php echo $i ;?></option>
      <?php } ?>
      </select>
      年
      <label for="t_month"></label>      
      <select name="s_month" id="s_month">
      <?php for($i=1;$i<=12;$i++) { ?>
        <option value="<?php echo $i ;?>"><?php echo $i ;?></option>
      <?php } ?>
      </select>
      月
      <label for="t_day"></label>
      <select name="s_day" id="s_day">
      </select>
      日 ~ 
      <select name="t_year" id="t_year">
      <?php for($i= date("Y"); $i > date("Y")-10; $i--){ ?>
        <option value="<?php echo $i ;?>"><?php echo $i ;?></option>
      <?php } ?>
      </select>      
      年
      <label for="t_month"></label>      
      <select name="t_month" id="t_month">
      <?php for($i=1;$i<=12;$i++) { ?>
        <option value="<?php echo $i ;?>"><?php echo $i ;?></option>
      <?php } ?>
      </select>
	  月
	  <label for="t_day"></label>
      <select name="t_day" id="t_day">
      </select>
      日
      <input type="submit" value="查詢" />
    </form></td>
  </tr>
</table>
<table width="835" border="0" cellspacing="0" cellpadding="0" class="cx_admin_table" style="text-align:center">
  <tr>
  	<td width="139"></td>
    <td width="139">影音</td>
    <td width="139">活動</td>
    <td width="158">整版新聞</td>
    <td width="259">求職</td>
    <td width="140">租售</td>
  </tr>
  <tr>
    <td width="139">今日</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="139">某一天(顯示日期)</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="139">範圍(顯示日期)</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


</div>
</body>
</html>
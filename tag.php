<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ja">
<head>
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="content-type" content="text/html;charset=EUC-JP">
<link rel="stylesheet" type="text/css" href="tag.css">
<title>�Ϥƥ֤Υ����򸡺�����</title>
</head>
<body>

<h1><a href="http://kiwofusi.sakura.ne.jp/hatebu/tag.php">�Ϥƥ֤Υ����򸡺�����</a>
<a href="http://b.hatena.ne.jp/entry/http://kiwofusi.sakura.ne.jp/hatebu/tag.php"><img alt="�ϤƤʥ֥å��ޡ���" src="http://b.hatena.ne.jp/entry/image/http://kiwofusi.sakura.ne.jp/hatebu/tag.php"></a></h1>

<?php

$dbname = "";
$hostname = "";
$userid = "";
$passwd = "";

// �ǡ����١�������³
if(!$con = mysql_connect($hostname,$userid,$passwd)){
  die("mysql_connect failed.");
}
mysql_query("SET CHARACTER SET ujis;");
mysql_select_db($dbname,$con);

// ������̾�������ܸ��
$get_name = htmlspecialchars($_GET['name']);

// ������̾����URL���󥳡��ɡ�
$url = urlencode($get_name);

// �����ꥹ�Ȥ��������
$name = "'%" . $get_name ."%'";
$sql = "select name from tag where name like " . $name . " order by name;";
$result = mysql_query($sql);

// �����μ�����������
$sort = htmlspecialchars($_GET['sort']);

// ��������ꤹ��
// $sort_url_ex : ��򳫤������URL

// ���奨��ȥ�
if (strcmp($sort, 'eid') == 0) {
  $sort_url_ex = "&amp;sort=eid";
// �͵�����ȥ�
} elseif (strcmp($sort, 'count') == 0) {
  $sort_url_ex = "&amp;sort=count";
// ���ܥ���ȥ�ʥǥե���ȡ�
} else {
  $sort_url_ex = "";
}

?>

<p>�㡧<a href="http://kiwofusi.sakura.ne.jp/hatebu/tag.php?name=%A4%B3%A4%EC%A4%CF<?php print($sort_url_ex); ?>">�֤���ϡפ򸡺�</a>��<a href="http://kiwofusi.sakura.ne.jp/hatebu/tag.php?name=%A4%A2%A4%C8%A4%C7<?php print($sort_url_ex); ?>">�֤��Ȥǡפ򸡺�</a></p>

<form method="GET" action="tag.php">
  <p><input type="text" name="name" value="">
  <?php // �����Ȥμ������ꤹ��
  if (strcmp($sort_url, "") != 0) {
    print("<input type=\"hidden\" name=\"sort\" value=\"" . $sort . "; \">");
  }
  ?>
  <input type="submit" value="����"></p>
</form>

<?php

// ������ɽ������
// $sort_url : �Ϥƥ֤򳫤������URL

// ���奨��ȥ�
if (strcmp($sort, 'eid') == 0) {
  $sort_url = "?sort=eid";
  print("<p>����衧�����<a href=\"tag.php?name=". $url . "\">" .
    "����</a>��<a href=\"tag.php?name=". $url . "&amp;sort=count\">�͵�</a></p>");
// �͵�����ȥ�
} elseif (strcmp($sort, 'count') == 0) {
  $sort_url = "?sort=count";
  print("<p>����衧<a href=\"tag.php?name=". $url . "&amp;sort=eid\">����</a>" .
    "��<a href=\"tag.php?name=". $url . "\">����</a>�ÿ͵�</p>");
// ���ܥ���ȥ�ʥǥե���ȡ�
} else {
  $sort_url = "";
  print("<p>����衧<a href=\"tag.php?name=". $url . "&amp;sort=eid\">����</a>��" .
    "���ܡ�<a href=\"tag.php?name=". $url . "&amp;sort=count\">�͵�</a></p>");
}

// �����θ�����̤�ɽ������
if ($get_name) {

  // ��������������ɽ������
  $sql = "select count(id) from tag where name like " . $name . " order by name;";
  $cnt = mysql_query($sql);
  $cnt = mysql_fetch_assoc($cnt);
  print("<h2>��" . $get_name . "�פθ������(" . $cnt['count(id)'] . ")</h2>");

  // �����ꥹ�Ȥ�ɽ������
  print("<ul id=\"tag_list\">");
  while ($row = mysql_fetch_assoc($result)) {
    $name_url = mb_convert_encoding($row['name'], "UTF-8", "ujis");
    $name_url = rawurlencode($name_url);
    print("<li class=\"tag\"><a href=\"http://b.hatena.ne.jp/t/" .
      $name_url . $sort_url . "\" target=\"_blank\">" . $row['name'] .
      "</a></li>\n");
  }
  print("</ul>");
}

// �ǡ����١���������
mysql_close($con);

?>

<br>
<address><a href="http://twitter.com/kiwofusi">kiwofusi</a></address>
</body>
</html>
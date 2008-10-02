<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ja">
<head>
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="content-type" content="text/html;charset=EUC-JP">
<link rel="stylesheet" type="text/css" href="tag.css">
<title>はてブのタグを検索する</title>
</head>
<body>

<h1><a href="http://kiwofusi.sakura.ne.jp/hatebu/tag.php">はてブのタグを検索する</a>
<a href="http://b.hatena.ne.jp/entry/http://kiwofusi.sakura.ne.jp/hatebu/tag.php"><img alt="はてなブックマーク" src="http://b.hatena.ne.jp/entry/image/http://kiwofusi.sakura.ne.jp/hatebu/tag.php"></a></h1>

<?php

$dbname = "";
$hostname = "";
$userid = "";
$passwd = "";

// データベースに接続
if(!$con = mysql_connect($hostname,$userid,$passwd)){
  die("mysql_connect failed.");
}
mysql_query("SET CHARACTER SET ujis;");
mysql_select_db($dbname,$con);

// タグの名前（日本語）
$get_name = htmlspecialchars($_GET['name']);

// タグの名前（URLエンコード）
$url = urlencode($get_name);

// タグリストを取得する
$name = "'%" . $get_name ."%'";
$sql = "select name from tag where name like " . $name . " order by name;";
$result = mysql_query($sql);

// リンク先の種類を取得する
$sort = htmlspecialchars($_GET['sort']);

// リンク先を指定する
// $sort_url_ex : 例を開くためのURL

// 新着エントリ
if (strcmp($sort, 'eid') == 0) {
  $sort_url_ex = "&amp;sort=eid";
// 人気エントリ
} elseif (strcmp($sort, 'count') == 0) {
  $sort_url_ex = "&amp;sort=count";
// 注目エントリ（デフォルト）
} else {
  $sort_url_ex = "";
}

?>

<p>例：<a href="http://kiwofusi.sakura.ne.jp/hatebu/tag.php?name=%A4%B3%A4%EC%A4%CF<?php print($sort_url_ex); ?>">「これは」を検索</a>，<a href="http://kiwofusi.sakura.ne.jp/hatebu/tag.php?name=%A4%A2%A4%C8%A4%C7<?php print($sort_url_ex); ?>">「あとで」を検索</a></p>

<form method="GET" action="tag.php">
  <p><input type="text" name="name" value="">
  <?php // ソートの種類を指定する
  if (strcmp($sort_url, "") != 0) {
    print("<input type=\"hidden\" name=\"sort\" value=\"" . $sort . "; \">");
  }
  ?>
  <input type="submit" value="検索"></p>
</form>

<?php

// リンク先を表示する
// $sort_url : はてブを開くためのURL

// 新着エントリ
if (strcmp($sort, 'eid') == 0) {
  $sort_url = "?sort=eid";
  print("<p>リンク先：新着｜<a href=\"tag.php?name=". $url . "\">" .
    "注目</a>｜<a href=\"tag.php?name=". $url . "&amp;sort=count\">人気</a></p>");
// 人気エントリ
} elseif (strcmp($sort, 'count') == 0) {
  $sort_url = "?sort=count";
  print("<p>リンク先：<a href=\"tag.php?name=". $url . "&amp;sort=eid\">新着</a>" .
    "｜<a href=\"tag.php?name=". $url . "\">注目</a>｜人気</p>");
// 注目エントリ（デフォルト）
} else {
  $sort_url = "";
  print("<p>リンク先：<a href=\"tag.php?name=". $url . "&amp;sort=eid\">新着</a>｜" .
    "注目｜<a href=\"tag.php?name=". $url . "&amp;sort=count\">人気</a></p>");
}

// タグの検索結果を表示する
if ($get_name) {

  // 検索件数を取得、表示する
  $sql = "select count(id) from tag where name like " . $name . " order by name;";
  $cnt = mysql_query($sql);
  $cnt = mysql_fetch_assoc($cnt);
  print("<h2>「" . $get_name . "」の検索結果(" . $cnt['count(id)'] . ")</h2>");

  // タグリストを表示する
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

// データベースを切断
mysql_close($con);

?>

<br>
<address><a href="http://twitter.com/kiwofusi">kiwofusi</a></address>
</body>
</html>
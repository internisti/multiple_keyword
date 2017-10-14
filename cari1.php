<?php
include "koneksi.php";
$mode = $_GET['mode'] ;
// menghilangkan space di kiri dan kanannya 
$search = trim($_POST['search']); 
// memisahkan array perkata 
$search_array = explode(" ",$search); 
$banyak_kata = (integer)count($search_array);
// query looping, sehingga menghasilkan 
// select * from tw_blog where blog_body 
// like '%$search_array[$x]%' AND blog_body like '%%'
$searchquery = "select * from tw_blog where " ;
for ( $x = 0; $x< $banyak_kata; $x++){
	$searchquery .= "blog_body like '%$search_array[$x]%'";
	if ( $x <  $banyak_kata -1){
		$searchquery .= " AND ";
	}
}
$runsearchquery = mysql_query($searchquery);
if ($mode == "search" ){
	$numrows = mysql_num_rows($runsearchquery);
	// memberikan highlight dan bold pada string yang dicari
	// dengan looping sebanyak $banyak_kata
	print "String yang anda cari : ";
	for ( $x = 0; $x<= $banyak_kata; $x++){
		$search_replace[$x] = "<b><FONT style='BACKGROUND-COLOR:yellow'>$search_array[$x]</b></FONT>";
		print "$search_replace[$x] ";				
	}
	print "<br>Data yang anda cari, ada dalam database sebanyak : <b>$numrows</b><hr>" ;
	while ( $result = mysql_fetch_array($runsearchquery)){
		$isi = $result['blog_body'];
		// memberikan highlight dan bold pada setiap kata yang dicari 
		$isi_baru = str_ireplace($search_array, $search_replace, $isi);
		print "$result[blog_title]";
		print "<br>$isi_baru<br><br>";
	}
}
else{
?>
<html>
<head>
<title>Search Database ... </title></head>
<body>
<br>
<table border=1 bgcolor=lightblue align="center">
<form method=POST action=?mode=search>
<tr><td>Search:<br><input type=text name=search> <input type=submit name=submit value=Cari></td></tr>
</form>
</table>
</body>
</html>
<?php
}
?>
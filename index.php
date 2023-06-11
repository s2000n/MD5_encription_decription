<html>
<head>
<style>
body{
	font-family: 'Poppins', sans-serif;
}
.header-box{
	margin:auto;
	margin-top:3%;
	width:600px;
	box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
}
.header-bg{
	background:#1652F0;
	padding:1px;
	text-align:center;
}
.header-title{
	color:white;
}
.body-bg{
	margin:auto;
	margin-top:5%;
	height:50px;
	padding:1px;
	text-align:center;
	width:100%;
}
.bt{
	appearance: button;
	background-color: #1652F0;
	border: 1px solid #1652F0;
	border-radius: 4px;
	box-sizing: border-box;
	color: #FFFFFF;
	cursor: pointer;
	font-family: Graphik,-apple-system,system-ui,"Segoe UI",Roboto,Oxygen,Ubuntu,Cantarell,"Fira Sans","Droid Sans","Helvetica Neue",sans-serif;
	font-size: 12px;
	line-height: 1.15;
	overflow: visible;
	padding: 5px 15px;
	position: relative;
	text-align: center;
	text-transform: none;
	transition: all 80ms ease-in-out;
	user-select: none;
	-webkit-user-select: none;
	touch-action: manipulation;
	width: fit-content;
}
.bt:disabled {
	opacity: .5;
}
.bt:focus {
	outline: 0;
}
.bt:hover {
	background-color:#b3c6ff;
	border-color:#b3c6ff;
}
.bt:active {
	background-color: #0039D7;
	border-color: #0039D7;
}
input[type=text]{
	padding: 4px 15px;
	width:50%;
}
.error-box{
	margin:auto;
	margin-top:3%;
	width:600px;
	padding:5px;
	background:red;
	text-align:center;
	box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
}
.out-box{
	margin:auto;
	margin-top:3%;
	width:600px;
	padding:5px;
	background:green;
	text-align:center;
	box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
}
h3{
	color:white;
}
</style>
</head>
<body>
<div class='header-box'>
<div class='header-bg'><h1 class='header-title'>MD5 Encript & Decript</h1></div>
<div class='body-bg'>
<form action='/index.php' method='post'>
<input type='text' name='in-text' id='in-text'>
<input class='bt' type='button' value='paste' onclick='paste()'>
<input class='bt' type='submit' value='encript' name='encript'>
<input class='bt' type='submit' value='decript' name='decript'>
</div>
</div>
<div class='mid-box'>
<?php
$db_host='localhost';	//host name localhost,127.0.0.1
$db_username='';	//root username
$db_password='';	//root password
$db_name='';	//database name
if(isset($_POST['encript'])){
	$hash=hash('md5',$_POST['in-text']);	
	if($_POST['in-text']==''){
		echo "
			<div class='error-box'>
			<h3>Empty field...</h3>
			</div>
		";
	}else{
		$con=mysqli_connect($db_host,$db_username,$db_password,$db_name);
		$sql1=mysqli_query($con,'SELECT * FROM `md5_hash` WHERE password="'.$_POST['in-text'].'";');
		if($sql1->num_rows ==0){
			$sql2=mysqli_query($con,'INSERT INTO `md5_hash`(`password`, `hash`) VALUES ("'.$_POST['in-text'].'","'.$hash.'")');
		}
		echo "
			<div class='out-box'>
			<h3>hash is: <input type='text' value='".$hash."' id='out-text' readonly> <input class='bt' type='button' value='copy' onclick='copy()'></h3>
			</div>
		";	
		mysqli_close($con);
	}

}
?>
<?php
$db_host='localhost';	//host name localhost,127.0.0.1
$db_username='';	//root username
$db_password='';	//root password
$db_name='';	//database name
if(isset($_POST['decript'])){
	if($_POST['in-text']==''){
		echo "
		<div class='error-box'>
		<h3>Empty field...</h3>
		</div>
		";
	}else{
		$con=mysqli_connect($db_host,$db_username,$db_password,$db_name);
		$sql=mysqli_query($con,'SELECT * FROM `md5_hash` WHERE `hash` LIKE "'.$_POST['in-text'].'";');
		if($sql->num_rows > 0){
			while($row = $sql-> fetch_assoc()){
			echo "
			<div class='out-box'>
			<h3>decript is: <input type='text' value='".$row['password']."' id='out-text' readonly> <input class='bt' type='button' value='copy' onclick='copy()'></h3>
			</div>
			";
			}
		}else{
		echo "
		<div class='error-box'>
		<h3>No hash found...</h3>
		</div>
		";	
		}
		mysqli_close($con);
	}
}
?>
</div>
<script>
function copy(){
	var copyText = document.getElementById("out-text");
	navigator.clipboard.writeText(copyText.value);
}
async function paste(input) {
  const text = await navigator.clipboard.readText();
  document.getElementById("in-text").value = text;
}
</script>
</body>
</html>
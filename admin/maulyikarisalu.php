<?php 
session_start();
include("conn.php");

if (!$conn) {
    header("location:index.php?err=db");
    exit;
}

$adid = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['username']));
$psad = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password']));
$samasye = "SELECT * FROM `nirvahaka_shonu` WHERE `nirvahaka_hesaru`='".$adid."' AND `guptapada`='".md5($psad)."' AND `sthiti`='1'";
$phalitansa = mysqli_query($conn,$samasye);
$sankhye = $phalitansa ? mysqli_num_rows($phalitansa) : 0;
$salu = $phalitansa ? mysqli_fetch_assoc($phalitansa) : null;

if($sankhye >= 1){
    $_SESSION['unohs'] = $salu['unohs'];
    $_SESSION['nirvahaka_hesaru'] = $salu['nirvahaka_hesaru'];
    
    header("location:dashboard.php");
    exit;
}
else{
    header("location:index.php?err=ture");
    exit;
}

<?php
$conn = new mysqli();
$conn->connect('localhost', 'a0401143157', '4707441','a0401143157');
$conn->query('set names utf8');

$info = $conn->query("select * from yx_assets where `location` ='62'");
while($row = $info->fetch_assoc()){
    /*$info1[] = $row;*/
    $aid = 'BJ-'.$row['aid'];
    $oaid = $row['aid'];
    echo $aid."++++".$row['assetname']."<br>";
    $conn->query("update yx_assets set `aid`='$aid' where `aid`='$oaid'");
}

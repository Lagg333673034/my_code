<?php
session_start();

//otmechaem aktivnost polzovatela
$sql = "UPDATE tusers SET last_activity_data = now() WHERE udln is null and md5(concat(id,'$sol_user_id')) = '".$_SESSION['user_id']."'";
mysqli_query($db, $sql);

//log
/*$sql_id = "SELECT id FROM tusers WHERE udln is null and md5(concat(id,'$sol_user_id')) = '".$_SESSION['user_id']."'";
$res_id = mysqli_query($db, $sql_id);
$line_id = mysqli_fetch_array($res_id, MYSQLI_NUM);

$sql_log = "INSERT INTO tusers_log(d_cr, id_user, log) VALUES (now(),$line_id[0],'http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."')";
mysqli_query($db, $sql_log);
*/
?>
<?phprequire_once("../_functions.php");require_once("../_check_for_admin.php");require_once("../_mark_activity.php");// Если запрос идёт не из Ajaxif( $_SERVER['HTTP_X_REQUESTED_WITH'] != "XMLHttpRequest" ){    exit("Access denied!");}//--------------------------------------------------------------------------------------------------------------//$id_ekspert = check_string($_GET['id_ekspert']);if($id_ekspert == '') $id_ekspert='0';//--------------------------------------------------------------------------------------------------------------//$tables = array(    "teksperttest_vopros",    "teksperttest_sobesedovanie");for($i=0;$i<count($tables);$i++){    $sql = "update $tables[$i] set u_upd = '" . $_SESSION['user'] . "',d_upd = now(),udln=now() WHERE udln is null and id_eksperttest=$id_ekspert";    if(mysqli_query($db, $sql)!=true){        exit('Неизвестная ошибка при редактировании (удалении) строк в таблице '.$tables[$i]);    }}$sql_id_user = "SELECT id_user FROM teksperttest WHERE udln is null and id=$id_ekspert";$res_id_user = mysqli_query($db, $sql_id_user);$line_id_user = mysqli_fetch_array($res_id_user, MYSQLI_NUM);$sql = "UPDATE teksperttest SET    u_upd = '" . $_SESSION['user'] . "',     d_upd = now(),     udln = now()     WHERE udln is null and id=$id_ekspert";if (mysqli_query($db, $sql) != true) exit('Неизвестная ошибка при удалении строк в таблице teksperttest.');$sql = "UPDATE tusers SET    u_upd = '" . $_SESSION['user'] . "',     d_upd = now(),     udln = now()     WHERE udln is null and id=$line_id_user[0]";if (mysqli_query($db, $sql) != true) exit('Неизвестная ошибка при удалении строк в таблице tuser.');//--------------------------------------------------------------------------------------------------------------//?>
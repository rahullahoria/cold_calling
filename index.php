<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 7/19/16
 * Time: 10:41 AM
 */
session_start();

$db_handle = mysqli_connect("localhost","root","redhat@11111p","cold_calls");


function sendSMS($to, $message){
    $username = "rajnish90";
    $password = "redhat123";
    $senderid = "BLUETM";

    $url = "http://www.smsjust.com/blank/sms/user/urlsms.php?".
        "username=".$username.
        "&pass=".$password.
        "&senderid=".$senderid.
        "&dest_mobileno=".$to.
        "&msgtype=TXT".
        "&message=".urlencode($message).
        "&response=Y"
    ;
    //echo $url;
    return httpGet($url);
}

function sendProSMS($to, $message){
    $username = "rajnish90";
    $password = "redhat123";
    $senderid = "BLUETM";

    $url = "http://www.smsjust.com/blank/sms/user/urlsms.php?".
        "username=".$username.
        "&pass=".$password.
        "&senderid=".$senderid.
        "&dest_mobileno=".$to.
        "&msgtype=TXT".
        "&message=".urlencode($message).
        "&response=Y"
    ;
    //echo $url;
    return httpGet($url);
}

function httpGet($url){
    $ch = curl_init();

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//  curl_setopt($ch,CURLOPT_HEADER, false);

    $output=curl_exec($ch);

    curl_close($ch);
    return $output;
}

if($_POST['change_status']){


    mysqli_query($db_handle, "UPDATE `calling_queue` SET status = '".$_POST['change_status']."' WHERE id = " . $_POST['id']);

}

if($_POST['send_sms']){
    $mobile = $_POST['mobile'];
    //$mobile = "9599075955";

    $message = "You have just talked to BlueTeam, to Get reliable and trusted Maid, Cook, Driver & Babysitter\n9599075355\nhttp://goo.gl/PhJXAg";
    sendSMS($mobile, $message);

    mysqli_query($db_handle, "UPDATE `calling_queue` SET status = 'done' WHERE id = " . $_POST['id']);

}

if (!isset($_SESSION['user_id']))
    header("location: http://shatkonlabs.com/ragnar/login.php");

$userID = $_SESSION['user_id'];


$sql = "SELECT  * from calling_queue where status = 'in-queue' limit 0, 100";
//echo $sql;
$result = mysqli_query($db_handle,
    $sql);

$table = "";
while ($row = mysqli_fetch_assoc($result)) {

    $table .=  "<tr>";
    $table .=  "<td>".$row["id"]."</td>";
    $table .=  "<td>".$row["name"]."</td>";
    $table .=  "<td>".$row["mobile"]."</td>";
    $table .=  "<td>".$row["address"]."</td>";
    /*$table .=  "<td>".$row["gender"]."</td>";*/
    $table .=  "<td >
                    <form method='post' style=\"margin: 0; float: left; padding: 1px;\">
                        <input type='hidden' name='id' value='".$row["id"]."' />
                        <input style=\"display: inline;\" type='submit' name='change_status' value='DNP'>
                    </form>
                    <form method='post' style=\"margin: 0; float: left; padding: 1px;\">
                        <input type='hidden' name='id' value='".$row["id"]."' />
                        <input style=\"display: inline;\"type='submit' name='change_status' value='NR'>
                    </form>
                    <form method='post' style=\"margin: 0; float: left; padding: 1px;\">
                        <input type='hidden' name='id' value='".$row["id"]."' />
                        <input type='submit' name='change_status' value='NW'>
                    </form>
                    <form method='post' style=\"margin: 0; float: left; padding: 1px;\">
                        <input type='hidden' name='id' value='".$row["id"]."' />
                        <input type='hidden' name='mobile' value='".$row["mobile"]."' />
                        <input style=\"display: inline;\" type='submit' name='send_sms' value='SMS'>
                    </form>
                </td>";
    $table .=  "</tr>";
}
/*SELECT status,count(*) FROM `calling_queue` WHERE DATE(`updated`) = CURDATE() group by status*/

$sql = "SELECT status,count(*) as c FROM `calling_queue` WHERE DATE(`updated`) = CURDATE() group by status;";
//echo $sql;
$result = mysqli_query($db_handle,
    $sql);

$todayStatus = "|";
while ($row = mysqli_fetch_assoc($result)) {
    $todayStatus .= "<b>".$row['status']."</b>: ".$row['c']. " |";
}
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
</head>
<body>
<div style="text-align: center;"><?=$todayStatus ?></div>
<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Mobile</th>
        <th>Address</th>
        <!--<th>Gender</th>-->
        <th>SMS</th>

    </tr>
    </thead>
    <tbody>
    <?= $table ?>

    </tbody>
</table>
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>
    $(function(){
        $("#example").dataTable(   { "iDisplayLength": 50
    });
    })
</script>
</body>
</html>

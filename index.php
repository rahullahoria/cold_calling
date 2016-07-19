<?php
/**
 * Created by PhpStorm.
 * User: spider-ninja
 * Date: 7/19/16
 * Time: 10:41 AM
 */

$db_handle = mysqli_connect("localhost","root","redhat@11111p","cold_calls");

$sql = "SELECT  * from calling_queue where status = 'in-queue' limit 0, 500";
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
    $table .=  "<td>".$row["gender"]."</td>";
    $table .=  "<td><button>Send sms</button></td>";
    $table .=  "</tr>";
}
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
</head>
<body>
<table id="example" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>ID_R</th>
        <th>Name</th>
        <th>Mobile</th>
        <th>Address</th>
        <th>Gender</th>
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
        $("#example").dataTable();
    })
</script>
</body>
</html>

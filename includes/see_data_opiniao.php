<?php

require 'db.inc.php';

$id = $_SESSION['userId'];


if($_SESSION['userStatus'] == 'admin'){

    $sql = "SELECT * FROM opinioes";
    $result = mysqli_query( $conn, $sql);
    $resultCheck = mysqli_num_rows($result);

}
else{
$sql = "SELECT * FROM opinioes WHERE  id_client = ${id}";
    $result = mysqli_query( $conn, $sql);
    $resultCheck = mysqli_num_rows($result);
}



 






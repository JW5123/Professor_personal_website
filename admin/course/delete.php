<?php
require_once("../../Database/connDB.php");
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM course WHERE id='$id'";
    if(mysqli_query($conn, $sql)){
        
        mysqli_query($conn, "SET @count = 0");
        mysqli_query($conn, "UPDATE course SET id = @count:= @count + 1");
        mysqli_query($conn, "ALTER TABLE course AUTO_INCREMENT = 1");
        session_start();
        $_SESSION["delete"] = "刪除成功!";
        header("Location: ../courseData.php");
    }else{
        die("Something went wrong");
    }
} else{
    echo "不存在";
}

if (isset($_GET['delete_all']) && $_GET['delete_all'] == 'true') {
    $sql = "DELETE FROM appointment WHERE 狀態='已通過' OR 狀態='未通過'";
    if (mysqli_query($conn, $sql)) {

        mysqli_query($conn, "SET @count = 0");
        mysqli_query($conn, "UPDATE appointment SET id = @count:= @count + 1");
        mysqli_query($conn, "ALTER TABLE appointment AUTO_INCREMENT = 1");
        session_start();
        $_SESSION["delete"] = "所有預約紀錄刪除成功!";
        header("Location: ../courseData.php");
    } else {
        die("刪除過程中出現錯誤");
    }
} else {
    echo "無效的操作";
}

?>

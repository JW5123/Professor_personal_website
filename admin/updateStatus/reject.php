<?php
session_start();
require_once("../../Database/connDB.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';



error_reporting(E_ALL);
ini_set('display_errors', 1);

$sqlSelect = mysqli_query($conn, "SELECT * FROM introduction");
while($data = mysqli_fetch_array($sqlSelect)){
    $name = $data['姓名'];
} 

if (isset($_GET["id"])) {
    $id = $_GET['id'];

    $sqlSelect = "SELECT 信箱 FROM appointment WHERE id='$id'";
    $result = mysqli_query($conn, $sqlSelect);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $studentMail = $row['信箱'];

        $sqlInsert = "UPDATE appointment SET 狀態='未通過' WHERE id='$id'";

        $mail = new PHPMailer(true);
        try {
            if (mysqli_query($conn, $sqlInsert)) {

                $mail->isSMTP();                                         
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                
                require_once("../../mailset/reject_set.php"); // set your mail username and password

                header("Location: ../courseData.php");
                exit();
            } else {
                die("Something went wrong with the database update");
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "No record found with id $id";
    }
} else {
    echo "Invalid request";
}
?>

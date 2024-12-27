<?php

$borrow_message = "";
$isValid = true;

if (isset($_POST["submit"])) {

    if(preg_match("/^[A-Z][a-z]$/", $_POST["studentName"])){
        $studentName = $_POST["studentName"];
    }else{
        $studentName = "Invalid student name <br>";
        $isValid = false;
    }

    if(preg_match("/^\d{2}-\d{5}-\d{1}$/", $_POST["studentID"])){
        $studentID = $_POST["studentID"];
    }else{
        $studentID = "Invalid student ID <br>";
        $isValid = false;
    }

    if(preg_match("/^\d{2}-\d{5}-\d{1}+\@+(student)+\.(aiub)+\.(edu)/", $_POST["studentEmail"])){
        $studentEmail = $_POST["studentEmail"];
    }else{
        $studentEmail = "Invalid student Email <br>";
        $isValid = false;
    }

    if(isset($_POST["bookTitle"])){
        $bookTitle = $_POST["bookTitle"];

        $cookie_name = str_replace(" ", "", $_POST["bookTitle"]);
        $cookie_value = $_POST["studentName"];
    }

    if (isset($_POST["borrowDate"], $_POST["returnDate"])) {

        $borrow_date = $_POST["borrowDate"];
        $return_date = $_POST["returnDate"];

        $borrowDate = new DateTime($_POST["borrowDate"]);
        $returnDate = new DateTime($_POST["returnDate"]);
        
        if ($borrowDate < $returnDate) {
            $dateDifference = date_diff($borrowDate, $returnDate);

            setcookie($cookie_name, $cookie_value, time() + 10);
            // setcookie($cookie_name, $cookie_value, time() + (60*60*24 * $dateDifference->days));
        }

        if(isset($_COOKIE[$cookie_name])) {
            // echo "Cookie is set. <br>";
            $bookTitle = str_replace(" ", "", $_POST['bookTitle']);

            foreach($_COOKIE as $cookieName=>$cookieValue){
                if($cookieName == $bookTitle){
                    $borrow_message = "Sorry, This book is already borrowed.";
                }
            }
        }else{
            // echo "Cookie not found.<br>";
        }
    }

    $token = $_POST["token"];
    $fees = $_POST["fees"];
} else {
    echo "No data provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Receipt</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        
        <?php 
            if($borrow_message)
            {
                echo $borrow_message;
            }else {
                echo '<div>
                        <h2 style="color: green;">Thanks for booking.</h2>
                        <h3>Student Name: '.$studentName . '</h3>
                        <h3>Student ID: '.$studentID .'</h3>
                        <h3>Student Email: '.$studentEmail .'</h3>
                        <h3>Book Name: '.$bookTitle .'</h3>
                        <h3>Borrow date: '.$borrow_date .'</h3>
                        <h3>Token: '.$token .'</h3>
                        <h3>Return date: '.$return_date .'</h3>
                        <h3>Fees: '.$fees .'</h3>
                    </div>';
            }
        ?>
    </div>
</body>
</html>
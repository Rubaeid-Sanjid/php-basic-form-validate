<?php
if (isset($_POST["submit"])) {

    if(preg_match("/^[A-Z]/", $_POST["studentName"])){
        $studentName = $_POST["studentName"];
    }else{
        echo "Invalid student name <br>";
    }

    if(preg_match("/^\d{2}-\d{5}-\d{1}$/", $_POST["studentID"])){
        $studentID = $_POST["studentID"];
    }else{
        echo "Invalid student ID <br>";
    }

    if(preg_match("/^\d{2}-\d{5}-\d{1}+\@+(student)+\.(aiub)+\.(edu)/", $_POST["studentEmail"])){
        $studentEmail = $_POST["studentEmail"];
    }else{
        echo "Invalid student Email <br>";
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
                echo $cookieName."<br>";
                if($cookieName == $bookTitle){
                    echo "Sorry, This book is already borrowed.";
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
</head>
<body>
    <div>
        <h2>Thanks for booking.</h2>
        <div>
            <h3>Student Name: <?php echo $studentName ?></h3>
            <h3>Student ID: <?php echo $studentID ?></h3>
            <h3>Student Email: <?php echo $studentEmail ?></h3>
            <h3>Book Name: <?php echo $bookTitle ?></h3>
            <h3>Borrow date: <?php echo $borrow_date ?></h3>
            <h3>Token: <?php echo $token ?></h3>
            <h3>Return date: <?php echo $return_date  ?></h3>
            <h3>Fees: <?php echo $fees  ?></h3>
        </div>
    </div>
</body>
</html>
<?php

if (isset($_POST["submit"])) {
    $error_message = "";

    if (preg_match("/^[A-Za-z ]+$/", $_POST["studentName"])) {
        $studentName = $_POST["studentName"];
    } else {
        $error_message = "Invalid student name. Must start with a capital letter and contain only letters and spaces.<br>";
    }

    if (preg_match("/^\d{2}-\d{5}-\d{1}$/", $_POST["studentID"])) {
        $studentID = $_POST["studentID"];
    } else {
        $error_message = "Invalid student ID. Format must be NN-NNNNN-N.<br>";
    }

    if (preg_match("/^\d{2}-\d{5}-\d{1}@student\.aiub\.edu$/", $_POST["studentEmail"])) {
        $studentEmail = $_POST["studentEmail"];
    } else {
        $error_message = "Invalid student email. Format must be NN-NNNNN-N@student.aiub.edu.<br>";
    }

    // Set bookTitle and cookie
    if (isset($_POST["bookTitle"])) {
        $bookTitle = $_POST["bookTitle"];
        $cookie_name = str_replace(" ", "", $bookTitle);
        $cookie_value = $_POST["studentName"];
    }

    include('./utils.php');
    
    if (isset($_POST["borrowDate"], $_POST["returnDate"])) {
        $borrow_date = $_POST["borrowDate"];
        $return_date = $_POST["returnDate"];
        $token = isset($_POST["token"]) ? $_POST["token"] : null;

        $borrowDate = new DateTime($borrow_date);
        $returnDate = new DateTime($return_date);

        if(empty($error_message)){
            if ($borrowDate < $returnDate) {
                $dateDifference = date_diff($borrowDate, $returnDate);
    
                if ($dateDifference->days <= 10) {
                    setcookie($cookie_name, $cookie_value, time() + 10);
                    echo "<p style='color: green;'>Book borrowed successfully for {$dateDifference->days} days.</p>";
                } else {
                    if ($token && validateToken($token)) {
                        // setcookie($cookie_name, $cookie_value, time() + (60*60*24* $dateDifference->days));
                        setcookie($cookie_name, $cookie_value, time() + 10);
                        echo "<p style='color: green;'>Book borrowed successfully for {$dateDifference->days} days with token verification.</p>";
                    } else {
                        $error_message = "Borrowing for more than 10 days requires a valid token.<br>";
                    }
                }
            } else {
                $error_message = "Return date must be after the borrow date.<br>";
            }
        }
    }

    // Check if the book is already borrowed using cookies
    if (isset($_COOKIE[$cookie_name])) {
        foreach ($_COOKIE as $cookieName => $cookieValue) {
            if ($cookieName == $cookie_name) {
                $error_message .= "Sorry, this book is already borrowed.<br>";
                break;
            }
        }
    }
    
    $jsonFile = 'bookInfo.json';

    if (file_exists($jsonFile)) {
        $jsonData = file_get_contents($jsonFile);
        $jsonArray = json_decode($jsonData, true);
    
        foreach ($jsonArray as $borrowInfo) {
            if ($borrowInfo['token'] === $token) {
                $error_message .= "The token is already in use for another book borrowing.<br>";
                break;
            }
        }
    } else {
        $jsonArray = array();
    }
    
    // send data to json
    if (empty($error_message)) {
        $formData = array(
            'name' => $studentName,
            'student_Id' => $studentID,
            'student_email' => $studentEmail,
            'bookTitle' => $bookTitle,
            'borrow_date' => $borrow_date,
            'token' => $token,
            'return_date' => $return_date,
            'fees' => $_POST["fees"],
        );
    
        $jsonArray[] = $formData;
    
        if (file_put_contents($jsonFile, json_encode($jsonArray))) {
            echo "Data successfully saved to JSON file!";
        } else {
            echo "Error saving data to JSON file!";
        }
    } 
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
            if($error_message)
            {
                echo "<p style='color: red;'>$error_message</p>";
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
                        <h3>Fees: '.$_POST["fees"].'</h3>
                    </div>';
            }
        ?>
    </div>
</body>
</html>
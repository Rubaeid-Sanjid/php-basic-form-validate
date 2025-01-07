<?php 
    if(isset($_POST['addBook'])){
        $conn = mysqli_connect("localhost", "root", "", "booksInfo");

        if($conn){

            $bookName = $_POST['bookName'];
            $authorName = $_POST['authorName'];
            $quantity = $_POST['quantity'];

            $sql = "INSERT INTO booksInfo (book_Name, author_Name, quantity) VALUES ('$bookName', '$authorName', '$quantity')";

            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);

            
        }
    }
?>
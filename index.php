<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Form Validation</title>
</head>

<body>
    <main>
        <aside class="left-box">
            <?php
            $jsonData = file_get_contents('bookInfo.json');
            $jsonArray = json_decode($jsonData, true);

            foreach ($jsonArray as $item) {
                if (isset($item['token'])) {
                    echo 'Token: ' . $item["token"] . '<br>';
                }
            }
            ?>
        </aside>

        <div>
            <section>
                <div class="box1">
                    <h2 style="text-align: center;">All Available Books</h2>

                    <div class="allbooks">
                        <?php
                        include('connect.php');

                        $sql = 'SELECT * FROM booksInfo';

                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            $allBooks = mysqli_fetch_all($result, MYSQLI_ASSOC);

                            foreach ($allBooks as $book) {
                                echo '<div class="bookCart">
                                        <h4>Book Name: ' . $book['book_Name'] . '</h4>
                                        <h4>Author Name: ' . $book['author_Name'] . '</h4>
                                        <h4>Quantity: ' . $book['quantity'] . '</h4>
                                    </div> ';
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="box1">
                    <h2 style="text-align: center;">Update Books</h2>

                    <form action="" method="get" class="bookFormRow">
                            <label for="bookName">Search</label>
                            <input class="input" type="text" name="searchValue" id="bookName">
                            <input class="input" type="submit" name="searchBook" value="Search Book">
                    </form>

                    <form action="bookProcess.php" method="post" style="display: flex; flex-direction: column; gap: 10px;">

                        <?php
                        if (isset($_GET['searchBook'])) {
                            include('connect.php');

                            $searchValue = mysqli_real_escape_string($conn, $_GET['searchValue']);

                            $sql = is_numeric($searchValue)
                                ? "SELECT * FROM booksInfo WHERE id=$searchValue"
                                : "SELECT * FROM booksInfo WHERE book_Name='$searchValue'";

                            $result = mysqli_query($conn, $sql);
                            $book = mysqli_fetch_assoc($result);

                            if ($book) {
                                $bookId = $book['id'];
                                $bookName = $book['book_Name'];
                                $authorName = $book['author_Name'];
                                $quantity = $book['quantity'];
                        ?>
                                <input type="hidden" name="bookId" value="<?php echo $bookId; ?>">

                                <div class="bookFormRow">
                                    <label for="bookName">Book Name:</label>
                                    <input class="input" type="text" name="bookName" id="bookName" value="<?php echo $bookName; ?>">
                                </div>
                                <div class="bookFormRow">
                                    <label for="authorName">Author Name:</label>
                                    <input class="input" type="text" name="authorName" id="authorName" value="<?php echo $authorName; ?>">
                                </div>
                                <div class="bookFormRow">
                                    <label for="quantity">Quantity:</label>
                                    <input class="input" type="text" name="quantity" id="quantity" value="<?php echo $quantity; ?>">
                                </div>
                                <div class="bookFormRow">
                                    <input class="input" type="submit" name="updateBook" value="Update Book">
                                </div>
                        <?php
                            }
                        }
                        ?>

                    </form>
                </div>

                <div class="box1">
                    <h2 style="text-align: center;">Add Books</h2>

                    <form action="bookProcess.php" method="post" style="display: flex; flex-direction: column; gap: 10px;">
                        <div class="bookFormRow">
                            <label for="bookName">Book Name:</label>
                            <input class="input" type="text" name="bookName" id="bookName">
                        </div>
                        <div class="bookFormRow">
                            <label for="authorName">Author Name:</label>
                            <input class="input" type="text" name="authorName" id="authorName">
                        </div>
                        <div class="bookFormRow">
                            <label for="quantity">Quantity:</label>
                            <input class="input" type="text" name="quantity" id="quantity">
                        </div>
                        <div class="bookFormRow">
                            <input class="input" type="submit" name="addBook" value="Add Book">
                        </div>
                    </form>

                </div>
            </section>

            <section class="section2">
                <div class="box2"></div>
                <div class="box2"></div>
                <div class="box2"></div>
            </section>

            <section class="section2">
                <div>
                    <form class="form" action="process.php" method="post">
                        <h2>Book Borrow Form</h2>
                        <input class="input" type="text" name="studentName" placeholder="Student Name">
                        <input class="input" type="text" name="studentID" placeholder="Student ID">
                        <input class="input" type="email" name="studentEmail" placeholder="Email">
                        <!-- <input class="input" type="text" name="bookTitle" placeholder="Book Title"> -->
                        <select name="bookTitle" id="" class="input">
                            <option value="Book1">Select Book</option>
                            <?php
                            foreach ($allBooks as $book) {
                                echo '<option value="' .$book['book_Name']. '">' .$book['book_Name']. '</option>';
                            }                            
                            ?>
                            <!-- <option value="Book1">Book 1</option>
                            <option value="Book2">Book 2</option>
                            <option value="Book3">Book 3</option>
                            <option value="Book4">Book 4</option> -->
                        </select>
                        <input class="input" type="date" name="borrowDate" placeholder="Borrow Date">
                        <input class="input" type="text" name="token" placeholder="Token">
                        <input class="input" type="date" name="returnDate" placeholder="Return Date">
                        <input class="input" type="number" name="fees" placeholder="Fees">
                        <input class="input" type="submit" name="submit" value="submit">
                    </form>
                </div>

                <div class="box2"></div>
            </section>
        </div>

        <aside class="right-box">
            <img src="./images//21-45844-3.PNG" alt="student ID" width="200px">
        </aside>
    </main>

</body>

</html>
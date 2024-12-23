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
        <aside class="left-box"></aside>

        <div>
            <section>
                <div class="box1"></div>
                <div class="box1"></div>
                <div class="box1"></div>
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
                        <input class="input" type="text" name="bookTitle" placeholder="Book Title">
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
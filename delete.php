<!--
Name: Qing XU, Zhenzheng Qi, Olivia Niu
Date: Aug 7, 2023
Section: CST 8285 section 313
Description: This is the delete page for group work assignment2.
-->

<?php
// Include studentDAO file
require_once('./dao/studentDAO.php');

session_start();

// Check if user is not logged in
if (!isset($_SESSION['email'])) {
    header('Location: index.php'); // Redirect to login page
    exit();
}

// Process delete operation after confirmation
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    $studentDAO = new studentDAO();
    $studentId = trim($_POST["id"]);
    $result = $studentDAO->deletestudent($studentId);
    if ($result) {
        header("location: dashboard.php");
        exit();
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5 mb-3">Delete Record</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>" />
                            <p>Are you sure you want to delete this student record?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="dashboard.php" class="btn btn-secondary ml-2">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
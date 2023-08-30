<!--
Name: Qing XU, Zhenzheng Qi, Olivia Niu
Date: Aug 7, 2023
Section: CST 8285 section 313
Description: This is the read page for group work assignment2.
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

$studentDAO = new studentDAO();

// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Get URL parameter
    $id = trim($_GET["id"]);
    $student = $studentDAO->getStudent($id);

    if ($student) {
        // Retrieve individual field value
        $firstName = $student->getFirstName();
        $lastName = $student->getLastName();
        $country = $student->getCountry();
        $studentNumber = $student->getStudentNumber();
        $pic = $student->getPic();
        $date = $student->getDate();
    } else {
        // URL doesn't contain valid id. Redirect to error page
        header("location: error.php");
        exit();
    }
} else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}

// Close connection
$studentDAO->getMysqli()->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <p><img src='./imgs/<?php echo $pic; ?>' alt='<?php echo $pic; ?>' width='150px'
                                height='200px' /></p>
                    </div>
                    <div class="form-group">
                        <label>FirstName</label>
                        <p><b>
                                <?php echo $firstName; ?>
                            </b></p>
                    </div>
                    <div class="form-group">
                        <label>LastName</label>
                        <p><b>
                                <?php echo $lastName; ?>
                            </b></p>
                    </div>
                    <div class="form-group">
                        <label>country</label>
                        <p><b>
                                <?php echo $country; ?>
                            </b></p>
                    </div>
                    <div class="form-group">
                        <label>StudentNumber</label>
                        <p><b>
                                <?php echo $studentNumber; ?>
                            </b></p>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <p><b>
                                <?php echo $date; ?>
                            </b></p>
                    </div>
                    <p><a href="dashboard.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
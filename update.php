<!--
Name: Qing XU, Zhenzheng Qi, Olivia Niu
Date: Aug 7, 2023
Section: CST 8285 section 313
Description: This is the update page for group work assignment2.
-->

<?php
// Include animalDAO file
require_once('./dao/studentDAO.php');

session_start();

// Check if user is not logged in
if (!isset($_SESSION['email'])) {
    header('Location: index.php'); // Redirect to login page
    exit();
}

// Define variables and initialize with empty values
$firstName = $lastName = $country = $studentNumber = $pic = $date = "";
$firstName_err = $lastName_err = $country_err = $studentNumber_err = $pic_err = $date_err = "";

$studentDAO = new studentDAO();

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    // Validate first name
    $input_firstName = trim($_POST["firstName"]);
    if (empty($input_firstName)) {
        $firstName_err = "Please enter a first name.";
    } elseif (!filter_var($input_firstName, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $firstName_err = "Please enter a valid first name.";
    } else {
        $firstName = $input_firstName;
    }

    // Validate lastName
    $input_lastName = trim($_POST["lastName"]);
    if (empty($input_lastName)) {
        $lastName_err = "Please enter a last name.";
    } elseif (!filter_var($input_lastName, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $lastName_err = "Please enter a valid last name.";
    } else {
        $lastName = $input_lastName;
    }

    // Validate origin 
    $input_country = trim($_POST["country"]);
    if (empty($input_country)) {
        $country_err = "Please enter the country.";
    } else {
        $country = $input_country;
    }

    // Validate number
    $input_studentNumber = trim($_POST["studentNumber"]);
    if (empty($input_studentNumber)) {
        $studentNumber_err = "Please enter the student number.";
    } elseif (!ctype_digit($input_studentNumber)) {
        $studentNumber_err = "Please enter a positive integer value.";
    } else {
        $studentNumber = $input_studentNumber;
    }

    // Validate Picture
    if (isset($_FILES['pic'])) {
        $errors = array();
        $file_name = $_FILES['pic']['name'];
        $file_size = $_FILES['pic']['size'];
        $file_tmp = $_FILES['pic']['tmp_name'];
        $file_type = $_FILES['pic']['type'];

        // $file_ext=strtolower(end(explode('.',$_FILES['pic']['name'])));

        // $expensions= array("jpeg","jpg","png");

        // if(in_array($file_ext,$expensions)=== false){
        //     $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        // }

        if ($_FILES['pic']['size'] > 2097152) {
            $errors = 'Faild to upload: File size must be excately 2 MB';
        }

        if (empty($errors) == true && isset($_FILES['pic'])) {
            move_uploaded_file($file_tmp, "imgs/" . $_FILES['pic']['name']);
            echo "File Successfully uploaded";
            $pic = $file_name;
        } else {
            $pic_error = 'Error Alert!';
            print($errors);
        }
    }

    // Validate date
    $date = date("Y-m-d");

    // Check input errors before inserting in database
    if (empty($firstName_err) && empty($lastName_err) && empty($country_err) && empty($studentNumber_err) && empty($pic_err) && empty($date_err)) {
        $student = new student($id, $firstName, $lastName, $country, $studentNumber, $pic, $date);
        $result = $studentDAO->updatestudent($student);
        header("refresh:2; url=dashboard.php");
        echo '<br><h6 style="text-align:center">' . $result . '</h6>';
        // Close connection
        $studentDAO->getMysqli()->close();
    }

} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id = trim($_GET["id"]);
        $student = $studentDAO->getstudent($id);

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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the student record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post"
                        enctype="multipart/form-data">
                        <div class="form-group">
                            <label>FirstName</label>
                            <input type="text" name="firstName"
                                class="form-control <?php echo (!empty($firstName_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $firstName; ?>">
                            <span class="invalid-feedback">
                                <?php echo $firstName_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>LastName</label>
                            <input type="text" name="lastName"
                                class="form-control <?php echo (!empty($lastName_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $lastName; ?>">
                            <span class="invalid-feedback">
                                <?php echo $lastName_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>country</label>
                            <textarea name="country"
                                class="form-control <?php echo (!empty($country_err)) ? 'is-invalid' : ''; ?>"><?php echo $country; ?></textarea>
                            <span class="invalid-feedback">
                                <?php echo $country_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>StudentNumber</label>
                            <input type="text" name="studentNumber"
                                class="form-control <?php echo (!empty($studentNumber_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $studentNumber; ?>">
                            <span class="invalid-feedback">
                                <?php echo $studentNumber_err; ?>
                            </span>
                        </div>
                        <div class="form-group">
                            <label>pic</label>
                            <br>
                            <input type="file" name="pic" accept="image/jpg" class="form-control <?php echo (!empty($pic_err)) ? 'is-invalid' : ''; ?>> 
                            <span class=" invalid-feedback">
                            <?php echo $pic_err; ?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="dashboard.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
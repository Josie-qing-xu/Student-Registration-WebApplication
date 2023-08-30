<!--
Name: Qing XU, Zhenzheng Qi, Olivia Niu
Date: Aug 7, 2023
Section: CST 8285 section 313
Description: This is the index page for group work assignment2.
-->

<?php
// Include animalDAO file
require_once('./dao/adminDAO.php');

session_start();
session_destroy();

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    $email = trim($_POST["email"]);
    if (empty($email)) {
        $email_err = "Please enter a email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[^\s@]+@[^\s@]+\.[^\s@]+$/")))) {
        $email_err = "Please enter a valid email.";
    }

    // Validate password
    $password = trim($_POST["password"]);
    if (empty($password)) {
        $password_err = "Password could not be empty.";
    }

    // Check input errors before inserting in database
    if (empty($email_err) && empty($password_err)) {
        $adminDAO = new AdminDAO();
        $admin = new Admin($email, $password);
        $addResult = $adminDAO->validate($admin);
        if ($addResult == true) {
            session_start();
            // After successful login
            $_SESSION['email'] = $email;
            header("location: dashboard.php");
        } else {
            $email_err = "The email or password you entered was not valid.";
            $password_err = "The email or password you entered was not valid.";
        }
        // Close connection
        $adminDAO->getMysqli()->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Login Page</title>
</head>

<body>
    <div class="container">
        <h1>Login Page</h1>
        <hr>
        <a href="registration.php" class="btn btn-primary login-btn"><i class="fa fa-sign-in"></i>
            Register</a>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
            enctype="multipart/form-data">
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email"
                    class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $email; ?>">
                <span class="invalid-feedback">
                    <?php echo $email_err; ?>
                </span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password"
                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $password; ?>">
                <span class="invalid-feedback">
                    <?php echo $password_err; ?>
                </span>
            </div>
            <input type="submit" class="btn btn-primary" value="Login">
        </form>
    </div>
</body>

</html>
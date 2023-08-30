<!--
Name: Qing XU, Zhenzheng Qi, Olivia Niu
Date: Aug 7, 2023
Section: CST 8285 section 313
Description: This is the registration page for group work assignment2.
-->

<?php
// Include animalDAO file
require_once('./dao/adminDAO.php');

// Define variables and initialize with empty values
$email = $password = $password2 = "";
$email_err = $password_err = $password2_err = "";

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
    } elseif (
        !filter_var($password, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[a-z]/")))
        || !filter_var($password, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[A-Z]/")))
    ) {
        $password_err = "Password must contain at least one lowercase and one uppercase letter.";
    } elseif (strlen($password) < 6 || strlen($password) > 20) {
        $password_err = "Password must be between 6 and 20 characters.";
    }

    // Validate confirm password
    $password2 = trim($_POST["password2"]);
    if (empty($password2)) {
        $password2_err = "Re-Type Password could not be empty.";
    } elseif ($password != $password2) {
        $password2_err = "Password did not match.";
    }

    // Check input errors before inserting in database
    if (empty($email_err) && empty($password_err) && empty($password2_err)) {
        $adminDAO = new AdminDAO();
        $admin = new Admin($email, $password);
        $addResult = $adminDAO->addAdmin($admin);
        echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';
        if ($addResult == $email . ' added successfully!') {
            header("location: index.php");
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
    <title>Sign-Up Page</title>
</head>

<body>
    <div class="container">
        <h1>Sign-Up Page</h1>
        <hr>
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
            <div class="form-group">
                <label>Re-Type Password</label>
                <input type="password" name="password2"
                    class="form-control <?php echo (!empty($password2_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $password2; ?>">
                <span class="invalid-feedback">
                    <?php echo $password2_err; ?>
                </span>
            </div>
            <input type="submit" class="btn btn-primary" value="Sign-Up">
            <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
        </form>
    </div>
</body>

</html>
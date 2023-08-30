<!--
Name: Qing XU, Zhenzheng Qi, Olivia Niu
Date: Aug 7, 2023
Section: CST 8285 section 313
Description: This is the dashboard page for group work assignment2.
-->

<?php
require_once('./dao/studentDAO.php');

session_start();

// Check if user is not logged in
if (!isset($_SESSION['email'])) {
    header('Location: index.php'); // Redirect to login page
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="custom.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }

        table tr td:last-child {
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        // JavaScript code for search bar functionality
        function searchCourses() {
            var input = document.getElementById("search-input").value.toLowerCase();
            var rows = document.getElementsByClassName("student-row");

            for (var i = 0; i < rows.length; i++) {
                var firstname = rows[i].querySelector(".student-firstName").innerText.toLowerCase();
                var lastname = rows[i].querySelector(".student-lastName").innerText.toLowerCase();
                var country = rows[i].querySelector(".student-country").innerText.toLowerCase();
                var number = rows[i].querySelector(".student-number").innerText.toLowerCase();


                if (firstname.includes(input) || lastname.includes(input) || country.includes(input) || number.includes(input)) {
                    rows[i].style.display = "table-row";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }

        function filterByCountry() {
            var countryFilter = document.getElementById("country-filter").value.toLowerCase();
            var rows = document.getElementsByClassName("student-row");

            for (var i = 0; i < rows.length; i++) {
                var country = rows[i].querySelector(".student-country").innerText.toLowerCase();

                if (countryFilter === "" || country === countryFilter) {
                    rows[i].style.display = "table-row";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }

    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="animal">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix header-container">

                        <h2 class="header-title">Student Information</h2>
                        <div class="header-controls">
                            <a href="create.php" class="btn btn-success add-btn"><i class="fa fa-plus"></i> Add A New
                                Student</a>
                            
                            <input type="text" id="search-input" placeholder="Search" onkeyup="searchCourses()">
                            <select id="country-filter" onchange="filterByCountry()">
                                <option value="">All Countries</option>
                                <option value="Australia">Australia</option>
                                <option value="Canada">Canada</option>
                                <option value="China">China</option>
                                <option value="South Korea">South Korea</option>
                                <option value="United Kingdom">United Kingdom</option>
                            </select>
                            <a href="index.php" class="btn btn-primary login-btn"><i class="fa fa-sign-in"></i>
                                Logout</a>
                        </div>

                    </div>
                    <?php
                    $studentDAO = new studentDAO();
                    $student = $studentDAO->getStudents();

                    if ($student) {
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Pic</th>";
                        echo "<th>#</th>";
                        echo "<th>FirstName</th>";
                        echo "<th>LastName</th>";
                        echo "<th>Country</th>";
                        echo "<th>StudentNumber</th>";
                        echo "<th>Created/Updated</th>";
                        echo "<th>Action</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo '<tbody>';
                        foreach ($student as $student) {
                            echo '<tr class="student-row">';
                            echo "<td><img src='./imgs/" . $student->getPic() . "' alt='" . $student->getPic() . "' width='75px' height='100px'/></td>";
                            echo "<td>" . $student->getId() . "</td>";
                            echo '<td class="student-firstName">' . $student->getFirstName() . "</td>";
                            echo '<td class="student-lastName">' . $student->getLastName() . "</td>";
                            echo '<td class="student-country">' . $student->getCountry() . "</td>";
                            echo '<td class="student-number">' . $student->getStudentNumber() . "</td>";
                            echo "<td>" . $student->getDate() . "</td>";
                            echo "<td>";
                            echo '<a href="read.php?id=' . $student->getId() . '" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                            echo '<a href="update.php?id=' . $student->getId() . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                            echo '<a href="delete.php?id=' . $student->getId() . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        // Free result set
                        //$result->free();
                    } else {
                        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                    }

                    // Close connection
                    $studentDAO->getMysqli()->close();
                    include 'footer.php';
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
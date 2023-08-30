<?php
require_once('abstractDAO.php');
require_once('./model/student.php');

class studentDAO extends abstractDAO
{

    function __construct()
    {
        try {
            parent::__construct();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    public function getStudent($studentId)
    {
        $query = 'SELECT * FROM student WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $studentId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $temp = $result->fetch_assoc();
            $student = new student($temp['id'], $temp['firstName'], $temp['lastName'], $temp['country'], $temp['studentNumber'], $temp['pic'], $temp['date']);
            $result->free();
            return $student;
        }
        $result->free();
        return false;
    }


    public function getStudents()
    {
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM student');
        $students = array();

        if ($result->num_rows >= 1) {
            while ($row = $result->fetch_assoc()) {
                //Create a new student object, and add it to the array.
                $student = new student($row['id'], $row['firstName'], $row['lastName'], $row['country'], $row['studentNumber'], $row['pic'], $row['date']);
                $students[] = $student;
            }
            $result->free();
            return $students;
        }
        $result->free();
        return false;
    }

    public function addstudent($student)
    {

        if (!$this->mysqli->connect_errno) {
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = 'INSERT INTO student (firstName, lastName, country, studentNumber, pic, date) VALUES (?,?,?,?,?,?)';
            $stmt = $this->mysqli->prepare($query);
            if ($stmt) {
                $firstName = $student->getFirstName();
                $lastName = $student->getLastName();
                $country = $student->getCountry();
                $studentNumber = $student->getStudentNumber();
                $pic = $student->getPic();
                $date = $student->getDate();

                $stmt->bind_param(
                    'sssiss',
                    $firstName,
                    $lastName,
                    $country,
                    $studentNumber,
                    $pic,
                    $date
                );
                //Execute the statement
                $stmt->execute();

                if ($stmt->error) {
                    return $stmt->error;
                } else {
                    return $student->getFirstName() . ' added successfully!';
                }
            } else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error;
                return $error;
            }

        } else {
            return 'Could not connect to Database.';
        }
    }
    public function updatestudent($student)
    {

        if (!$this->mysqli->connect_errno) {
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = "UPDATE student SET firstName=?, lastName=?, country=?, studentNumber=?, pic=?, date=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if ($stmt) {
                $id = $student->getId();
                $firstName = $student->getFirstName();
                $lastName = $student->getLastName();
                $country = $student->getcountry();
                $studentNumber = $student->getStudentNumber();
                $pic = $student->getPic();
                $date = $student->getDate();

                $stmt->bind_param(
                    'ssssssi',
                    $firstName,
                    $lastName,
                    $country,
                    $studentNumber,
                    $pic,
                    $date,
                    $id
                );
                //Execute the statement
                $stmt->execute();

                if ($stmt->error) {
                    return $stmt->error;
                } else {
                    return $student->getFirstName() . ' updated successfully!';
                }
            } else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error;
                return $error;
            }

        } else {
            return 'Could not connect to Database.';
        }
    }

    public function deletestudent($studentId)
    {
        if (!$this->mysqli->connect_errno) {
            $query = 'DELETE FROM student WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $studentId);
            $stmt->execute();
            if ($stmt->error) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>
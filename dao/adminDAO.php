<?php
require_once('abstractDAO.php');
require_once('./model/admin.php');

class AdminDAO extends abstractDAO
{

    function __construct()
    {
        try {
            parent::__construct();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    public function validate($admin)
    {
        $query = 'SELECT * FROM admin WHERE email = ?';
        $stmt = $this->mysqli->prepare($query);
        $email = $admin->getEmail();
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $temp = $result->fetch_assoc();
            $admin_in_db = new Admin($temp['email'], $temp['password']);
            $result->free();
            $hashed_password = $admin_in_db->getPassword();
            if (password_verify($admin->getPassword(), $hashed_password)) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function addAdmin($admin)
    {
        if (!$this->mysqli->connect_errno) {
            $query = 'INSERT INTO admin (email, password) VALUES (?,?)';
            $stmt = $this->mysqli->prepare($query);
            if ($stmt) {
                $email = $admin->getEmail();
                $password = $admin->getPassword();

                $stmt->bind_param(
                    'ss',
                    $email,
                    password_hash($password, null)
                );
                //Execute the statement
                $stmt->execute();

                if ($stmt->error) {
                    return $stmt->error;
                } else {
                    return $admin->getEmail() . ' added successfully!';
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
}
?>
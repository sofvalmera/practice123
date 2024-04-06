<?php

include_once (__DIR__ . '/../database/dbconnection.php');

class User extends Dbconnection {
    public $conn;

    // public function __construct() {
    //     $this->conn = new Dbconnection();
    // }

    public function insertUser(array $insertdata) {
        // if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        //     return ['message' => 'POST method only allowed'];
        // } else {
            $data = ['fname', 'lname', 'email', 'password', 'token'];
            $count = count($data);
    
            for ($i = 0; $i < $count; $i++) {
                $key = $data[$i];
                if (empty($insertdata[$key])) {
                    return ['message' => "{$key} is required!"];
                // }
            }
    
            $fname = $insertdata['fname'];
            $lname = $insertdata['lname'];
            $email = $insertdata['email'];
            $password = $insertdata['password'];
            $token = $insertdata['token'];
    
            $this->conn->init();
            $checksql = $this->conn->query("SELECT * FROM users WHERE email = '$email' ");
            if ($checksql->num_rows > 0) {
                return ['message' => 'Email already exists!'];
            } else {
                $prepare = $this->conn->prepare("INSERT INTO users (fname,lname,email,password,token) VALUES (?, ?, ?, ?, ?)");
                $prepare->bind_param("sssss", $fname, $lname, $email, $password, $token);
                $ifinsert = $prepare->execute();
                $prepare->close();
    
                if ($ifinsert) {
                    return ['message' => 'Inserted Successfully!'];
                } else {
                    return ['message' => 'Insert failed!'];
                }
            }
        }
    }
    

    public function getAllUsers() {
        // if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        //     return ['message' => 'GET method only allowed'];
        // } else
        // {

        // }
         
            $this->conn->init();
            $data = $this->conn->query("SELECT * FROM users");
            $result = $data->fetch_all(MYSQLI_ASSOC);
            return $result;
        
    }

    public function searchusers(array $search) {
        // if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        //     return ['message' => 'GET method only allowed'];
        // } else {
            if (empty($search['email'])) {
                return json_encode(['message' => 'Please provide email.']);
            }
            
            $email = $_GET['email'] ?? null;
            // init db
            $getemail = "%$email%";
        $prepare = $this->conn->prepare("SELECT * FROM users WHERE email LIKE ? ");
       $prepare->bind_param('s',$getemail);
        $prepare->execute();
        $data = $stmt->get_result();
        $datas = $data->fetch_all(MYSQLI_ASSOC);

            if ($data) {
                return $data;
            } else {
                return json_encode(['message' => 'No record found!']);
            }
        // }
    
   
       
    }
    public function deleteUser($userId) {
        $this->conn->init();
        $prepare = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $prepare->bind_param("i", $userId); 
        $ifDeleted = $prepare->execute();
        $prepare->close();

        if ($ifDeleted) {
            return ['message' => 'Deleted Successfully!'];
        } else {
            return ['message' => 'Delete failed!'];
        }
    }
    public function updateUser($field, $value, $userId) {
        $allowedFields = ['fname', 'lname', 'email', 'password', 'token'];
        
        if (!in_array($field, $allowedFields)) {
            return ['message' => 'Invalid field to update.'];
        }
        
        $this->conn->init();
        $prepare = $this->conn->prepare("UPDATE users SET $field = ? WHERE id = ?");
        $prepare->bind_param("si", $value, $userId); 
        $ifUpdated = $prepare->execute();
        $prepare->close();

        if ($ifUpdated) {
            return ['message' => 'Updated Successfully!'];
        } else {
            return ['message' => 'Update failed!'];
        }
    }

}



<?php

include_once (__DIR__ . '/../database/dbconnection.php');
header("content-type:application/json");
class User extends Dbconnection {
    // public $conn;

    // public function __construct() {
    //     $this->conn = new Dbconnection();
    // }

    public function insertUser(array $insertdata) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['message' => 'POST method ra adto ka anis body x-ww'];
        } else {
            $data = ['fname', 'lname', 'email', 'password', 'token'];
    
            foreach ($data as $key) {
                if (empty($insertdata[$key])) {
                    return ['message' => "{$key} is required tarungag fill up!"];
                }
            }
    
            $fname = $insertdata['fname'];
            $lname = $insertdata['lname'];
            $email = $insertdata['email'];
            $password = $insertdata['password'];
            $token = $insertdata['token'];
            // $created_at = date('Y-M-D H:i:s');
            // $updated_at = date('Y-M-D H:i:s');

    
            // Initialize db connection
            // $this->conn->init(); // Uncomment if necessary
    
            $checksql = $this->conn->query("SELECT * FROM users WHERE email = '$email' ");
            if ($checksql->num_rows > 0) {
                return ['message' => 'Email already exists!'];
            } 
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
    
    
    

        public function getAllUsers() {
             // $this->conn->init();
            if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
                return ['message' => 'GET method only allowed'];
            }
        
           
        
            $data = $this->conn->query("SELECT * FROM users");
            $result = $data->fetch_all(MYSQLI_ASSOC);
        
          
            if (empty($result)) {
                return ['message' => 'No users found'];
            }
        
            return $result;
        
        
        
    }

   
    public function searchusers(array $search) {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return ['message' => 'GET method only allowed'];
        } 
        
        if (empty($search['email'])) {
            return ['message' => 'Please provide email.'];
        }
        
        // Get the email parameter from the search array
        $email = $search['email'] ?? null;
        // Prepare the email pattern for SQL LIKE clause
        $pattern = "%$email%";
        
        // Prepare and execute the SQL statement
        $prepare = $this->conn->prepare("SELECT * FROM users WHERE email LIKE ?");
        $prepare->bind_param('s', $pattern);
        $prepare->execute();
        
        // Get the result set
        $result = $prepare->get_result();
        
        // Fetch all rows from the result set
        $datas = $result->fetch_all(MYSQLI_ASSOC);
    
        // Check if any records were found
        if ($datas) {
            return $datas; // Return the records
        } else {
            return ['message' => 'No records found!']; // No records found
        }
    }
    
    public function deleteUser($userId) {
        // $this->conn->init();
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



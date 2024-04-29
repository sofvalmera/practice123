<?php

include_once (__DIR__ . '/../database/dbconnection.php');
header("content-type:application/json");
class User extends Dbconnection {
  

    public function getAllUsers() {
           
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

    public function insertUser(array $insertdata) {
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
        // }
    }
    public function delete($id){
        $prepare = $this->conn->prepare("DELETE FROM users WHERE id = ?");
                $prepare->bind_param("i", $id);
                $ifinsert = $prepare->execute();
                $prepare->close();
    
                if ($ifinsert) {
                    return ['message' => 'Delete Successfully!'];
                } else {
                    return ['message' => 'Delete failed!'];
                
            }
    }
    
    
    

      

   
    public function searchusers(string $search) {
        // if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        //     return ['message' => 'GET method only allowed'];
        // } 
        
        if (empty($search)) {
            return ['message' => 'Please provide email.'];
        }
        
       
        $email = $search ?? null;
        $emails = "%$email%";

        $prepare = $this->conn->prepare("SELECT * FROM users WHERE email LIKE ?");
        $prepare->bind_param('s', $emails);
        $prepare->execute();
        $result = $prepare->get_result();
        $datas = $result->fetch_all(MYSQLI_ASSOC);
    
        
        if ($datas) {
            return $datas; 
        } else {
            return ['message' => 'No records found!']; 
        }
    }
    
}


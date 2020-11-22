<?php
class User {
    private $db;
    public $user;
    public $email;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function login($pwd, $em) {
        $password = md5(addslashes($pwd));
        $email = addslashes($em);

        $sql = "SELECT * FROM users WHERE email = :email";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':email', $email);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $response = $sql->fetch();

            if ($response['password'] === crypt($password, $response['password'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function register($usr, $em, $pwd) {
        $user = addslashes($usr);
        $email = addslashes($em);
        $password = md5(addslashes($pwd));
    
        if(!$this->verifyEmail($email)) {
            
            $cost = '08';
            $salt = bin2hex(random_bytes(11));
            $hash = crypt($password, '$2a$'.$cost.'$'.$salt.'$');

            $sql = "INSERT INTO users (user, email, password) VALUES (:user, :email, :password)";
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':user', $user);
            $sql->bindValue(':email', $email);
            $sql->bindValue(':password', $hash);
            $sql->execute();

            return true;
        } else {
            return false;
        }
    }

    public function editProfile($usr, $em, $id) {
        $user = addslashes($usr);
        $email = addslashes($em);

        $sql = "UPDATE users SET user = :user, email = :email WHERE id = :id";

        $sql = $this->db->prepare($sql);
        $sql->bindValue(':user', $user);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function editPassword($cPwd, $nPwd, $em, $id) {
        $email = addslashes($em);
        $cPassword = addslashes($cPwd);
        $nPassword = addslashes($nPwd);

        if ($this->login($cPassword, $email)) {
            $cost = '08';
            $salt = bin2hex(random_bytes(11));
            $hash = crypt(md5($nPassword), '$2a$'.$cost.'$'.$salt.'$'); 
            
            $sql = "UPDATE users SET password = :password WHERE id = :id";
    
            $sql = $this->db->prepare($sql);
            $sql->bindValue(':password', $hash);
            $sql->bindValue(':id', $id);
            $sql->execute();
            
            return true;
        } else {
            return false;
        }

    }

    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function getId($em) {
        $email = addslashes($em);

        $response = null;
        
        $sql = "SELECT id FROM users  WHERE email = :email";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':email', $email);
        $sql->execute();
    
        if ($sql->rowCount() > 0) {
            $resp = $sql->fetch();
            $response = $resp['id'];
        }

        return $response;
    }

    public function verifyId($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function setData($id) {
        $sql = "SELECT user,email FROM users WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
        
        $response = $sql->fetch();
        $this->user = $response['user'];
        $this->email = $response['email'];
    }

    private function verifyEmail($email) {
        $sql = "SELECT id FROM users WHERE email = :email";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':email', $email);
        $sql->execute();
    
        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
?>
<?php

class User
{
    protected $db;
    protected $id;

    public function __construct(Database $db, Int $id)
    {
        $this->db = $db->getConnexion();

            // Si un ID d'utilisateur est stocké en session, on le récupère
            if (isset($_SESSION['id'])) {
                $this->id = $id;
            }
    }

    public function createUser($login, $password)
    {   
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM user WHERE login = :login");
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $usernameExists = $stmt->fetchColumn();

        if ($usernameExists > 0) {
            echo "Ce nom d'utilisateur est déjà pris.";
        } else {
          
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO user (login, password) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $login);
            $stmt->bindParam(2, $hashedPassword);

            return $stmt->execute();
        }
    }


   public function selectUserById($id)
   {
       $query = "SELECT * FROM user WHERE id = :id";
       $stmt = $this->db->prepare($query);
       $stmt->bindParam(':id', $id, PDO::PARAM_INT);
       $stmt->execute();
  
       // Vérifie si l'utilisateur existe
       if ($stmt->rowCount() > 0) {
           return $stmt->fetch(PDO::FETCH_ASSOC); 
       } else {
           return null; // Aucun utilisateur trouvé
       }
    }

    public function updateUser($id, $new_login, $new_password)
    {   
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE user SET login = :login, password = :password WHERE id = :id";
        $params = [
            ':login' => $new_login,
            ':password' => $hashedPassword,
            ':id' => $id
        ];

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params); // Exécute la requête
    }

    public function connectUser($login, $password)
    {
        $sql = "SELECT password FROM user WHERE login = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1, $login);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $storedPassword = $stmt->fetchColumn();

            if (password_verify($password, $storedPassword)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function upDateUserbyId($id, $new_login, $new_password)
    {   
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE user SET login = :login, password = :password WHERE id = :id";
        $params = [
            ':login' => $new_login,
            ':password' => $hashedPassword,
            ':id' => $id
        ];

        try {
          
            $stmt = $this->db->prepare($query);
            
            $result = $stmt->execute($params);
            
            // Retourne le résultat de l'exécution (true ou false)
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour : " . $e->getMessage();
            return false;
        }
    }

    

}
?>
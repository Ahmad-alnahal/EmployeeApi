<?php
class Employee {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function create($empName, $age, $email) {
        $stmt = $this->db->prepare("INSERT INTO Employees (empName, email, age, phone) VALUES (?, ?, ?, ?)");
        $stmt->execute([$empName, $age, $email, $phone]);
        
        return $this->db->lastInsertId();
    }

    public function update($id, $empName, $age, $email) {
        $stmt = $this->db->prepare("UPDATE Employees SET empName = ?, email = ?, age = ?, phone = ? WHERE id = ?");
        $stmt->execute([$empName, $email, $age, $phone, $id]);
        
        return $stmt->rowCount();
    }
        
    public function get($id) {
        $stmt = $this->db->prepare("SELECT * FROM Employees WHERE id = ?");
        $stmt->execute([$id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Employees WHERE id = ?");
        $stmt->execute([$id]);
        
        return $stmt->rowCount();
    }
}
?>

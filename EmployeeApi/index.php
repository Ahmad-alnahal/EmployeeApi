<?php
require_once 'config.php';
require_once 'classes/Employee.php';

header('Content-Type: application/json');

$Employee = new Employee($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $empName = $_POST['empName'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];

    $Employee = $Employee->create($empName, $email, $age, $phone);
    echo json_encode(['id' => $Employee]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get a Employee by ID
    if (isset($_GET['id'])) {
        $Employee = $_GET['id'];
        $Employee = $Employee->get($Employee);
        
        if ($Employee) {
            echo json_encode($Employee);
        } else {
            echo json_encode(['error' => 'Employee not found']);
        }
    } else {
        
        $stmt = $db->query("SELECT * FROM Employees");
        $Employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($Employees);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $putParams);
    
    $Employee = $putParams['id'];
    $empName = $putParams['empName'];
    $email = $putParams['email'];
    $age = $putParams['age'];
    $phone = $putParams['phone'];

    
    $result = $Employee->update($Employee, $empName, $email, $age, $phone);
    
    if ($result) {
        echo json_encode(['success' => 'Employee updated successfully']);
    } else {
        echo json_encode(['error' => 'Failed to update Employee']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteParams);
    
    $Employee = $deleteParams['id'];
    
    $result = $Employee->delete($Employee);
    
    if ($result) {
        echo json_encode(['success' => 'Employee deleted successfully']);
    } else {
        echo json_encode(['error' => 'Failed to delete Employee']);
    }
}
?>

<?php
// reserve.php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture JSON payload
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Check if all fields are present
    if (!isset($data['room'], $data['customer_name'], $data['customer_email'], $data['customer_contact'], $data['check_in_date'], $data['check_out_date'], $data['total_price'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid or missing data.']);
        exit;
    }

    // Extract data
    $room = $data['room'];
    $customer_name = $data['customer_name'];
    $customer_email = $data['customer_email'];
    $customer_contact = $data['customer_contact'];
    $check_in_date = $data['check_in_date'];
    $check_out_date = $data['check_out_date'];
    $total_price = $data['total_price'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'hotelreservation');

    // Check connection
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
        exit;
    }

    // Insert data into the database
    $sql = "INSERT INTO reservations (room, customer_name, customer_email, customer_contact, check_in_date, check_out_date, total_price) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'SQL preparation failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param('ssssssd', $room, $customer_name, $customer_email, $customer_contact, $check_in_date, $check_out_date, $total_price);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Reservation successfully saved!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error executing query: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>

<?php
include('connection.php');

if(isset($_POST['order_id'])){
    $order_id = $_POST['order_id'];

    $sql = "SELECT * FROM orders WHERE order_id = $order_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();

        // Calculate percentage based on your variables
        $variableA = $order['is_paid_half'];
        $variableB = $order['order_confirm'];
        $variableC = $order['is_delivery_started'];
        $variableD = $order['is_delivery_finished'];
        $variableE = $order['is_paid_full'];

        $percentage = ($variableA + $variableB + $variableC + $variableD + $variableE) * 20;

        // Add the percentage to the order data
        $order['percentage'] = $percentage;

        // Return the data as JSON
        echo json_encode($order);
    } else {
        echo json_encode(['error' => 'Order not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>

<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);


header('Content-Type: application/json');


$data = json_decode(file_get_contents('php://input'), true);


if (empty($data)) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
    exit;
}

// Extract and sanitize the data
$roomId = filter_var($data['roomId'], FILTER_SANITIZE_NUMBER_INT);
$checkIn = filter_var($data['checkIn'], FILTER_SANITIZE_STRING);
$checkOut = filter_var($data['checkOut'], FILTER_SANITIZE_STRING);
$guests = filter_var_array($data['guests'], FILTER_SANITIZE_NUMBER_INT);
$total = filter_var($data['total'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

// Validate required fields
if (empty($roomId) || empty($checkIn) || empty($checkOut) || empty($guests) || empty($total)) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit;
}


try {

    $logData = [
        'roomId' => $roomId,
        'checkIn' => $checkIn,
        'checkOut' => $checkOut,
        'guests' => $guests,
        'total' => $total,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    file_put_contents('bookings.log', json_encode($logData) . PHP_EOL, FILE_APPEND);

    // Return a success response
    http_response_code(200); // OK
    echo json_encode(['status' => 'success', 'message' => 'Booking saved successfully']);
} catch (Exception $e) {
    // Handle any errors
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => 'error', 'message' => 'Failed to save booking: ' . $e->getMessage()]);
}

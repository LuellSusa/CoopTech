<?php
include 'conn.php';

$loan_type_id = $_GET['loan_type_id'];

$sql = "SELECT * FROM loan_options WHERE loan_type_id = $loan_type_id AND is_active = 1";
$result = mysqli_query($conn, $sql);

$options = [];
while ($row = mysqli_fetch_assoc($result)) {
    $options[] = $row;
}

header('Content-Type: application/json');
echo json_encode($options);
?>

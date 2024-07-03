<?php
include 'includes/connect.php';

$id = $_GET['id'];
$query = "SELECT name, price, image FROM items WHERE id = $id";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode([
        'name' => $row['name'],
        'price' => $row['price'],
        'image' => base64_encode($row['image']),
    ]);
} else {
    echo json_encode([]);
}

mysqli_close($con);
?>

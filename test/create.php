<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $photoName = "";
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $photoName = time() . "_" . rand(100000, 999999) . "." . pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $uploadPath = "uploads/" . $photoName;
        move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath);
    }

    $sql = "INSERT INTO test (Name, Email, PhoneNumber, Photo, Address)
            VALUES ('$name', '$email', '$phone', '$photoName', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Thêm khách hàng thành công!');
            window.location.href = 'index.php';
        </script>";
        exit;
    } else {
        echo " Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm khách hàng</title>
</head>
<body>
    <h2>Thêm khách hàng mới</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Họ tên</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email</label><br>
        <input type="email" name="email" required><br><br>

        <label>Số điện thoại</label><br>
        <input type="text" name="phone" required><br><br>

        <label>Ảnh đại diện</label><br>
        <input type="file" name="photo"><br><br>

        <label>Địa chỉ</label><br>
        <input type="text" name="address"><br><br>

        <button type="submit">Lưu khách hàng</button>
    </form>
</body>
</html>
<a href="index.php">← Quay về danh sách</a>
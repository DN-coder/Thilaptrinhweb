<?php
include 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Không tìm thấy ID khách hàng");
}

$sql = "SELECT * FROM test WHERE CustomerID = $id";
$result = $conn->query($sql);
$customer = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $_POST["name"];
    $email   = $_POST["email"];
    $phone   = $_POST["phone"];
    $address = $_POST["address"];

    $photo = $customer["Photo"];
    if (!empty($_FILES["photo"]["name"])) {
        $photo = time() . "_" . $_FILES["photo"]["name"];
        move_uploaded_file($_FILES["photo"]["tmp_name"], "uploads/" . $photo);
    }

    $sql = "UPDATE test SET 
                Name='$name', 
                Email='$email', 
                PhoneNumber='$phone', 
                Address='$address', 
                Photo='$photo' 
            WHERE CustomerID = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Cập nhật thành công!');
                window.location.href = 'index.php';
              </script>";
        exit;
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<h2>Sửa Khách Hàng</h2>
<form method="post" enctype="multipart/form-data">
    <label>Họ tên:</label><br>
    <input type="text" name="name" value="<?= $customer['Name'] ?>"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $customer['Email'] ?>"><br><br>

    <label>Số điện thoại:</label><br>
    <input type="text" name="phone" value="<?= $customer['Phonenumber'] ?>"><br><br>

    <label>Địa chỉ:</label><br>
    <input type="text" name="address" value="<?= $customer['Address'] ?>"><br><br>

    <label>Ảnh đại diện</label><br>
    <input type="file" name="photo"><br>
    <img src="uploads/<?= $customer['Photo'] ?>" width="100"><br><br>

    <button type="submit">Lưu</button>
</form>

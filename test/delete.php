<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = $conn->query("SELECT Photo FROM test WHERE CustomerID = $id");
    if ($result && $row = $result->fetch_assoc()) {
        $photo = $row['Photo'];
        if ($photo && file_exists("uploads/" . $photo)) {
            unlink("uploads/" . $photo); // xóa ảnh
        }
    }

    $sql = "DELETE FROM test WHERE CustomerID = $id";
   if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Xóa khách hàng thành công!');
            window.location.href = 'index.php';
        </script>";
        exit;
    } else {
        echo " Lỗi: " . $conn->error;
    }
}
?>

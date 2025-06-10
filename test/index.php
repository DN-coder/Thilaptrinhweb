<?php include 'db.php'; ?>
<h2><a href="index.php">Danh sách khách hàng</a></h2>
<a href="create.php">Thêm mới</a>

<form method="get" action="">
    <input type="text" name="q" placeholder="Tìm theo tên hoặc email" value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
    <button type="submit">Tìm</button>
</form>

<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
    <div style="padding: 10px; background: #f8d7da; color: #721c24; margin-bottom: 15px;">
        Đã xóa khách hàng thành công.
    </div>
<?php endif; ?>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th><th>Tên</th><th>Email</th><th>Ảnh</th><th>Số điện thoại</th><th>Địa chỉ</th><th>Hành động</th>
        <th>Ngày tạo</th><th>Ngày cập nhật</th>
    </tr>

    <?php
    $search = isset($_GET['q']) ? trim($_GET['q']) : '';

    if ($search != '') {
        $stmt = $conn->prepare("SELECT * FROM test WHERE Name LIKE ? OR Email LIKE ?");
        $likeSearch = "%{$search}%";
        $stmt->bind_param("ss", $likeSearch, $likeSearch);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query("SELECT * FROM test");
    }

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['CustomerID']}</td>
            <td>{$row['Name']}</td>
            <td>{$row['Email']}</td>
            <td><img src='uploads/{$row['Photo']}' width='50'></td>
            <td>{$row['Phonenumber']}</td>
            <td>{$row['Address']}</td>
            <td>
                <a href='edit.php?id={$row['CustomerID']}'>Sửa</a> |
                <a href='delete.php?id={$row['CustomerID']}' onclick=\"return confirm('Xoá?')\">Xoá</a>
            </td>
            <td>{$row['CreatedAt']}</td>
            <td>{$row['UpdatedAt']}</td>
        </tr>";
    }
    ?>
<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
    <div style="padding: 10px; background: #f8d7da; color: #721c24; margin-bottom: 15px;">
     Đã xóa khách hàng thành công.
    </div>
<?php endif; ?>
</table>

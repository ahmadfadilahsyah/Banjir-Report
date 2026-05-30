<?php
include 'koneksi.php';
$password_hash = password_hash('admin', PASSWORD_DEFAULT);
$conn->query("DELETE FROM admin WHERE username='bpbd'");
$conn->query("INSERT INTO admin (username, password) VALUES ('bpbd', '$password_hash')");
echo "✅ Password admin telah direset.<br>";
echo "Username: <strong>bpbd</strong><br>";
echo "Password: <strong>admin</strong><br>";
echo "Silakan <a href='admin/login_admin.php'>Login disini</a>";
?>
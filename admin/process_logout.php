<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Kirim respon JSON ke fetch()
header('Content-Type: application/json');
echo json_encode(['status' => 'success']);
exit;
?>

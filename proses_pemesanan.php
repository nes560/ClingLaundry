<?php
session_start(); // Memulai session untuk menyimpan pesan sukses
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama     = htmlspecialchars($_POST['nama_pelanggan']);
    $telepon  = htmlspecialchars($_POST['nomor_telepon']);
    $alamat   = htmlspecialchars($_POST['alamat']);
    $layanan  = htmlspecialchars($_POST['jenis_layanan']);
    $jumlah   = htmlspecialchars($_POST['jumlah']);
    $catatan  = htmlspecialchars($_POST['catatan']);

    // Menggunakan Prepared Statements agar lebih aman (Standar Mahasiswa IT)
    $stmt = $conn->prepare("INSERT INTO pesanan (nama_pelanggan, nomor_telepon, alamat, jenis_layanan, jumlah, catatan) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nama, $telepon, $alamat, $layanan, $jumlah, $catatan);

    if ($stmt->execute()) {
        // Jika berhasil, simpan pesan di session dan alihkan halaman
        $_SESSION['pesan_sukses'] = "Pesanan berhasil dikirim! Kami akan segera menghubungi Anda.";
        header("Location: index.php"); 
        exit(); 
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    mysqli_close($conn);
}
?>
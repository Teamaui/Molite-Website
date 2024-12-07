<?php

/**
 * Script untuk mengirim email menggunakan PHPMailer.
 *
 * @copyright  Copyright (c) 2024
 * @license    LGPL 2.1 (https://www.gnu.org/licenses/old-licenses/lgpl-2.1.html)
 * 
 * PHPMailer adalah library open source untuk mengirim email melalui protokol SMTP.
 * Untuk detail lebih lanjut, kunjungi: https://github.com/PHPMailer/PHPMailer
 * 
 * Hak cipta untuk kode asli PHPMailer dimiliki oleh tim pengembang PHPMailer.
 * Script ini memodifikasi PHPMailer untuk kebutuhan khusus pengguna.
 */

namespace App\Model;

use App\Helper\DatabaseHelper;
use FlashMessageHelper;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class OtpModel
{

    private PDO $db;
    public function __construct()
    {
        $this->db = DatabaseHelper::getConnection();
    }

    public function sendEmail($data)
    {

        $mail = new PHPMailer(true);

        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("SELECT * FROM admin WHERE email = :email");
            $stmt->bindParam(":email", $data["email"]);
            $stmt->execute();
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                $this->clearOtpAdminById($admin["id_admin"]);

                $idOtp = $this->generateAutoIncrementIDAdmin();
                $kodeOtp = random_int(100000, 999999);

                $sql = "INSERT INTO otp_admin (id_otp, id_admin, kode_otp) VALUES (:id_otp, :id_admin, :kode_otp)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id_otp", $idOtp);
                $stmt->bindParam(":id_admin", $admin["id_admin"]);
                $stmt->bindParam(":kode_otp", $kodeOtp);

                $stmt->execute();

                $template = file_get_contents(__DIR__ . "/../View/Respon/otpTemplate.php");

                $placeholders = [
                    "{{USER_NAME}}" => $admin["nama_admin"],
                    "{{OTP_CODE}}" => $kodeOtp,
                    "{{USER_ID}}" => $admin["id_admin"]
                ];

                $emailBody = strtr($template, $placeholders);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'teamaui29@gmail.com';
                $mail->Password = 'nuil goun mqje uwbj';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('teamaui29@gmail.com', 'Molita');
                $mail->addAddress($data["email"]);
                $mail->isHTML(true);
                $mail->Subject = $data["subject"];
                $mail->Body = $emailBody;

                $mail->send();

                $this->db->commit();
                return $admin;
            } else {
                FlashMessageHelper::set("pesan_gagal", "Email yang anda masukkan belum terdaftar!");
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollBack();
            echo "<div class='error'>Email gagal dikirim. Kesalahan: {$mail->ErrorInfo}</div>";
            FlashMessageHelper::set("pesan_gagal", "Gagal kirim kode OTP!");
            return false;
        }
    }

    public function sendEmailOrangTua($data)
    {

        $mail = new PHPMailer(true);

        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("SELECT * FROM orang_tua WHERE email = :email AND username = :username");
            $stmt->bindParam(":email", $data["email"]);
            $stmt->bindParam(":username", $data["username"]);
            $stmt->execute();
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                $this->clearOtpOrangTuaById($admin["id_orang_tua"]);

                $idOtp = $this->generateAutoIncrementIDOrangTua();
                $kodeOtp = random_int(1000, 9999);

                $sql = "INSERT INTO otp_orang_tua (id_otp_orang_tua, id_orang_tua, kode_otp) VALUES (:id_otp_orang_tua, :id_orang_tua, :kode_otp)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(":id_otp_orang_tua", $idOtp);
                $stmt->bindParam(":id_orang_tua", $admin["id_orang_tua"]);
                $stmt->bindParam(":kode_otp", $kodeOtp);

                $stmt->execute();

                $template = file_get_contents(__DIR__ . "/../View/Respon/otpTemplateOrangTua.php");

                $placeholders = [
                    "{{USER_NAME}}" => "Ibu " . $admin["nama_ibu"] . " & " . "Bapak " . $admin["nama_ayah"],
                    "{{OTP_CODE}}" => $kodeOtp,
                    "{{USER_ID}}" => $admin["id_orang_tua"]
                ];

                $emailBody = strtr($template, $placeholders);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'teamaui29@gmail.com';
                $mail->Password = 'nuil goun mqje uwbj';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('teamaui29@gmail.com', 'Molita');
                $mail->addAddress($data["email"]);
                $mail->isHTML(true);
                $mail->Subject = $data["subject"];
                $mail->Body = $emailBody;

                $mail->send();

                $this->db->commit();

                return true;
            } else {
                FlashMessageHelper::set("pesan_gagal", "Email yang anda masukkan belum terdaftar!");
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollBack();
            echo "<div class='error'>Email gagal dikirim. Kesalahan: {$mail->ErrorInfo}</div>";
            FlashMessageHelper::set("pesan_gagal", "Gagal kirim kode OTP!");
            return false;
        }
    }

    public function reSendOtp($data)
    {
        $query = "DELETE FROM otp_admin WHERE id_admin = :id_admin";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id_admin", $data["id_admind"]);

        $stmt->execute();

        $stmt1 = $this->db->prepare("SELECT * FROM admin WHERE id_admin = :id_admin");
        $stmt1->bindParam(":id_admin", $data["id_admin"]);
        $stmt1->execute();

        $admin = $stmt1->fetch(PDO::FETCH_ASSOC);

        $data = [
            "email" => $admin["email"],
            "subject" => "Reset Kata Sandi Anda - Kode OTP Anda di Sini"
        ];

        return $this->sendEmail($data);
    }

    public function getOtpAdminById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM admin WHERE id_admin = :id_admin");
            $stmt->bindParam(":id_admin", $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
    }

    public function cekOtp($data)
    {
        $stmt = $this->db->prepare("SELECT * FROM otp_admin WHERE id_admin = :id_admin");
        $stmt->bindParam(":id_admin", $data["id_admin"]);
        $stmt->execute();

        $otpAdmin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($otpAdmin["kode_otp"] == $data["kodeOtp"]) {
            return true;
        } else {
            return false;
        }
    }

    public function cekOtpOrangTua($kodeOtp, $email)
    {

        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("SELECT id_orang_tua FROM orang_tua WHERE email = :email");
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $this->db->prepare("SELECT * FROM otp_orang_tua WHERE id_orang_tua = :id_orang_tua");
            $stmt->bindParam(":id_orang_tua", $data["id_orang_tua"]);
            $stmt->execute();

            $otpAdmin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($otpAdmin["kode_otp"] == $kodeOtp) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollBack();
        }
    }

    public function ubahSandiOrangTua($data)
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("SELECT id_orang_tua FROM orang_tua WHERE email = :email");
            $stmt->bindParam(":email", $data["email"]);
            $stmt->execute();

            $orangTua = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($orangTua["id_orang_tua"]) {
                $stmt = $this->db->prepare("SELECT kode_otp FROM otp_orang_tua WHERE kode_otp = :kode_otp AND id_orang_tua = :id_orang_tua");
                $stmt->bindParam(":kode_otp", $data["kodeOtp"]);
                $stmt->bindParam(":id_orang_tua", $orangTua["id_orang_tua"]);
                $stmt->execute();

                $otpOrangTua = $stmt->fetch(PDO::FETCH_ASSOC);

                if (isset($otpOrangTua["kode_otp"]) && $otpOrangTua["kode_otp"] == $data["kodeOtp"]) {

                    $passwordHash = password_hash($data["password"], PASSWORD_DEFAULT);

                    $stmt = $this->db->prepare("UPDATE orang_tua SET password = :password WHERE id_orang_tua = :id_orang_tua");
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":id_orang_tua", $orangTua["id_orang_tua"]);
                    $stmt->execute();

                    if ($stmt->execute()) {
                        $this->clearOtpOrangTuaById($orangTua["id_orang_tua"]);
                        $this->db->commit();
                        return true;
                    } else {
                        $this->db->rollBack();
                        return false;
                    }
                } else {
                    $this->db->rollBack();
                    return false;
                }
            } else {
                $this->db->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollBack();
        }
    }

    public function clearOtpAdminById($id)
    {
        $stmt = $this->db->prepare("DELETE FROM otp_admin WHERE id_admin = :id_admin");
        $stmt->bindParam(":id_admin", $id);
        $stmt->execute();
    }

    public function clearOtpOrangTuaById($id)
    {
        $stmt = $this->db->prepare("DELETE FROM otp_orang_tua WHERE id_orang_tua = :id_orang_tua");
        $stmt->bindParam(":id_orang_tua", $id);
        $stmt->execute();
    }

    public function updateSandiAdmin($data)
    {
        try {
            $this->db->beginTransaction();

            $this->clearOtpAdminById($data["id_admin"]);

            $passwordHash = password_hash($data["sandi1"], PASSWORD_DEFAULT);

            $stmt = $this->db->prepare("UPDATE admin SET password = :password WHERE id_admin = :id_admin");
            $stmt->bindParam(":id_admin", $data["id_admin"]);
            $stmt->bindParam(":password", $passwordHash);
            $stmt->execute();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    private function generateAutoIncrementIDAdmin()
    {
        // Query untuk mengambil nilai terakhir dari kolom ID di tabel orang tua
        $query = "SELECT id_otp FROM otp_admin ORDER BY id_otp DESC LIMIT 1";
        $stmt = $this->db->prepare($query);

        // Eksekusi query
        if ($stmt->execute()) {
            // Ambil hasil query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek apakah ada ID terakhir
            if ($row && isset($row['id_otp'])) {
                $lastId = $row['id_otp'];

                // Ambil bagian numerik dari format ID (contoh: OAM0000000001 -> 1)
                $num = (int)substr($lastId, 3);

                // Tambah 1 untuk ID selanjutnya
                $newNum = $num + 1;

                // Format ulang ID dengan leading zeros
                $newId = 'OAM' . str_pad($newNum, 10, '0', STR_PAD_LEFT);
            } else {
                // Jika tidak ada ID sebelumnya, mulai dari OAM0000000001
                $newId = 'OAM0000000001';
            }
        } else {
            // Jika query gagal dieksekusi, kembalikan nilai kosong atau lakukan penanganan error
            $newId = null; // atau throw new Exception("Gagal mengeksekusi query");
        }

        return $newId;
    }

    private function generateAutoIncrementIDOrangTua()
    {
        // Query untuk mengambil nilai terakhir dari kolom ID di tabel orang tua
        $query = "SELECT id_otp_orang_tua FROM otp_orang_tua ORDER BY id_otp_orang_tua DESC LIMIT 1";
        $stmt = $this->db->prepare($query);

        // Eksekusi query
        if ($stmt->execute()) {
            // Ambil hasil query
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek apakah ada ID terakhir
            if ($row && isset($row['id_otp_orang_tua'])) {
                $lastId = $row['id_otp_orang_tua'];

                // Ambil bagian numerik dari format ID (contoh: OTU0000000001 -> 1)
                $num = (int)substr($lastId, 3);

                // Tambah 1 untuk ID selanjutnya
                $newNum = $num + 1;

                // Format ulang ID dengan leading zeros
                $newId = 'OTU' . str_pad($newNum, 10, '0', STR_PAD_LEFT);
            } else {
                // Jika tidak ada ID sebelumnya, mulai dari OTU0000000001
                $newId = 'OTU0000000001';
            }
        } else {
            // Jika query gagal dieksekusi, kembalikan nilai kosong atau lakukan penanganan error
            $newId = null; // atau throw new Exception("Gagal mengeksekusi query");
        }

        return $newId;
    }
}

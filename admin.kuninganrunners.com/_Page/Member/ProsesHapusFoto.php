<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    // Memeriksa apakah request yang diterima adalah POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = [
            'success' => false,
            'message' => ''
        ];
        if(empty($SessionIdAkses)){
            $response['message'] = 'Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
            echo json_encode($response);
            exit;
        }else{
            //Validasi id_member tidak boleh kosong
            if(empty($_POST['id_member'])){
                $response['message'] = 'ID Member tidak boleh kosong';
                echo json_encode($response);
                exit;
            }else{
                //Variabel Lainnya
                $id_member=$_POST['id_member'];
                //Bersihkan Variabel
                $id_member=validateAndSanitizeInput($id_member);
                $foto=GetDetailData($Conn,'member','id_member',$id_member,'foto');
                $FotoBaru="";
                //Proses Update Data
                $sql = "UPDATE member SET 
                    foto = ?
                WHERE id_member = ?";
                // Menyiapkan statement
                $stmt = $Conn->prepare($sql);
                $stmt->bind_param('ss', $FotoBaru, $id_member);
                // Eksekusi statement dan cek apakah berhasil
                if ($stmt->execute()) {
                    $foto_path= '../../assets/img/Member/'.$foto.'';
                    $HapusFoto=unlink($foto_path);
                    $response['success'] = true;
                    $response['message'] = 'Foto member berhasil dihapus.';
                    echo json_encode($response);
                    exit;
                }else{
                    $response['message'] = 'Gagal memperbarui member. ' . $stmt->error;
                    echo json_encode($response);
                    exit;
                }
            }
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Metode request tidak valid.']);
    }
?>
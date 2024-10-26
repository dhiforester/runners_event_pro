<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $now=date('Y-m-d H:i');
    //Validasi Session Akses Masih ADa
    if(empty($SessionIdAkses)){
        echo '<option value="">Sesi akses Berakhir</option>';
    }else{
        if(empty($_POST['id_event'])){
            echo '<option value="">ID Event Kosong</option>';
        }else{
            $id_event=$_POST['id_event'];
            $id_event=validateAndSanitizeInput($id_event);
            $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_event_kategori FROM event_kategori WHERE id_event='$id_event'"));
            if(empty($jml_data)){
                echo '<option value="">Belum Ada Kategori</option>';
            }else{
                echo '<option value="">Pilih</option>';
                $query = mysqli_query($Conn, "SELECT id_event_kategori, kategori FROM event_kategori WHERE id_event='$id_event'");
                while ($data = mysqli_fetch_array($query)) {
                    $id_event_kategori= $data['id_event_kategori'];
                    $kategori= $data['kategori'];
                    echo '<option value="'.$id_event_kategori.'">'.$kategori.'</option>';
                }
            }
        }
    }
?>
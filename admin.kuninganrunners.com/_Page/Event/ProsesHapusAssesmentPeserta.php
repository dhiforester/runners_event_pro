<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    $response = ['success' => false, 'message' => ''];
    $errors = []; 
    if(empty($SessionIdAkses)){
        $errors[]='Sesi Akses Sudah Berakhir, Silahkan Login Ulang';
    }else{
        //Validasi id_event_assesment tidak boleh kosong
        if(empty($_POST['id_event_assesment'])){
            $errors[]='ID Assesment Peserta tidak boleh kosong';
        }else{
            //Variabel Lainnya
            $id_event_assesment=$_POST['id_event_assesment'];
            //Bersihkan Variabel
            $id_event_assesment=validateAndSanitizeInput($id_event_assesment);
            //Buka Apa Tipenya
            $id_event_assesment_form=GetDetailData($Conn,'event_assesment','id_event_assesment',$id_event_assesment,'id_event_assesment_form');
            $assesment_value=GetDetailData($Conn,'event_assesment','id_event_assesment',$id_event_assesment,'assesment_value');
            $form_type=GetDetailData($Conn,'event_assesment_form','id_event_assesment_form',$id_event_assesment_form,'form_type');
            //Jika Tipenya file_foto atau file_pdf, hapus filenya
            if($form_type=='file_pdf'||$form_type=='file_foto'){
                $file_foto_path="../../assets/img/Assesment/$assesment_value";
                $HapusFile=unlink($file_foto_path);
            }
            //Proses hapus data
            $HapusAssesmentPeserta = mysqli_query($Conn, "DELETE FROM event_assesment WHERE id_event_assesment='$id_event_assesment'") or die(mysqli_error($Conn));
            if ($HapusAssesmentPeserta) {
                $kategori_log="Event";
                $deskripsi_log="Hapus Assesment Peserta";
                $InputLog=addLog($Conn,$SessionIdAkses,$now,$kategori_log,$deskripsi_log);
                if($InputLog=="Success"){
                    $response['success'] = true;
                }else{
                    $errors[]='Terjadi kesalahan pada saat menyimpan log aktivitas';
                }
            }else{
                $errors[]='Hapus Data Gagal';
            }
        }
    }
    if (!empty($errors)) {
        $response['message'] = implode('<br>', $errors);
        echo json_encode($response);
        exit;
    }else{
        echo json_encode($response);
    }
?>
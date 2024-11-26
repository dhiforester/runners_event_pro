<?php
    // Koneksi Dan Pengaturan lainnya
    include "_Config/Connection.php";
    include "_Config/GlobalFunction.php";
    include "_Config/SettingGeneral.php";
    include 'vendor/autoload.php';
    date_default_timezone_set("Asia/Jakarta");
    $now = date('Y-m-d H:i:s');
    if(empty($_GET['id'])){
        echo "ID Transaksi Tidak Boleh Kosong";
    }else{
        if(empty($_GET['format'])){
            echo "Format Cetak Tidak Boleh Kosong";
        }else{
            $kode_transaksi=$_GET['id'];
            $format=$_GET['format'];
            //Bersihkan Variabel
            $kode_transaksi=validateAndSanitizeInput($kode_transaksi);
            $format=validateAndSanitizeInput($format);
            //Validasi Kode Transaksi
            $kode_transaksi_validasi=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kode_transaksi');
            if(empty($kode_transaksi_validasi)){
                echo "Kode Transaksi Tidak Valid, Atau Tidak Ditemukan Pada Database";
            }else{
                $id_transaksi_pengiriman=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'id_transaksi_pengiriman');
                $no_resi=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'no_resi');
                if(empty($id_transaksi_pengiriman)){
                    echo "Kode Transaksi Tersebut Belum Memiliki Data Pengiriman";
                }else{
                    if(empty($no_resi)){
                        echo "Nomor Resi Tidak Boleh Kosong! Setidaknya Dalam Proses Cetak Ini, Nomor Resi Tidak Boleh Kosong!";
                    }else{
                        $no_resi=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'no_resi');
                        $kurir=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'kurir');
                        $asal_pengiriman=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'asal_pengiriman');
                        $tujuan_pengiriman=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'tujuan_pengiriman');
                        $status_pengiriman=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'status_pengiriman');
                        $datetime_pengiriman=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'datetime_pengiriman');
                        $ongkir=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'ongkir');
                        $link_pengiriman=GetDetailData($Conn,'transaksi_pengiriman','kode_transaksi',$kode_transaksi,'link_pengiriman');
                        if($format=="PDF"){
                            $mpdf = new \Mpdf\Mpdf([
                                'format' => 'A4', // Set ukuran kertas menjadi A4
                                'margin_left' => 20,  // Margin kiri
                                'margin_right' => 20, // Margin kanan
                                'margin_top' => 20,   // Margin atas
                                'margin_bottom' => 20, // Margin bawah
                                'margin_header' => 20, // Margin header
                                'margin_footer' => 20  // Margin footer
                            ]);
                            
                            $nama_dokumen = "Resi-$no_resi";
                            
                            // Tambahkan margin kecil untuk dokumen
                            $mpdf->SetMargins(20, 20, 20, 20);
                            
                            // Mulai buffer untuk menyimpan output HTML
                            ob_start();
                        }
?>
                        <html>
                            <head>
                                <title>Resi Pengiriman Paket</title>
                                <style type="text/css">
                                    @page {
                                        margin-top: 2cm;
                                        margin-bottom: 2cm;
                                        margin-left: 2cm;
                                        margin-right: 2cm;
                                    }
                                    body {
                                        background-color: #FFF;
                                        font-family: arial;
                                    }
                                    table{
                                        border-collapse: collapse;
                                        margin-top:10px;
                                    }
                                    table.kostum tr td {
                                        border:none;
                                        color:#333;
                                        border-spacing: 0px;
                                        padding: 2px;
                                        border-collapse: collapse;
                                        font-size:12px;
                                    }
                                    table.data tr td {
                                        border: 1px solid #666;
                                        color:#333;
                                        border-spacing: 0px;
                                        padding: 6px;
                                        border-collapse: collapse;
                                        font-size:10pt;
                                    }
                                    .tabel_garis_bawah {
                                        border-bottom: 1px solid #666;
                                    }
                                    table.TableForm tr td{
                                        padding: 3px;
                                    }
                                    .barcode {
                                        text-align: center;
                                        margin-top: 20px;
                                    }
                                </style>
                            </head>
                            <body>
                                <table class="kostum">
                                    <tr>
                                        <td align="left">
                                            <img src="<?php echo "$base_url/assets/img/$logo"; ?>" width="40px">
                                        </td>
                                        <td align="left">
                                            <?php 
                                                echo "<b>$title_page</b><br>"; 
                                                echo "<small>$alamat_bisnis</small><br>";
                                                echo "<small>Telepon ($telepon_bisnis)</small><br>";
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <table class="data" width="100%">
                                    <tr>
                                        <td align="left" colspan="2">
                                            <b>RESI PENGIRIMAN</b><BR>
                                            <small>
                                                No.Resi : <?php echo "$no_resi"; ?><br>
                                                ID.Transaksi : <?php echo "$kode_transaksi"; ?>
                                                Kurir : <?php echo "$kurir"; ?>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%">
                                            <b>Dikirim Dari/Oleh :</b>
                                            <p>
                                                <?php
                                                    if(!empty($asal_pengiriman)){
                                                        $asal_pengiriman_arry=json_decode($asal_pengiriman,true);
                                                        $nama_pengirim=$asal_pengiriman_arry['nama'];
                                                        $provinsi_pengirim=$asal_pengiriman_arry['provinsi'];
                                                        $kabupaten_pengirim=$asal_pengiriman_arry['kabupaten'];
                                                        $kecamatan_pengirim=$asal_pengiriman_arry['kecamatan'];
                                                        $desa_pengirim=$asal_pengiriman_arry['desa'];
                                                        $rt_rw_pengirim=$asal_pengiriman_arry['rt_rw'];
                                                        $kode_pos_pengirim=$asal_pengiriman_arry['kode_pos'];
                                                        $kontak_pengirim=$asal_pengiriman_arry['kontak'];
                                                        echo '<ul>';
                                                        echo '  <li>Nama : <code class="text text-grayish">'.$nama_pengirim.'</code></li>';
                                                        echo '  <li>Provinsi : <code class="text text-grayish">'.$provinsi_pengirim.'</code></li>';
                                                        echo '  <li>Kabupaten : <code class="text text-grayish">'.$kabupaten_pengirim.'</code></li>';
                                                        echo '  <li>Kecamatan : <code class="text text-grayish">'.$kecamatan_pengirim.'</code></li>';
                                                        echo '  <li>Desa/Kel : <code class="text text-grayish">'.$desa_pengirim.'</code></li>';
                                                        echo '  <li>RT/RW : <code class="text text-grayish">'.$rt_rw_pengirim.'</code></li>';
                                                        echo '  <li>Kode Pos : <code class="text text-grayish">'.$kode_pos_pengirim.'</code></li>';
                                                        echo '  <li>Kontak : <code class="text text-grayish">'.$kontak_pengirim.'</code></li>';
                                                        echo '</ul>';
                                                    }else{
                                                        echo '<code class="text text-danger">Tidak Ada</code>';
                                                    }
                                                ?>
                                            </p>
                                        </td>
                                        <td width="50%">
                                            <b>Tujuan/Kepada :</b><br>
                                            <p>
                                                <?php 
                                                    if(!empty($tujuan_pengiriman)){
                                                        $tujuan_pengiriman_arry=json_decode($tujuan_pengiriman,true);
                                                        $nama_tujuan=$tujuan_pengiriman_arry['nama'];
                                                        $provinsi_tujuan=$tujuan_pengiriman_arry['provinsi'];
                                                        $kabupaten_tujuan=$tujuan_pengiriman_arry['kabupaten'];
                                                        $kecamatan_tujuan=$tujuan_pengiriman_arry['kecamatan'];
                                                        $desa_tujuan=$tujuan_pengiriman_arry['desa'];
                                                        $rt_rw_ptujuan=$tujuan_pengiriman_arry['rt_rw'];
                                                        $kode_pos_tujuan=$tujuan_pengiriman_arry['kode_pos'];
                                                        $kontak_tujuan=$tujuan_pengiriman_arry['kontak'];
                                                        echo '<ul>';
                                                        echo '  <li>Nama : <code class="text text-grayish">'.$nama_tujuan.'</code></li>';
                                                        echo '  <li>Provinsi : <code class="text text-grayish">'.$provinsi_tujuan.'</code></li>';
                                                        echo '  <li>Kabupaten : <code class="text text-grayish">'.$kabupaten_tujuan.'</code></li>';
                                                        echo '  <li>Kecamatan : <code class="text text-grayish">'.$kecamatan_tujuan.'</code></li>';
                                                        echo '  <li>Desa/Kel : <code class="text text-grayish">'.$desa_tujuan.'</code></li>';
                                                        echo '  <li>RT/RW : <code class="text text-grayish">'.$rt_rw_ptujuan.'</code></li>';
                                                        echo '  <li>Kode Pos : <code class="text text-grayish">'.$kode_pos_tujuan.'</code></li>';
                                                        echo '  <li>Kontak : <code class="text text-grayish">'.$kontak_tujuan.'</code></li>';
                                                        echo '</ul>';
                                                    }else{
                                                        echo '<code class="text text-danger">Tidak Ada</code>';
                                                    }
                                                ?>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="barcode">
                                                <img src="<?php echo $base_url; ?>/assets/vendor/barcode.php?text=<?php echo $no_resi; ?>" alt="">
                                                <p><?php echo $no_resi; ?></p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </body>
                        </html>
<?php
                        if($format=="PDF"){
                            $html = ob_get_contents();
                            ob_end_clean();
                            $mpdf->WriteHTML(utf8_encode($html));
                            $mpdf->Output($nama_dokumen.".pdf" ,'I');
                            exit;
                        }
                    }
                }
            }
        }
    }
?>
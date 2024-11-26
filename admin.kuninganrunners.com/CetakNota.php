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
                $id_member=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'id_member');
                $raw_member=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'raw_member');
                $kategori=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'kategori');
                $datetime=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'datetime');
                $tagihan=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'tagihan');
                $jumlah=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'jumlah');
                $ongkir=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'ongkir');
                $ppn_pph=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'ppn_pph');
                $biaya_layanan=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'biaya_layanan');
                $biaya_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'biaya_lainnya');
                $potongan_lainnya=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'potongan_lainnya');
                $status=GetDetailData($Conn,'transaksi','kode_transaksi',$kode_transaksi,'status');
                //Buka Data Member
                $NamaMember=GetDetailData($Conn,'member','id_member',$id_member,'nama');
                //format Data Tanggal Transaksi
                $strtotime1=strtotime($datetime);
                $tanggal_transaksi=date('d M Y H:i',$strtotime1);
                //Format Rupiah
                $JumlahPembayaran='Rp ' . number_format($jumlah, 0, ',', '.');
                $subtotal_rp='Rp ' . number_format($tagihan, 0, ',', '.');
                $ongkir_rp='Rp ' . number_format($ongkir, 0, ',', '.');
                $ppn_pph_rp='Rp ' . number_format($ppn_pph, 0, ',', '.');
                $biaya_layanan_rp='Rp ' . number_format($biaya_layanan, 0, ',', '.');
                //Routing Label Status
                if($status=="Lunas"){
                    $LabelStatus='<code class="text-success">Lunas</code>';
                }else{
                    if($status=="Menunggu"){
                        $LabelStatus='<code class="text-danger">Menunggu Validasi</code>';
                    }else{
                        $LabelStatus='<code class="text-warning">Pending</code>';
                    }
                }
                
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
                    
                    $nama_dokumen = "Nota-$kode_transaksi";
                    
                    // Tambahkan margin kecil untuk dokumen
                    $mpdf->SetMargins(20, 20, 20, 20);
                    
                    // Mulai buffer untuk menyimpan output HTML
                    ob_start();
                }
?>
                        <html>
                            <head>
                                <title>Nota Transaksi</title>
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
                                        <td align="left" colspan="4">
                                            <b>NOTA TRANSAKSI</b><BR>
                                            <small>
                                                ID.Transaksi : <?php echo "$kode_transaksi"; ?><br>
                                                Kepada YTH : <?php echo "$NamaMember"; ?><br>
                                                Tanggal : <?php echo "$tanggal_transaksi"; ?><br>
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" colspan="4">
                                            <b>Uraian Transaksi</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center"><b>No</b></td>
                                        <td align="center"><b>Uraian</b></td>
                                        <td align="center"><b>Rp x Qty</b></td>
                                        <td align="center"><b>Jumlah</b></td>
                                    </tr>
                                    <?php
                                        $no=1;
                                        //Menampilkan Rincian Pembelanjaan
                                        $query = mysqli_query($Conn, "SELECT*FROM transaksi_rincian WHERE kode_transaksi='$kode_transaksi'");
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id_transaksi_rincian= $data['id_transaksi_rincian'];
                                            $nama_barang= $data['nama_barang'];
                                            $varian= $data['varian'];
                                            if(empty($data['harga'])){
                                                $harga=0;
                                            }else{
                                                $harga= $data['harga'];
                                            }
                                            if(empty($data['qty'])){
                                                $qty=0;
                                            }else{
                                                $qty= $data['qty'];
                                            }
                                            $jumlah= $data['jumlah'];
                                            //Format Rupiah
                                            $harga='Rp ' . number_format($harga, 0, ',', '.');
                                            $jumlah='Rp ' . number_format($jumlah, 0, ',', '.');
                                            echo '<tr>';
                                            echo '  <td align="center">'.$no.'</td>';
                                            echo '  <td align="left">'.$nama_barang.'</td>';
                                            echo '  <td align="left">'.$harga.' x '.$qty.'</td>';
                                            echo '  <td align="right">'.$jumlah.'</td>';
                                            echo '</tr>';
                                            $no++;
                                        }
                                    ?>
                                    <tr>
                                        <td align="center"></td>
                                        <td align="left">Subtotal</td>
                                        <td align="right"></td>
                                        <td align="right"><?php echo $subtotal_rp; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="center"></td>
                                        <td align="left">Ongkir</td>
                                        <td align="right"></td>
                                        <td align="right"><?php echo $ongkir_rp; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="center"></td>
                                        <td align="left">PPN</td>
                                        <td align="right"></td>
                                        <td align="right"><?php echo $ppn_pph_rp; ?></td>
                                    </tr>
                                    <tr>
                                        <td align="center"></td>
                                        <td align="left">Biaya Layanan</td>
                                        <td align="right"></td>
                                        <td align="right"><?php echo $biaya_layanan_rp; ?></td>
                                    </tr>
                                    <?php
                                        if(!empty($biaya_lainnya)){
                                            $biaya_lainnya_arry=json_decode($biaya_lainnya,true);
                                            if(!empty(count($biaya_lainnya_arry))){
                                                foreach ($biaya_lainnya_arry as $biaya_lainnya_list) {
                                                    $nama_biaya=$biaya_lainnya_list['nama_biaya'];
                                                    $nominal_biaya=$biaya_lainnya_list['nominal_biaya'];
                                                    $nominal_biaya_format='Rp ' . number_format($nominal_biaya, 0, ',', '.');
                                                    echo '<tr>';
                                                    echo '  <td align="center"></td>';
                                                    echo '  <td align="left">'.$nama_biaya.'</td>';
                                                    echo '  <td align="left"></td>';
                                                    echo '  <td align="right">'.$nominal_biaya_format.'</td>';
                                                    echo '</tr>';
                                                }
                                            }
                                        }
                                        if(!empty($potongan_lainnya)){
                                            $potongan_lainnya_arry=json_decode($potongan_lainnya,true);
                                            if(!empty(count($potongan_lainnya_arry))){
                                                foreach ($potongan_lainnya_arry as $potongan_lainnya_list) {
                                                    $nama_potongan=$potongan_lainnya_list['nama_potongan'];
                                                    $nominal_potongan=$potongan_lainnya_list['nominal_potongan'];
                                                    $nominal_potongan_format='Rp ' . number_format($nominal_potongan, 0, ',', '.');
                                                    echo '<tr>';
                                                    echo '  <td align="center"></td>';
                                                    echo '  <td align="left">'.$nama_potongan.'</td>';
                                                    echo '  <td align="left"></td>';
                                                    echo '  <td align="right">'.$nominal_potongan_format.'</td>';
                                                    echo '</tr>';
                                                }
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td align="center"></td>
                                        <td align="left">TOTAL</td>
                                        <td align="right"></td>
                                        <td align="right"><?php echo $JumlahPembayaran; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" align="center">
                                            <div class="barcode">
                                                <img src="<?php echo $base_url; ?>/assets/vendor/barcode.php?text=<?php echo $kode_transaksi; ?>" alt="">
                                                <p><?php echo $kode_transaksi; ?></p>
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
?>
<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    if(empty($SessionIdAkses)){
        echo '<div class="alert alert-danger text-center">';
        echo '  <small>';
        echo '          Sesi akses sudah berakhir, silahkan login ulang!';
        echo '  </small>';
        echo '</div>';
    }else{
        if(empty($_GET['keyword'])){
            echo '<div class="alert alert-danger text-center">';
            echo '  <small>';
            echo '      Keyword Pencarian Laporan Tidak Boleh Kosong!';
            echo '  </small>';
            echo '</div>';
        }else{
            if(empty($_GET['kategori'])){
                echo '<div class="alert alert-danger text-center">';
                echo '  <small>';
                echo '      Kategori Transaksi Tidak Boleh Kosong!';
                echo '  </small>';
                echo '</div>';
            }else{
                $keyword=$_GET['keyword'];
                $kategori=$_GET['kategori'];
                // Set header untuk ekspor CSV
                echo '
                    <html>
                        <head>
                            <title>Laporan Transaksi</title>
                            <style>
                                /* Menentukan style untuk elemen tabel */
                                table {
                                    width: 100%;
                                    border-collapse: collapse;
                                }
                                
                                /* Menentukan style untuk setiap baris dalam tabel */
                                table tr {
                                    background-color: #f2f2f2;
                                }

                                /* Menentukan style untuk sel dalam tabel (td) */
                                table tr td {
                                    padding: 8px;
                                    text-align: left;
                                    border: 1px solid #ddd;
                                }

                                /* Menambahkan style untuk kolom header tabel */
                                table th {
                                    background-color: #4CAF50;
                                    color: white;
                                    padding: 8px;
                                    text-align: left;
                                    border: 1px solid #ddd;
                                }
                            </style>
                        </head>
                        <body>
                ';
                header("Content-type: application/vnd-ms-excel");
                header("Content-Disposition: attachment; filename=Laporan-$kategori-$keyword.xls");
                if($kategori=="Pembelian"){
                    // Hitung Jumlah Data
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT * FROM transaksi WHERE kategori='$kategori' AND datetime LIKE '%$keyword%'"));
                    echo '<table>';
                    echo '
                        <tr>
                            <td><b>No</b></td>
                            <td><b>Kode Transaksi</b></td>
                            <td><b>Tgl/Jam</b></td>
                            <td><b>Member</b></td>
                            <td><b>Email</b></td>
                            <td><b>Barang</b></td>
                            <td><b>Varian</b></td>
                            <td><b>Harga</b></td>
                            <td><b>QTY</b></td>
                            <td><b>Subtotal</b></td>
                            <td><b>Ongkir</b></td>
                            <td><b>PPN/PPH</b></td>
                            <td><b>Biaya Layanan</b></td>
                            <td><b>Biaya Lain-Lain</b></td>
                            <td><b>Potongan</b></td>
                            <td><b>Jumlah/Total</b></td>
                            <td><b>Pengiriman</b></td>
                            <td><b>Alamat 1</b></td>
                            <td><b>Alamat 2</b></td>
                            <td><b>Status</b></td>
                        </tr>
                    ';
                    if ($jml_data == 0) {
                        echo '
                            <tr>
                                <td colspan="19" class="text-center">
                                    Data Tidak Ditemukan Pada Database
                                </td>
                            </tr>
                        ';
                    } else {
                        $no = 1;
                        $query1 = mysqli_query($Conn, "SELECT * FROM transaksi WHERE kategori='$kategori' AND datetime LIKE '%$keyword%' ORDER BY datetime ASC");
                        while ($data1 = mysqli_fetch_array($query1)) {
                            $kode_transaksi = $data1['kode_transaksi'];
                            $id_member = $data1['id_member'];
                            $tanggal_transaksi = $data1['datetime'];
                            $jumlah = $data1['jumlah'];
                            $ongkir = $data1['ongkir'];
                            $ppn_pph = $data1['ppn_pph'];
                            $biaya_layanan = $data1['biaya_layanan'];
                            $pengiriman = $data1['pengiriman'];
                            $status = $data1['status'];

                            // Decode JSON biaya_lainnya
                            $biaya_lainnya_rp = 0;
                            if (!empty($data1['biaya_lainnya'])) {
                                $biaya_lainnya_arry = json_decode($data1['biaya_lainnya'], true);
                                foreach ($biaya_lainnya_arry as $list_biaya_lainnya) {
                                    $biaya_lainnya_rp += $list_biaya_lainnya['nominal_biaya'];
                                }
                            }

                            // Decode JSON potongan_lainnya
                            $potongan_lainnya_rp = 0;
                            if (!empty($data1['potongan_lainnya'])) {
                                $potongan_lainnya_arry = json_decode($data1['potongan_lainnya'], true);
                                foreach ($potongan_lainnya_arry as $list_potongan_lainnya) {
                                    $potongan_lainnya_rp += $list_potongan_lainnya['nominal_potongan'];
                                }
                            }

                            // Ambil data member
                            $QryMember = $Conn->prepare("SELECT * FROM member WHERE id_member = ?");
                            $QryMember->bind_param("s", $id_member);
                            $QryMember->execute();
                            $Result = $QryMember->get_result();
                            $Data = $Result->fetch_assoc();
                            $member = $Data['nama'] ?? "";
                            $email = $Data['email'] ?? "";
                            $QryMember->close();

                            // Ambil informasi pengiriman
                            $QryPengiriman = $Conn->prepare("SELECT * FROM transaksi_pengiriman WHERE kode_transaksi = ?");
                            $QryPengiriman->bind_param("s", $kode_transaksi);
                            $QryPengiriman->execute();
                            $ResultPengiriman = $QryPengiriman->get_result();
                            $DataPengiriman = $ResultPengiriman->fetch_assoc();
                            $tujuan_pengiriman=$DataPengiriman['tujuan_pengiriman'];
                            $tujuan_arry = json_decode($tujuan_pengiriman, true);
                            $alamt_pengiriman =$tujuan_arry['alamt_pengiriman'];
                            $rt_rw = $tujuan_arry['rt_rw'];
                            $QryPengiriman->close();

                            // Ambil rincian barang
                            $query2 = mysqli_query($Conn, "SELECT * FROM transaksi_rincian WHERE kode_transaksi='$kode_transaksi'");
                            $rowCount = mysqli_num_rows($query2);
                            $firstRow = true;

                            while ($data2 = mysqli_fetch_array($query2)) {
                                $nama_barang = $data2['nama_barang'];
                                $varian = !empty($data2['varian']) ? json_decode($data2['varian'], true)['nama_varian'] : "";
                                $harga = $data2['harga'];
                                $qty = $data2['qty'];
                                $subtotal = $data2['jumlah'];

                                // Tampilkan data transaksi hanya pada baris pertama
                                if ($firstRow) {
                                    echo '<tr>';
                                    echo '  <td class="text-left" valign="top" rowspan="' . $rowCount . '">' . $no . '</td>';
                                    echo '  <td class="text-left" valign="top" rowspan="' . $rowCount . '">' . $kode_transaksi . '</td>';
                                    echo '  <td class="text-left" valign="top" rowspan="' . $rowCount . '">' . date('d/m/Y H:i:s', strtotime($tanggal_transaksi)) . '</td>';
                                    echo '  <td class="text-left" valign="top" rowspan="' . $rowCount . '">' . $member . '</td>';
                                    echo '  <td class="text-left" valign="top" rowspan="' . $rowCount . '">' . $email . '</td>';
                                    echo '  <td class="text-left">' . $nama_barang . '</td>';
                                    echo '  <td class="text-left">' . $varian . '</td>';
                                    echo '  <td class="text-left">' . $harga . '</td>';
                                    echo '  <td class="text-left">' . $qty . '</td>';
                                    echo '  <td class="text-left">' . $subtotal . '</td>';
                                    echo '  <td class="text-left" valign="top" rowspan="' . $rowCount . '">' . $ongkir . '</td>';
                                    echo '  <td class="text-left" valign="top" rowspan="' . $rowCount . '">' . $ppn_pph . '</td>';
                                    echo '  <td class="text-left" valign="top" rowspan="' . $rowCount . '">' . $biaya_layanan . '</td>';
                                    echo '  <td class="text-left" valign="top" rowspan="' . $rowCount . '">' . $biaya_lainnya_rp . '</td>';
                                    echo '  <td class="text-left" valign="top" rowspan="' . $rowCount . '">' . $potongan_lainnya_rp . '</td>';
                                    echo '  <td class="text-left" valign="top" rowspan="' . $rowCount . '">' . $jumlah . '</td>';
                                    echo '  <td class="text-left" valign="top" rowspan="' . $rowCount . '">' . $pengiriman . '</td>';
                                    echo '  <td class="text-left" valign="top" rowspan="' . $rowCount . '">' . $alamt_pengiriman . '</td>';
                                    echo '  <td class="text-left" valign="top" rowspan="' . $rowCount . '">' . $rt_rw . '</td>';
                                    echo '  <td class="text-left" valign="top" rowspan="' . $rowCount . '">' . $status . '</td>';
                                    echo '</tr>';
                                    $firstRow = false;
                                } else {
                                    // Tampilkan rincian barang lainnya
                                    echo '<tr>';
                                    echo '  <td class="text-left">' . $nama_barang . '</td>';
                                    echo '  <td class="text-left">' . $varian . '</td>';
                                    echo '  <td class="text-left">' . $harga . '</td>';
                                    echo '  <td class="text-left">' . $qty . '</td>';
                                    echo '  <td class="text-left">' . $subtotal . '</td>';
                                    echo '</tr>';
                                }
                            }
                            $no++;
                        }
                    }
                    echo '</table>';

                }else{
                    //Hitung Jumlah Data
                    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE kategori='$kategori' AND datetime like '%$keyword%'"));
                    echo '<table>';
                    echo '      
                        <tr>
                            <td><b>No</b></td>
                            <td><b>Tgl/Jam</b></td>
                            <td><b>Member</b></td>
                            <td><b>Email</b></td>
                            <td><b>Event</b></td>
                            <td><b>Kategori</b></td>
                            <td><b>Biaya</b></td>
                            <td><b>Status</b></td>
                        </tr>
                    ';
                    if(empty($jml_data)){
                        echo '
                            <tr>
                                <td colspan="10" class="text-center">
                                    Data Tidak Ditemukan Pada Database
                                </td>
                            </tr>
                        ';
                    }else{
                        $no=1;
                        $query1 = mysqli_query($Conn, "SELECT*FROM transaksi WHERE kategori='$kategori' AND datetime like '%$keyword%' ORDER BY datetime ASC");
                        if (!$query1) {
                            die("Query Error: " . mysqli_error($Conn)); // Tampilkan pesan error
                        }else{
                            while ($data1 = mysqli_fetch_array($query1)) {
                                $kode_transaksi= $data1['kode_transaksi'];
                                $id_member= $data1['id_member'];
                                $tanggal_transaksi= $data1['datetime'];
                                $jumlah= $data1['jumlah'];
                                $status= $data1['status'];
                                //Buka Nama Member
                                $QryMember = $Conn->prepare("SELECT * FROM member WHERE id_member = ?");
                                if ($QryMember === false) {
                                    $member="Query Preparation Failed: " . $Conn->error;
                                    $email="Query Preparation Failed: " . $Conn->error;
                                }else{
                                    // Bind parameter
                                    $QryMember->bind_param("s", $id_member);                          
                                    // Eksekusi query
                                    if (!$QryMember->execute()) {
                                        $member="Query Execution Failed: " . $QryMember->error;
                                        $email="Query Execution Failed: " . $QryMember->error;
                                    }else{
                                        // Mengambil hasil
                                        $Result = $QryMember->get_result();
                                        $Data = $Result->fetch_assoc();
                                        // Menutup statement
                                        $QryMember->close();
                                        // Mengembalikan hasil
                                        if (empty($Data['id_member'])) {
                                            $member="";
                                            $email="";
                                        } else {
                                            $member=$Data['nama'];
                                            $email=$Data['email'];
                                        }
                                    }
                                }
                                //Buka event_peserta
                                $Qry2 = $Conn->prepare("SELECT * FROM event_peserta WHERE id_event_peserta = ?");
                                if ($Qry2 === false) {
                                    $id_event="";
                                    $id_event_kategori="";
                                }else{
                                    // Bind parameter
                                    $Qry2->bind_param("s", $kode_transaksi);                          
                                    // Eksekusi query
                                    if (!$Qry2->execute()) {
                                        $id_event="";
                                        $id_event_kategori="";
                                    }else{
                                        // Mengambil hasil
                                        $Result2 = $Qry2->get_result();
                                        $Data2 = $Result2->fetch_assoc();
                                        // Menutup statement
                                        $Qry2->close();
                                        // Mengembalikan hasil
                                        if (empty($Data2['id_event'])) {
                                            $id_event="";
                                            $id_event_kategori="";
                                        } else {
                                            $id_event=$Data2['id_event'];
                                            $id_event_kategori=$Data2['id_event_kategori'];
                                        }
                                    }
                                }
                                //Buka Nama Event
                                if(!empty($id_event)){
                                    $Qry3 = $Conn->prepare("SELECT * FROM event WHERE id_event = ?");
                                    if ($Qry3 === false) {
                                        $nama_event="";
                                    }else{
                                        // Bind parameter
                                        $Qry3->bind_param("s", $id_event);                          
                                        // Eksekusi query
                                        if (!$Qry3->execute()) {
                                            $nama_event="";
                                        }else{
                                            // Mengambil hasil
                                            $Result3 = $Qry3->get_result();
                                            $Data3 = $Result3->fetch_assoc();
                                            // Menutup statement
                                            $Qry3->close();
                                            // Mengembalikan hasil
                                            if (empty($Data3['nama_event'])) {
                                                $nama_event="";
                                            } else {
                                                $nama_event=$Data3['nama_event'];
                                            }
                                        }
                                    }
                                }else{
                                    $nama_event="";
                                }
                                //Buka Kategori Event
                                if(!empty($id_event_kategori)){
                                    $Qry4 = $Conn->prepare("SELECT * FROM event_kategori WHERE id_event_kategori = ?");
                                    if ($Qry4 === false) {
                                        $kategori_event="";
                                    }else{
                                        // Bind parameter
                                        $Qry4->bind_param("s", $id_event_kategori);                          
                                        // Eksekusi query
                                        if (!$Qry4->execute()) {
                                            $kategori_event="";
                                        }else{
                                            // Mengambil hasil
                                            $Result4 = $Qry4->get_result();
                                            $Data4 = $Result4->fetch_assoc();
                                            // Menutup statement
                                            $Qry4->close();
                                            // Mengembalikan hasil
                                            if (empty($Data4['kategori'])) {
                                                $kategori_event="";
                                            } else {
                                                $kategori_event=$Data4['kategori'];
                                            }
                                        }
                                    }
                                }else{
                                    $kategori_event="";
                                }
                                echo '
                                    <tr>
                                        <td class="text-left">'.$no.'</td>
                                        <td class="text-left">'.date('d/m/Y H:i:s',strtotime($tanggal_transaksi)).'</td>
                                        <td class="text-left">'.$member.'</td>
                                        <td class="text-left">'.$email.'</td>
                                        <td class="text-left">'.$nama_event.'</td>
                                        <td class="text-left">'.$kategori_event.'</td>
                                        <td class="text-left">'.$jumlah.'</td>
                                        <td class="text-left">'.$status.'</td>
                                    </tr>
                                ';
                                $no++;
                            }
                        }
                    }
                    echo '  </table>';
                }
                echo '
                        </body>
                    </html>
                ';
            }
        }
    }
?>


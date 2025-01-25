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
        if(empty($_POST['periode'])){
            echo '<div class="alert alert-danger text-center">';
            echo '  <small>';
            echo '      Periode Tidak Boleh Kosong!';
            echo '  </small>';
            echo '</div>';
        }else{
            if(empty($_POST['keyword'])){
                echo '<div class="alert alert-danger text-center">';
                echo '  <small>';
                echo '      Keyword Pencarian Laporan Tidak Boleh Kosong!';
                echo '  </small>';
                echo '</div>';
            }else{
                if(empty($_POST['kategori'])){
                    echo '<div class="alert alert-danger text-center">';
                    echo '  <small>';
                    echo '      Kategori Transaksi Tidak Boleh Kosong!';
                    echo '  </small>';
                    echo '</div>';
                }else{
                    $periode=$_POST['periode'];
                    $keyword=$_POST['keyword'];
                    $kategori=$_POST['kategori'];
                    if($kategori=="Pembelian"){
                        //Hitung Jumlah Data
                        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE kategori='$kategori' AND datetime like '%$keyword%'"));
                        echo '<div class="table table-responsive">';
                        echo '  <table class="table table-bordered table-hover">';
                        echo '      
                                <thead>
                                    <tr>
                                        <th><b>No</b></th>
                                        <th><b>Tgl/Jam</b></th>
                                        <th><b>Member</b></th>
                                        <th><b>Barang</b></th>
                                        <th><b>Jumlah/Total</b></th>
                                        <th><b>Pengiriman</b></th>
                                        <th><b>Alamat</b></th>
                                        <th><b>Status</b></th>
                                    </tr>
                                </thead>
                        ';
                        echo '  <tbody>';
                        if(empty($jml_data)){
                            echo '
                                <tr>
                                    <td colspan="10" class="text-center">
                                        Data Tidak Ditemukan Pada Database
                                    </td>
                                </tr>
                            ';
                        }else{
                            echo '
                                <div class="row mt-3 mb-3">
                                    <div class="col-md-12 text-center">
                                        <a href="_Page/LaporanTransaksi/ExportLaporanTransaksi.php?kategori='.$kategori.'&keyword='.$keyword.'" class="btn btn-md btn-outline-dark">
                                            Export Pembelian
                                        </a>
                                    </div>
                                </div>
                            ';
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
                                    $pengiriman= $data1['pengiriman'];
                                    $status= $data1['status'];
                                    // Inisialisasi array kosong
                                    $list_barang_varian = []; 
                                    $query2 = mysqli_query($Conn, "SELECT * FROM transaksi_rincian WHERE kode_transaksi='$kode_transaksi'");
                                    while ($data2 = mysqli_fetch_array($query2)) {
                                        $nama_barang = $data2['nama_barang'];
                                        if(empty($data2['varian'])){
                                            $varian ="";
                                        }else{
                                            $varian =$data2['varian'];
                                            $varian_arry=json_decode($varian,true);
                                            $varian=$varian_arry['nama_varian'];
                                        }
                                        $harga = $data2['harga'];
                                        $qty = $data2['qty'];
                                        // Format rincian barang menjadi string sesuai format yang diinginkan
                                        $item = "- $nama_barang" . (!empty($varian) ? " ($varian)" : "") . " ($harga x $qty)";
                                        
                                        // Tambahkan rincian barang ke dalam array
                                        $list_barang_varian[] = $item;
                                    }
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
                                    //Buka Informasi Pengiriman
                                    $Qry2 = $Conn->prepare("SELECT * FROM transaksi_pengiriman WHERE kode_transaksi = ?");
                                    if ($Qry2 === false) {
                                        $tujuan_pengiriman="Query Preparation Failed: " . $Conn->error;
                                        $rt_rw="";
                                    }else{
                                        // Bind parameter
                                        $Qry2->bind_param("s", $kode_transaksi);                          
                                        // Eksekusi query
                                        if (!$Qry2->execute()) {
                                            $tujuan_pengiriman="Query Execution Failed: " . $Qry2->error;
                                            $rt_rw="";
                                        }else{
                                            // Mengambil hasil
                                            $Result2 = $Qry2->get_result();
                                            $Data2 = $Result2->fetch_assoc();
                                            // Menutup statement
                                            $Qry2->close();
                                            // Mengembalikan hasil
                                            if (empty($Data2['tujuan_pengiriman'])) {
                                                $tujuan_pengiriman="";
                                                $rt_rw="";
                                            } else {
                                                $tujuan_pengiriman=$Data2['tujuan_pengiriman'];
                                                $tujuan_arry=json_decode($tujuan_pengiriman, true);
                                                $alamat=$tujuan_arry['alamt_pengiriman'];
                                                $rt_rw=$tujuan_arry['rt_rw'];
                                            }
                                        }
                                    }
                                    echo '
                                        <tr>
                                            <td class="text-left"><small>'.$no.'</small></td>
                                            <td class="text-left">
                                                <small>
                                                    '.date('d/m/Y',strtotime($tanggal_transaksi)).'<br>
                                                    <code class="text-muted">'.date('H:i:s',strtotime($tanggal_transaksi)).'</code>
                                                </small>
                                            </td>
                                            <td class="text-left">
                                                <small>
                                                    '.$member.'<br>
                                                    <code class="text-muted">'.$email.'</code>
                                                </small>
                                            </td>
                                            <td class="text-left">
                                                <small>
                                                    <code class="text-muted">
                                                    '.implode("<br>", $list_barang_varian).'
                                                    </code>
                                                </small>
                                            </td>
                                            <td class="text-left"><small>'.$jumlah.'</small></td>
                                            <td class="text-left"><small>'.$pengiriman.'</small></td>
                                            <td class="text-left">
                                                <small>
                                                    '.$alamat.'<br>
                                                    <code class="text-grayish">'.$rt_rw.'</code>
                                                </small>
                                            </td>
                                            <td class="text-left"><small>'.$status.'</small></td>
                                        </tr>
                                    ';
                                    $no++;
                                }
                            }
                        }
                        echo '  </tbody>';
                        echo '  </table>';
                        echo '</div>';
                    }else{
                        //Hitung Jumlah Data
                        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM transaksi WHERE kategori='$kategori' AND datetime like '%$keyword%'"));
                        echo '<div class="table table-responsive">';
                        echo '  <table class="table table-bordered table-hover">';
                        echo '      
                                <thead>
                                    <tr>
                                        <th><b>No</b></th>
                                        <th><b>Tgl/Jam</b></th>
                                        <th><b>Member</b></th>
                                        <th><b>Event</b></th>
                                        <th><b>Kategori</b></th>
                                        <th><b>Biaya</b></th>
                                        <th><b>Status</b></th>
                                    </tr>
                                </thead>
                        ';
                        echo '  <tbody>';
                        if(empty($jml_data)){
                            echo '
                                <tr>
                                    <td colspan="10" class="text-center">
                                        Data Tidak Ditemukan Pada Database
                                    </td>
                                </tr>
                            ';
                        }else{
                            echo '
                                <div class="row mt-3 mb-3">
                                    <div class="col-md-12 text-center">
                                        <a href="_Page/LaporanTransaksi/ExportLaporanTransaksi.php?kategori='.$kategori.'&keyword='.$keyword.'" class="btn btn-md btn-outline-dark">
                                            Export Pendaftaran
                                        </a>
                                    </div>
                                </div>
                            ';
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
                                            <td class="text-left"><small>'.$no.'</small></td>
                                            <td class="text-left">
                                                <small>
                                                    '.date('d/m/Y',strtotime($tanggal_transaksi)).'<br>
                                                    <code class="text-muted">'.date('H:i:s',strtotime($tanggal_transaksi)).'</code>
                                                </small>
                                            </td>
                                            <td class="text-left">
                                                <small>
                                                    '.$member.'<br>
                                                    <code class="text-muted">'.$email.'</code>
                                                </small>
                                            </td>
                                            <td class="text-left"><small>'.$nama_event.'</small></td>
                                            <td class="text-left"><small>'.$kategori_event.'</small></td>
                                            <td class="text-left"><small>'.$jumlah.'</small></td>
                                            <td class="text-left"><small>'.$status.'</small></td>
                                        </tr>
                                    ';
                                    $no++;
                                }
                            }
                        }
                        echo '  </tbody>';
                        echo '  </table>';
                        echo '</div>';
                    }
                }
            }
        }
    }
?>
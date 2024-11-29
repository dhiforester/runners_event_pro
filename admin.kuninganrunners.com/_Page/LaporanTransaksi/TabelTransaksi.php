<div class="row">
    <div class="col-md-12">
        <div class="table table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <td align="center"><b>No</b></td>
                        <td align="center"><b>Periode</b></td>
                        <td align="center"><b>Pendaftaran</b></td>
                        <td align="center"><b>Penjualan</b></td>
                        <td align="center"><b>Jumlah</b></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include_once '../../_Config/Connection.php';
                        if(empty($_POST['periode'])){
                            $periode="Bulanan";
                        }else{
                            $periode=$_POST['periode'];
                        }
                        if(empty($_POST['tahun'])){
                            $tahun=date('Y');
                        }else{
                            $tahun=$_POST['tahun'];
                        }
                        if(empty($_POST['bulan'])){
                            $bulan=date('m');
                        }else{
                            $bulan=$_POST['bulan'];
                        }
                        if($periode=="Bulanan"){
                            $bulanIndo = [
                                '01' => 'Januari',
                                '02' => 'Februari',
                                '03' => 'Maret',
                                '04' => 'April',
                                '05' => 'Mei',
                                '06' => 'Juni',
                                '07' => 'Juli',
                                '08' => 'Agustus',
                                '09' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember'
                            ];
                            // Perulangan untuk mencetak bulan
                            $no=1;
                            $total_pendaftaran_all=0;
                            $total_pembelian_all=0;
                            $total_jumlah_all=0;
                            foreach ($bulanIndo as $key => $namaBulan) {
                                $keyword="$tahun-$key";
                                //Jumlah Pendaftaran
                                $sql = "SELECT SUM(jumlah) AS total_pendaftaran FROM transaksi WHERE kategori='Pendaftaran' AND datetime like '%$keyword%'";
                                $result = $Conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_pendaftaran=$row['total_pendaftaran'];
                                }else{
                                    $total_pendaftaran=0;
                                }
                                $total_pendaftaran_format="Rp " . number_format($total_pendaftaran, 0, ',', '.');
                                //Jumlah Penjualan
                                $sql = "SELECT SUM(jumlah) AS total_pembelian FROM transaksi WHERE kategori='Pembelian' AND datetime like '%$keyword%'";
                                $result = $Conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_pembelian=$row['total_pembelian'];
                                }else{
                                    $total_pembelian=0;
                                }
                                $total_pembelian_format="Rp " . number_format($total_pembelian, 0, ',', '.');
                                $jumlah_total=$total_pendaftaran+$total_pembelian;
                                $jumlah_total_format="Rp " . number_format($jumlah_total, 0, ',', '.');
                                echo '<tr>';
                                echo '  <td align="center">'.$no.'</td>';
                                echo '  <td align="left">'.$namaBulan.'</td>';
                                echo '  <td align="right">'.$total_pendaftaran_format.'</td>';
                                echo '  <td align="right">'.$total_pembelian_format.'</td>';
                                echo '  <td align="right">'.$jumlah_total_format.'</td>';
                                echo '</tr>';
                                $no++;
                                $total_pendaftaran_all=$total_pendaftaran_all+$total_pendaftaran;
                                $total_pembelian_all=$total_pembelian_all+$total_pembelian;
                                $total_jumlah_all=$total_jumlah_all+$jumlah_total;
                            }
                        }else{
                            $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
                            $total_pendaftaran_all=0;
                            $total_pembelian_all=0;
                            $total_jumlah_all=0;
                            $no=1;
                            for ($tanggal = 1; $tanggal <= $jumlahHari; $tanggal++) {
                                //Zero pading
                                $tanggal_format=sprintf("%02d", $tanggal);
                                $keyword="$tahun-$bulan-$tanggal_format";
                                //Jumlah Pendaftaran
                                $sql = "SELECT SUM(jumlah) AS total_pendaftaran FROM transaksi WHERE kategori='Pendaftaran' AND datetime like '%$keyword%'";
                                $result = $Conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_pendaftaran=$row['total_pendaftaran'];
                                }else{
                                    $total_pendaftaran=0;
                                }
                                $total_pendaftaran_format="Rp " . number_format($total_pendaftaran, 0, ',', '.');
                                //Jumlah Penjualan
                                $sql = "SELECT SUM(jumlah) AS total_pembelian FROM transaksi WHERE kategori='Pembelian' AND datetime like '%$keyword%'";
                                $result = $Conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $total_pembelian=$row['total_pembelian'];
                                }else{
                                    $total_pembelian=0;
                                }
                                $total_pembelian_format="Rp " . number_format($total_pembelian, 0, ',', '.');
                                $jumlah_total=$total_pendaftaran+$total_pembelian;
                                $jumlah_total_format="Rp " . number_format($jumlah_total, 0, ',', '.');
                                echo '<tr>';
                                echo '  <td align="center">'.$no.'</td>';
                                echo '  <td align="left">'.$tanggal.'/'.$bulan.'/'.$tahun.'</td>';
                                echo '  <td align="right">'.$total_pendaftaran_format.'</td>';
                                echo '  <td align="right">'.$total_pembelian_format.'</td>';
                                echo '  <td align="right">'.$jumlah_total_format.'</td>';
                                echo '</tr>';
                                $no++;
                                $total_pendaftaran_all=$total_pendaftaran_all+$total_pendaftaran;
                                $total_pembelian_all=$total_pembelian_all+$total_pembelian;
                                $total_jumlah_all=$total_jumlah_all+$jumlah_total;
                            }
                        }
                        $total_pendaftaran_all_format="Rp " . number_format($total_pendaftaran_all, 0, ',', '.');
                        $total_pembelian_all_format="Rp " . number_format($total_pembelian_all, 0, ',', '.');
                        $total_jumlah_all_format="Rp " . number_format($total_jumlah_all, 0, ',', '.');
                    ?>
                    <tr>
                        <td colspan="2" align="center">
                            <b>TOTAL JUMLAH</b>
                        </td>
                        <td align="right">
                            <b><?php echo "$total_pendaftaran_all_format"; ?></b>
                        </td>
                        <td align="right">
                            <b><?php echo "$total_pembelian_all_format"; ?></b>
                        </td>
                        <td align="right">
                            <b><?php echo "$total_jumlah_all_format"; ?></b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
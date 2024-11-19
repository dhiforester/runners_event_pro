<?php
    session_start();
    include "../_Config/Connection.php";
    include "../_Config/GlobalFunction.php";
    //Menangkan xtoken dari session
    if(empty($_SESSION['xtoken'])){
        echo '<div class="card mb-3">';
        echo '  <div class="card-body text-center text-danger">';
        echo '      <small>Tidak Ada Sesi Token</small>';
        echo '  </div>';
        echo '</div>';
    }else{
        $xtoken=$_SESSION['xtoken'];
        //Buka Fungsi List Barang
        $limit=4;
        if(empty($_GET['page'])){
            $page=1;
        }else{
            $page=$_GET['page'];
        }
        $OrderBy="id_barang";
        $ShortBy="DESC";
        $WebDataBarang=WebListBarang($url_server,$xtoken,$limit,$page,$OrderBy,$ShortBy);
        $WebDataBarang=json_decode($WebDataBarang, true);
        if($WebDataBarang['response']['code']!==200){
            echo '<div class="card mb-3">';
            echo '  <div class="card-body text-center text-danger">';
            echo '      <small>'.$WebDataBarang['response']['message'].'</small>';
            echo '  </div>';
            echo '</div>';
        }else{
            $jumlah_data=count($WebDataBarang['metadata']);
            if(empty($jumlah_data)){
                echo '<div class="card mb-3">';
                echo '  <div class="card-body text-center text-danger">';
                echo '      <small>Belum Ada Data Yang Ditampilkan</small>';
                echo '  </div>';
                echo '</div>';
            }else{
                $metadata=$WebDataBarang['metadata'];
                $jumlah_list=$metadata['jumlah_data'];
                $jumlah_halaman=$metadata['jumlah_halaman'];
                $page_sekarang=$metadata['page'];
                $limit=$metadata['limit'];
                $list_barang=$metadata['list_barang'];
                foreach($list_barang as $list_barang_arry){
                    $id_barang=$list_barang_arry['id_barang'];
                    $nama_barang=$list_barang_arry['nama_barang'];
                    $kategori=$list_barang_arry['kategori'];
                    $satuan=$list_barang_arry['satuan'];
                    $harga=$list_barang_arry['harga'];
                    $stok=$list_barang_arry['stok'];
                    $image=$list_barang_arry['image'];
                    //Mengubah Gambar
                    $new_width=500;
                    $new_height=500;
                    $ImageBase64=resizeImage($image, $new_width, $new_height);
                    //Format Rupiah
                    $harga_format='Rp ' . number_format($harga, 2, ',', '.');
?>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 d-flex align-items-stretch mb-4" data-aos="fade-up" data-aos-delay="100">
                    <a href="index.php?Page=DetailMerch&id=<?php echo $id_barang; ?>" class="team-member">
                        <div class="member-img">
                            <img src="<?php echo "data:image/jpeg;base64,$ImageBase64"; ?>" class="img-fluid" alt="">
                        </div>
                        <div class="member-info">
                            <h4><?php echo $harga_format; ?></h4>
                            <span><?php echo $nama_barang; ?></span>
                        </div>
                    </a>
                </div>
<?php
                }
            }
        }
    }
?>
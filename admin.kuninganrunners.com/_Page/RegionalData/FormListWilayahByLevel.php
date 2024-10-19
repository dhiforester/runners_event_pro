<?php
    include "../../_Config/Connection.php";
?>

<div class="accordion" id="accordionExample">
    <?php
        //Menampilkan Propinsi
        $JumlahPropinsi = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Propinsi'"));
        if(!empty($JumlahPropinsi)){
            $no=1;
            $query = mysqli_query($Conn, "SELECT*FROM wilayah WHERE kategori='Propinsi'ORDER BY propinsi ASC");
            while ($data = mysqli_fetch_array($query)) {
                $id_wilayah= $data['id_wilayah'];
                $propinsi= $data['propinsi'];
                echo '<div class="accordion-item">';
                echo '  <h2 class="accordion-header" id="headingOne'.$id_wilayah.'">';
                echo '      <button class="accordion-button collapsed ClickProvinsi" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne'.$id_wilayah.'" aria-expanded="false" aria-controls="collapseOne'.$id_wilayah.'" value="'.$id_wilayah.'">';
                echo '          <b>'.$no.'. '.$propinsi.'</b>';
                echo '      </button>';
                echo '  </h2>';
                echo '  <div id="collapseOne'.$id_wilayah.'" class="accordion-collapse collapse" aria-labelledby="headingOne'.$id_wilayah.'" data-bs-parent="#accordionExample" style="">';
                echo '      <div class="accordion-body" id="">';
                echo '          <div class="row mb-3">';
                echo '              <div class="col col-md-4"><small class="credit">Kode</small></div>';
                echo '              <div class="col col-md-8"><small class="credit"><code>'.$id_wilayah.'</code></small></div>';
                echo '          </div>';
                echo '          <div class="row mb-3 border-1 border-bottom">';
                echo '              <div class="col col-md-4"><small class="credit">Nama Provinsi</small></div>';
                echo '              <div class="col col-md-8"><small class="credit"><code>'.$propinsi.'</code></small></div>';
                echo '          </div>';
                echo '          <div class="row mb-3">';
                echo '              <div class="col col-md-12" id="ListKabupatenByPropinsi'.$id_wilayah.'">';
                echo '                  ';
                echo '              </div>';
                echo '          </div>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
                $no++;
            }
        }
    ?>
</div>
<script>
    $(".ClickProvinsi").click(function() {
        var id_wilayah = $(this).attr('value');
        $('#ListKabupatenByPropinsi'+id_wilayah+'').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RegionalData/ListKabupatenByPropinsi.php',
            data        : {id_wilayah: id_wilayah},
            success     : function(data){
                $('#ListKabupatenByPropinsi'+id_wilayah+'').html(data);
            }
        });
    });

</script>
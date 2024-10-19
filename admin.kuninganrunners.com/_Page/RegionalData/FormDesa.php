<script>
    //Ketika Provinsi Change
    $('#GetProvinsi2').change(function(){
        var GetProvinsi2 = $('#GetProvinsi2').val();
        $('#GetKabupaten').html('<option>Loading..</option>');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RegionalData/PilihKabupaten.php',
            data        : {propinsi: GetProvinsi2},
            success     : function(data){
                $('#GetKabupaten').html(data);
            }
        });
    });
    //Ketika Kabupaten Change
    $('#GetKabupaten').change(function(){
        var kabupaten = $('#GetKabupaten').val();
        $('#kecamatan').html('<option>Loading..</option>');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RegionalData/PilihKecamatan.php',
            data        : {kabupaten: kabupaten},
            success     : function(data){
                $('#kecamatan').html(data);
            }
        });
    });
</script>
<div class="row">
    <div class="col-md-6 mt-3">
        <label for="propinsi">Provinsi</label>
        <select name="propinsi" id="GetProvinsi2" class="form-control">
            <option value="">Pilih</option>
            <?php
                //Connection
                include "../../_Config/Connection.php";
                $QryKabupaten = mysqli_query($Conn, "SELECT DISTINCT propinsi FROM wilayah ORDER BY propinsi ASC");
                while ($DataKabupaten = mysqli_fetch_array($QryKabupaten)) {
                    $propinsi= $DataKabupaten['propinsi'];
                    echo '<option value="'.$propinsi.'">'.$propinsi.'</option>';
                }
            ?>
        </select>
    </div>
    <div class="col-md-6 mt-3">
        <label for="kabupaten">Kabupaten</label>
        <select name="kabupaten" id="GetKabupaten" class="form-control">
            <option value="">Pilih</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mt-3">
        <label for="kecamatan">Kecamatan</label>
        <select name="kecamatan" id="kecamatan" class="form-control">
            <option value="">Pilih</option>
        </select>
    </div>
    <div class="col-md-6 mt-3">
        <label for="desa">Desa</label>
        <input type="text" name="desa" id="desa" class="form-control">
    </div>
</div>
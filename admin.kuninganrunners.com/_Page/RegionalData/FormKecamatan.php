<script>
    //Ketika Provinsi Change
    $('#GetProvinsi').change(function(){
        var propinsi = $('#GetProvinsi').val();
        $('#kabupaten').html('<option>Loading..</option>');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RegionalData/PilihKabupaten.php',
            data        : {propinsi: propinsi},
            success     : function(data){
                $('#kabupaten').html(data);
            }
        });
    });
</script>
<div class="row">
    <div class="col-md-6 mt-3">
        <label for="propinsi">Provinsi</label>
        <select name="propinsi" id="GetProvinsi" class="form-control">
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
        <select name="kabupaten" id="kabupaten" class="form-control">
            <option value="">Pilih</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mt-3">
        <label for="kecamatan">Kecamatan</label>
        <input type="text" name="kecamatan" id="kecamatan" class="form-control">
    </div>
</div>
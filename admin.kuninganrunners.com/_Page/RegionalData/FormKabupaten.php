<div class="row">
    <div class="col-md-6 mt-3">
        <label for="propinsi">Provinsi</label>
        <select name="propinsi" id="propinsi" class="form-control">
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
        <input type="text" name="kabupaten" id="kabupaten" class="form-control">
    </div>
</div>
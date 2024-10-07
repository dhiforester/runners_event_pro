<?php
    if(!empty($_SESSION['NotifikasiSwal'])){
        $NotifikasiSwal=$_SESSION['NotifikasiSwal'];
?>
    <!------- Notifikasi ------------>
    <?php if($NotifikasiSwal=="Login Berhasil"){ ?>
        <script>
            Swal.fire(
                'Selamat Datang!',
                'Login Berhasil!',
                'success'
            )
        </script>
    <?php } ?>
    <?php if($NotifikasiSwal=="Edit Akses Berhasil"){ ?>
        <script>
            Swal.fire(
                'Berhasil!',
                'Edit Akses Berhasil!',
                'success'
            )
        </script>
    <?php } ?>
    <?php if($NotifikasiSwal=="Ubah Foto Profil Berhasil"){ ?>
        <script>
            Swal.fire(
                'Berhasil!',
                'Ubah Foto Profil Berhasil!',
                'success'
            )
        </script>
    <?php } ?>
    <?php if($NotifikasiSwal=="Ubah Password Berhasil"){ ?>
        <script>
            Swal.fire(
                'Berhasil!',
                'Ubah Password Berhasil!',
                'success'
            )
        </script>
    <?php } ?>
    <?php if($NotifikasiSwal=="Tambah Transaksi Berhasil"){ ?>
        <script>
            Swal.fire(
                'Berhasil!',
                'Tambah Transaksi Berhasil!',
                'success'
            )
        </script>
    <?php } ?>
    <?php if($NotifikasiSwal=="Tambah Auto Jurnal Berhasil"){ ?>
        <script>
            Swal.fire(
                'Berhasil!',
                'Tambah Auto Jurnal Berhasil!',
                'success'
            )
        </script>
    <?php } ?>
    <?php if($NotifikasiSwal=="Update Auto Jurnal Berhasil"){ ?>
        <script>
            Swal.fire(
                'Berhasil!',
                'Update Auto Jurnal Berhasil!',
                'success'
            )
        </script>
    <?php } ?>
    <?php if($NotifikasiSwal=="Simpan Setting General Berhasil"){ ?>
        <script>
            Swal.fire(
                'Berhasil!',
                'Simpan Setting General Berhasil',
                'success'
            )
        </script>
    <?php } ?>
    <?php if($NotifikasiSwal=="Simpan Setting Email Berhasil"){ ?>
        <script>
            Swal.fire(
                'Berhasil!',
                'Simpan Setting Email Berhasil',
                'success'
            )
        </script>
    <?php } ?>
    <?php if($NotifikasiSwal=="Simpan Help Berhasil"){ ?>
        <script>
            Swal.fire(
                'Berhasil!',
                'Simpan Help Berhasil!',
                'success'
            )
        </script>
    <?php } ?>
    <?php if($NotifikasiSwal=="Simpan Help Berhasil"){ ?>
        <script>
            Swal.fire(
                'Berhasil!',
                'Simpan Help Berhasil!',
                'success'
            )
        </script>
    <?php } ?>
    <?php if($NotifikasiSwal=="Edit Email Anggota Berhasil"){ ?>
        <script>
            Swal.fire(
                'Berhasil!',
                'Edit Email Berhasil!',
                'success'
            )
        </script>
    <?php } ?>
<?php 
    unset($_SESSION['NotifikasiSwal']);
    }
?>
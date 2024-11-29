<div class="modal fade" id="ModalFilterGrapik" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="index.php?Page=LaporanTransaksi" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title text-dark">
                        <i class="bi bi-graph-down"></i> Mode Grafik
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="periode_riwayat">
                                <small>Periode</small>
                            </label>
                        </div>
                        <div class="col col-md-8">
                            <select name="periode" id="periode_riwayat" class="form-control">
                                <option value="Bulanan">Bulanan</option>
                                <option value="Harian">Harian</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col col-md-4">
                            <label for="periode_tahun">
                                <small>Tahun</small>
                            </label>
                        </div>
                        <div class="col col-md-8">
                            <input type="number" min="2000" max="<?php echo date('Y'); ?>" name="periode_tahun" id="periode_tahun" class="form-control" value="<?php echo date('Y'); ?>">
                        </div>
                    </div>
                    <div class="row mb-3" id="FormBulan">
                        <div class="col-md-4">
                            <label for="periode_bulan">
                                <small>Bulan</small>
                            </label>
                        </div>
                        <div class="col-md-8">
                            <select name="periode_bulan" id="periode_bulan" class="form-control">
                                <?php
                                    // Array nama bulan dalam bahasa Indonesia
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
                                    foreach ($bulanIndo as $key => $namaBulan) {
                                        if($key==date('m')){
                                            echo '<option selected value="'.$key.'">'.$namaBulan.'</option>';
                                        }else{
                                            echo '<option value="'.$key.'">'.$namaBulan.'</option>';
                                        }
                                    }
                                ?>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-check-circle"></i> Tampilkan
                    </button>
                    <button type="button" class="btn btn-dark btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
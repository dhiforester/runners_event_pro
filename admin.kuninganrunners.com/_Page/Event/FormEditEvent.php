<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($SessionIdAkses)){
        echo '<div class="row mb-3">';
        echo '  <div class="col-md-12">';
        echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
        echo '          <small class="credit">';
        echo '              <code class="text-dark">';
        echo '                  Sesi Akses Sudah Berakhir, Silahkan Login Uang!';
        echo '              </code>';
        echo '          </small>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['id_event'])){
            echo '<div class="row mb-3">';
            echo '  <div class="col-md-12">';
            echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
            echo '          <small class="credit">';
            echo '              <code class="text-dark">';
            echo '                  ID Event Tidak Boleh Kosong!';
            echo '              </code>';
            echo '          </small>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_event=$_POST['id_event'];
            //Bersihkan Data
            $id_event=validateAndSanitizeInput($id_event);
            //Buka Data
            $id_event_validasi=GetDetailData($Conn,'event','id_event',$id_event,'id_event');
            if(empty($id_event_validasi)){
                echo '<div class="row mb-3">';
                echo '  <div class="col-md-12">';
                echo '      <div class="alert alert-warning border-1 alert-dismissible fade show" role="alert">';
                echo '          <small class="credit">';
                echo '              <code class="text-dark">';
                echo '                  Data Yang Anda Pilih Tidak Ditemukan Pada Database!';
                echo '              </code>';
                echo '          </small>';
                echo '      </div>';
                echo '  </div>';
                echo '</div>';
            }else{
                $tanggal_mulai=GetDetailData($Conn,'event','id_event',$id_event,'tanggal_mulai');
                $tanggal_selesai=GetDetailData($Conn,'event','id_event',$id_event,'tanggal_selesai');
                $mulai_pendaftaran=GetDetailData($Conn,'event','id_event',$id_event,'mulai_pendaftaran');
                $selesai_pendaftaran=GetDetailData($Conn,'event','id_event',$id_event,'selesai_pendaftaran');
                $nama_event=GetDetailData($Conn,'event','id_event',$id_event,'nama_event');
                $keterangan=GetDetailData($Conn,'event','id_event',$id_event,'keterangan');
                $poster=GetDetailData($Conn,'event','id_event',$id_event,'poster');
                $rute=GetDetailData($Conn,'event','id_event',$id_event,'rute');
                //format Data
                $strtotime1=strtotime($tanggal_mulai);
                $strtotime2=strtotime($tanggal_selesai);
                $strtotime3=strtotime($mulai_pendaftaran);
                $strtotime4=strtotime($selesai_pendaftaran);
                //Format Waktu
                $tanggal_mulai_format=date('Y-m-d',$strtotime1);
                $jam_mulai_format=date('H:i:s',$strtotime1);
                $tanggal_selesai_format=date('Y-m-d',$strtotime2);
                $jam_selesai_format=date('H:i:s',$strtotime2);
                $tanggal_mulai_pendaftaran_format=date('Y-m-d',$strtotime3);
                $jam_mulai_pendaftaran_format=date('H:i:s',$strtotime3);
                $tanggal_selesai_pendaftaran_format=date('Y-m-d',$strtotime4);
                $jam_selesai_pendaftaran_format=date('H:i:s',$strtotime4);
?>
        <input type="hidden" name="id_event" value="<?php echo $id_event; ?>">
        <div class="row mb-3 border-1 border-bottom">
            <div class="col-md-12 mb-3">
                <small>
                    <b>A. Tanggal & Waktu Event</b>
                </small>
            </div>
            <div class="col-md-12 mb-3">
                <div class="row mb-3">
                    <div class="col-md-4 mb-3">
                        <small>
                            A.1 Tanggal & Waktu Mulai
                        </small>
                    </div>
                    <div class="col col-md-4 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroupPrepend">
                                <small>
                                    <i class="bi bi-calendar"></i>
                                </small>
                            </span>
                            <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai_edit" value="<?php echo $tanggal_mulai_format; ?>">
                        </div>
                        <small>
                            <code class="text text-grayish">
                                <label for="tanggal_mulai_edit">Tanggal</label>
                            </code>
                        </small>
                    </div>
                    <div class="col col-md-4 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroupPrepend">
                                <small>
                                    <i class="bi bi-clock"></i>
                                </small>
                            </span>
                            <input type="time" class="form-control" name="jam_mulai" id="jam_mulai_edit" value="<?php echo $jam_mulai_format; ?>">
                        </div>
                        <small>
                            <code class="text text-grayish">
                                <label for="jam_mulai_edit">Waktu/Jam</label>
                            </code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 mb-3">
                        <small>
                            A.2 Tanggal & Waktu Selesai
                        </small>
                    </div>
                    <div class="col col-md-4 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroupPrepend">
                                <small>
                                    <i class="bi bi-calendar"></i>
                                </small>
                            </span>
                            <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" id="jam_mulai_edit" value="<?php echo $tanggal_selesai_format; ?>">
                        </div>
                        <small>
                            <code class="text text-grayish">
                                <label for="tanggal_selesai">Tanggal</label>
                            </code>
                        </small>
                    </div>
                    <div class="col col-md-4 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroupPrepend">
                                <small>
                                    <i class="bi bi-clock"></i>
                                </small>
                            </span>
                            <input type="time" class="form-control" name="jam_selesai" id="jam_selesai" value="<?php echo $jam_selesai_format; ?>">
                        </div>
                        <small>
                            <code class="text text-grayish">
                                <label for="jam_selesai">Waktu/Jam</label>
                            </code>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3 border-1 border-bottom">
            <div class="col-md-12 mb-3">
                <small>
                    <b>B. Tanggal & Waktu Pendaftaran</b>
                </small>
            </div>
            <div class="col-md-12 mb-3">
                <div class="row mb-3">
                    <div class="col-md-4 mb-3">
                        <small>
                            B.1 Tanggal & Waktu Mulai
                        </small>
                    </div>
                    <div class="col col-md-4 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroupPrepend">
                                <small>
                                    <i class="bi bi-calendar"></i>
                                </small>
                            </span>
                            <input type="date" class="form-control" name="tanggal_mulai_pendaftaran" id="tanggal_mulai_pendaftaran_edit" value="<?php echo $tanggal_mulai_pendaftaran_format; ?>">
                        </div>
                        <small>
                            <code class="text text-grayish">
                                <label for="tanggal_mulai_pendaftaran_edit">Tanggal</label>
                            </code>
                        </small>
                    </div>
                    <div class="col col-md-4 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroupPrepend">
                                <small>
                                    <i class="bi bi-clock"></i>
                                </small>
                            </span>
                            <input type="time" class="form-control" name="jam_mulai_pendaftaran" id="jam_mulai_pendaftaran_edit" value="<?php echo $jam_mulai_pendaftaran_format; ?>">
                        </div>
                        <small>
                            <code class="text text-grayish">
                                <label for="jam_mulai_pendaftaran_edit">Waktu/Jam</label>
                            </code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 mb-3">
                        <small>
                            B.2 Tanggal & Waktu Selesai
                        </small>
                    </div>
                    <div class="col col-md-4 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroupPrepend">
                                <small>
                                    <i class="bi bi-calendar"></i>
                                </small>
                            </span>
                            <input type="date" class="form-control" name="tanggal_selesai_pendaftaran" id="tanggal_selesai_pendaftaran_edit" value="<?php echo $tanggal_selesai_pendaftaran_format; ?>">
                        </div>
                        <small>
                            <code class="text text-grayish">
                                <label for="tanggal_selesai_pendaftaran_edit">Tanggal</label>
                            </code>
                        </small>
                    </div>
                    <div class="col col-md-4 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroupPrepend">
                                <small>
                                    <i class="bi bi-clock"></i>
                                </small>
                            </span>
                            <input type="time" class="form-control" name="jam_selesai_pendaftaran" id="jam_selesai_pendaftaran_edit" value="<?php echo $jam_selesai_pendaftaran_format; ?>">
                        </div>
                        <small>
                            <code class="text text-grayish">
                                <label for="jam_selesai_pendaftaran_edit">Waktu/Jam</label>
                            </code>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3 border-1 border-bottom">
            <div class="col-md-12 mb-3">
                <small>
                    <b>C. Informasi Umum</b>
                </small>
            </div>
            <div class="col-md-12 mb-3">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <small>
                            C.1 Judul/Nama Event
                        </small>
                    </div>
                    <div class="col col-md-8">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroupPrepend">
                                <small>
                                    <code class="text text-dark" id="nama_event_edit_length">0/100</code>
                                </small>
                            </span>
                            <input type="text" class="form-control" name="nama_event" id="nama_event_edit" value="<?php echo $nama_event; ?>">
                        </div>
                        <small>
                            <code class="text text-grayish">
                                <label for="nama_event_edit">Nama event yang merepresentasikan penyelenggaraan kegiatan</label>
                            </code>
                        </small>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <small>
                            C.2 Keterangan/Deskripsi
                        </small>
                    </div>
                    <div class="col col-md-8">
                        <small>
                            <code class="text text-dark" id="keterangan_edit_length">0/500</code>
                        </small>
                        <textarea name="keterangan" id="keterangan_edit" class="form-control"><?php echo $keterangan; ?></textarea>
                        <small>
                            <code class="text text-grayish">
                                <label for="keterangan_edit">Gambaran umum tentang event/kegiatan yang akan dilaksanakan</label>
                            </code>
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <script>
            // Fungsi untuk mengecek panjang input nama_event
            $('#nama_event_edit').on('input', function () {
                var maxLength = 100;
                var currentLength = $(this).val().length;
                $('#nama_event_edit_length').text(currentLength + '/' + maxLength);

                if (currentLength > maxLength) {
                    $(this).val($(this).val().substring(0, maxLength));
                    $('#nama_event_edit_length').text(maxLength + '/' + maxLength);
                    Swal.fire('Perhatian', 'Nama event tidak boleh lebih dari 100 karakter.', 'warning');
                }
            });

            // Fungsi untuk mengecek panjang input keterangan
            $('#keterangan_edit').on('input', function () {
                var maxLength = 500;
                var currentLength = $(this).val().length;
                $('#keterangan_edit_length').text(currentLength + '/' + maxLength);

                if (currentLength > maxLength) {
                    $(this).val($(this).val().substring(0, maxLength));
                    $('#keterangan_edit_length').text(maxLength + '/' + maxLength);
                    Swal.fire('Perhatian', 'Keterangan tidak boleh lebih dari 500 karakter.', 'warning');
                }
            });
            // Inisialisasi panjang karakter saat halaman pertama kali dimuat
            $(document).ready(function () {
                var namaEventLength = $('#nama_event_edit').val().length;
                var maxNamaEventLength = 100;
                $('#nama_event_edit_length').text(namaEventLength + '/' + maxNamaEventLength);

                var keteranganLength = $('#keterangan_edit').val().length;
                var maxKeteranganLength = 500;
                $('#keterangan_edit_length').text(keteranganLength + '/' + maxKeteranganLength);
            });
        </script>
<?php
            }
        }
    }
?>
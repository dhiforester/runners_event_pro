<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/SettingGeneral.php";
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
        echo '<iframe src="'.$base_url.'/_Page/Event/LihatHasilSertifikat.php?id='.$id_event.'" width="100%" height="100%" frameborder="0"></iframe>';
    }
?>
<script>
    document.addEventListener('show.bs.modal', function (event) {
        const modal = event.target;
        if (modal.id === "ModalPreviewSertifikat") {
            const modalBody = modal.querySelector('.modal-body');
            const iframe = modalBody.querySelector('iframe');

            // Hitung tinggi modal body dan sesuaikan tinggi iframe
            const modalHeaderHeight = modal.querySelector('.modal-header').offsetHeight || 0;
            const modalFooterHeight = modal.querySelector('.modal-footer').offsetHeight || 0;
            const modalBodyHeight = window.innerHeight - (modalHeaderHeight + modalFooterHeight);

            iframe.style.height = modalBodyHeight + 'px';
        }
    });
</script>

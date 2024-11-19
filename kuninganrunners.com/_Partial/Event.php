<?php
    session_start();
    include "../_Config/Connection.php";
    include "../_Config/GlobalFunction.php";
    //Menangkan xtoken dari session
    if(empty($_SESSION['xtoken'])){
        echo "Sessi Token Tidak Ada!";
    }else{
        $xtoken=$_SESSION['xtoken'];
        //Buka Fungsi List Event
        $WebAllEvent=WebListAllEvent($url_server,$xtoken);
        $WebAllEvent=json_decode($WebAllEvent, true);
        if($WebAllEvent['response']['code']!==200){
            echo $WebAllEvent['response']['message'];
        }else{
            $jumlah_event=count($WebAllEvent['metadata']);
            if(empty($jumlah_event)){
                echo "Tidak Ada Event Yang Ditampilkan";
            }else{
                $metadata=$WebAllEvent['metadata'];
                foreach($metadata as $event_list){
                    $id_event=$event_list['id_event'];
                    $tanggal_mulai=$event_list['tanggal_mulai'];
                    $nama_event=$event_list['nama_event'];
                    //Format Datetime
                    $strtotime1=strtotime($tanggal_mulai);
                    $tanggal_mulai_format=date('d F Y',$strtotime1);
?>
                <a href="index.php?Page=DetailEvent&id=<?php echo $id_event; ?>">
                    <div class="card mb-3 card-event" id="">
                        <div class="card-body" >
                            <div class="row">
                                <div class="col-md-3">
                                    <small><?php echo $tanggal_mulai_format; ?></small>
                                </div>
                                <div class="col-md-9">
                                    <small class="text text-grayish"><?php echo $nama_event; ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
<?php
                }
            }
        }
    }
?>
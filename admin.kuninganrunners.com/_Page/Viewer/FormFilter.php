<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{
        $keyword_by=$_POST['keyword_by'];
        if($keyword_by=="tanggal"){
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="page_url"){
                echo '<input type="text" name="keyword" id="keyword" class="form-control" placeholder="https://">';
            }else{
                if($keyword_by=="ip_viewer"){
                    echo '<input type="text" name="keyword" id="keyword" class="form-control" placeholder="Contoh: 127.0.0.1">';
                }else{
                    if($keyword_by=="os_viewer"){
                        echo '<select name="keyword" id="keyword" class="form-control">';
                        echo '  <option value="">Pilih</option>';
                        //Arraykan Data Status Akses
                        $query = mysqli_query($Conn, "SELECT DISTINCT os_viewer FROM web_log");
                        while ($data = mysqli_fetch_array($query)) {
                            if(!empty($data['os_viewer'])){
                                $os_viewer= $data['os_viewer'];
                                echo '  <option value="'.$os_viewer.'">'.$os_viewer.'</option>';
                            }
                        }
                        echo '</select>';
                    }else{
                        if($keyword_by=="browser_viewer"){
                            echo '<select name="keyword" id="keyword" class="form-control">';
                            echo '  <option value="">Pilih</option>';
                            //Arraykan Data Status Akses
                            $query = mysqli_query($Conn, "SELECT DISTINCT browser_viewer FROM web_log");
                            while ($data = mysqli_fetch_array($query)) {
                                if(!empty($data['browser_viewer'])){
                                    $browser_viewer= $data['browser_viewer'];
                                    echo '  <option value="'.$browser_viewer.'">'.$browser_viewer.'</option>';
                                }
                            }
                            echo '</select>';
                        }else{
                            echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                        }
                    }
                }
            }
        }
    }
?>
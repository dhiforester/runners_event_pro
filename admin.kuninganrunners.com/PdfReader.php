<?php
    if(!empty($_GET['dir'])){
        if(!empty($_GET['fl'])){
            $dir=$_GET['dir'];
            $fl=$_GET['fl'];
            $path="assets/img/$dir/$fl";
            // Check if file exists
            if (file_exists($path)) {
                // Get content and encode it to Base64
                $pdf_data = base64_encode(file_get_contents($path));
                $base64_pdf = 'data:application/pdf;base64,' . $pdf_data;
                echo '<iframe src="'.$base64_pdf.'" width="100%" height="600px" style="border: none;">';
                echo '  PDF tidak dapat ditampilkan.';
                echo '</iframe>';
            }
        }
    }
?>
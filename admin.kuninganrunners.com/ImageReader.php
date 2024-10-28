<?php
    if(!empty($_GET['dir'])){
        if(!empty($_GET['fl'])){
            $dir=$_GET['dir'];
            $fl=$_GET['fl'];
            $image_path="assets/img/$dir/$fl";
            // Check if file exists
            if (file_exists($image_path)) {
                // Get image content and encode it to Base64
                $image_data = base64_encode(file_get_contents($image_path));
                
                // Get the MIME type of the file (e.g., image/jpeg)
                $mime_type = mime_content_type($image_path);
                
                // Combine MIME type and Base64 data
                $base64_image = "data:$mime_type;base64,$image_data";
                echo '<img src="'.$base64_image.'" alt="Image" />';
            }
        }
    }
?>
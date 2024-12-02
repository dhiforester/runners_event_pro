<?php
    // Set directory path
    $logo_path = "../../assets/img/Medsos/";
    // Check if the file name is provided
    if (isset($_GET['file'])) {
        // Sanitize file name
        $file_name = basename($_GET['file']); // Prevent directory traversal attacks
        
        // Full path to the file
        $file_path = $logo_path . $file_name;

        // Check if file exists and is a valid image
        if (file_exists($file_path) && @getimagesize($file_path)) {
            // Get the MIME type of the image
            $mime_type = mime_content_type($file_path);

            // Set appropriate headers
            header("Content-Type: $mime_type");
            header("Content-Length: " . filesize($file_path));

            // Output the file content
            readfile($file_path);
        } else {
            // File not found or not an image
            header("HTTP/1.0 404 Not Found");
            echo "Error: File not found or invalid image.";
        }
    } else {
        // No file parameter provided
        header("HTTP/1.0 400 Bad Request");
        echo "Error: No file specified.";
    }
?>
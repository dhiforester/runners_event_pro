<?php
include "../../_Config/Connection.php";
include "../../_Config/SettingGeneral.php";

/***************************************************
 * Only these origins are allowed to upload images *
 ***************************************************/
$accepted_origins = array(
    "http://localhost:81/",
    "http://localhost:81",
    "http://localhost/",
    "http://localhost",
    "http://localhost:81/admin.kuninganrunners.com/",
    "http://localhost:81/admin.kuninganrunners.com",
    "$base_url/",
    "$base_url"
);

/*********************************************
 * Change this line to set the upload folder *
 *********************************************/
$imageFolder = "../../assets/img/Help/";

if (isset($_SERVER['HTTP_ORIGIN'])) {
    // same-origin requests won't set an origin. If the origin is set, it must be valid.
    if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    } else {
        header("HTTP/1.1 403 Origin Denied");
        return;
    }
}

// Don't attempt to process the upload on an OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    return;
}

reset($_FILES);
$temp = current($_FILES);

if (is_uploaded_file($temp['tmp_name'])) {
    /*
    If your script needs to receive cookies, set images_upload_credentials : true in
    the configuration and enable the following two headers.
    */
    // header('Access-Control-Allow-Credentials: true');
    // header('P3P: CP="There is no P3P policy."');

    // Sanitize input
    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.1 400 Invalid file name.");
        return;
    }

    // Verify extension
    $extension = strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, array("gif", "jpg", "png"))) {
        header("HTTP/1.1 400 Invalid extension.");
        return;
    }

    // Generate a random filename with 16 characters
    $randomFileName = bin2hex(random_bytes(8)) . '.' . $extension;

    // Set the full path to the renamed file
    $filetowrite = $imageFolder . $randomFileName;
    move_uploaded_file($temp['tmp_name'], $filetowrite);

    // Determine the base URL
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "https://" : "http://";
    $baseurl = $protocol . $_SERVER["HTTP_HOST"] . rtrim(dirname($_SERVER['REQUEST_URI']), "/") . "/";

    // Respond to the successful upload with JSON.
    // Use a location key to specify the path to the saved image resource.
    echo json_encode(array('location' => $baseurl . $filetowrite));
} else {
    // Notify editor that the upload failed
    header("HTTP/1.1 500 Server Error");
}
?>

<html lang="HTML5">
<head>    <title>PHP Quick Start</title>  </head>
<body>
<?php

require __DIR__ . '/vendor/autoload.php';

// Use the Configuration class 
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Api\Admin\AdminApi;

// Configure an instance of your Cloudinary cloud
Configuration::instance('cloudinary://385881596145311:ThUGCBXJKc2Ei2WGFN6GrfXpeJs@dmmf2gbut?secure=true');

// Upload the image
$upload = new UploadApi();
echo '<pre>';
echo json_encode(
    $upload->upload('https://res.cloudinary.com/demo/image/upload/flower.jpg', [
        'public_id' => 'flower_sample',
        'use_filename' => TRUE,
        'overwrite' => TRUE]),
    JSON_PRETTY_PRINT
);
echo '</pre>';

$admin = new AdminApi();
echo '<pre>';
echo json_encode($admin->asset('flower_sample', [
    'colors' => TRUE]), JSON_PRETTY_PRINT
);
echo '</pre>';
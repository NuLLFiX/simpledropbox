<?php
/*
 * jQuery File Upload Plugin PHP Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

//error_reporting(E_ALL | E_STRICT);

/* AJAX check  */
if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	die('No direct access, plsktnxbai');
}

// basic config start
include('config.php');
require('UploadHandler.php');

$custom_dir = $_REQUEST['custom_dir'];

if($custom_dir != '') { $_CONFIG['upload_path'] = $_CONFIG['upload_path'] . DIRECTORY_SEPARATOR . $custom_dir; }

//var_dump($custom_dir); exit();

$options = array(
                'upload_dir'=> $_CONFIG['upload_path'].'/',
//              'upload_url'=>'server/php/dummyXXXX',   // This option will not have any effect because thumbnail creation is disabled
                'image_versions' => array(),            // This option will disable creating thumbnail images and will not create that extra folder.
                'param_name' => 'upl',                  // However, due to this, the images preview will not be displayed after upload
                'accept_file_types' => $_CONFIG['file_types'],
);

$upload_handler = new UploadHandler($options , true , null);

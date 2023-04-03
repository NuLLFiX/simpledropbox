<?php
include 'config.php';
if($_CONFIG['admin_pw'] != '' || $_CONFIG['allow_up'] == false) {
    // authentication code!
    $valid_passwords = array ("admin" => $_CONFIG['admin_pw']);
    $valid_users = array_keys($valid_passwords);

    $user = $_SERVER['PHP_AUTH_USER'];
    $pass = $_SERVER['PHP_AUTH_PW'];

    $validated = (in_array($user, $valid_users)) && ($pass == $valid_passwords[$user]);

    if (!$validated) {
      header('WWW-Authenticate: Basic realm="Simple Dropbox"');
      header('HTTP/1.0 401 Unauthorized');
      die ("Not authorized!");
    }
    // If arrives here, is a valid user. Script starts from here on!
}
function getDirContents($dir, &$results = array()){
    $files = array_diff(scandir($dir), array('..', '.', '.htaccess', 'index.php'));

    foreach($files as $key => $value){
        $path = $dir.DIRECTORY_SEPARATOR.$value;
        if(!is_dir($path)) {
            $results[] = $path;
        } else if(is_dir($path) && $value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}
// Generate the html directory select element.
$scanned_directory = getDirContents($_CONFIG['upload_path']);
//var_dump($scanned_directory);
$result = '<select id="directory">'."\n";
$result .= '<option value="">Default Folder</option>'."\n";
foreach($scanned_directory as $entry) {
    if (is_dir($entry)) {
    $entry = str_replace($_CONFIG['upload_path'].DIRECTORY_SEPARATOR, "", $entry);
    $result .= '<option value="'.$entry.'">'.ucfirst($entry).'</option>'."\n";
    }
}
$result .= '</select>'."\n";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Simple DropBox</title>

		<!-- Google web fonts -->
		<link href='https://fonts.googleapis.com/css?family=Cardo:400,700&subset=greek,latin' rel='stylesheet' type='text/css'>

		<!-- The main CSS file -->
		<link href="assets/css/style.css" rel="stylesheet" />
	</head>

	<body>
            <div class="logo"><img src="assets/img/simpledropbox.png" alt="site logo" /></div>
            <div class="ribbon">
            <form id="upload" method="post" action="upload.php" enctype="multipart/form-data">
			<div id="drop">
				Drop Here

				<a>Browse</a>
				<input type="file" name="upl" multiple />
			</div>

			<ul>
				<!-- The file uploads will be shown here -->
			</ul>
                    
                    <?=$result?>

		</form>
            </div>
       
		<!-- JavaScript Includes -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="assets/js/jquery.knob.js"></script>

		<!-- jQuery File Upload Dependencies -->
		<script src="assets/js/jquery.ui.widget.js"></script>
		<script src="assets/js/jquery.iframe-transport.js"></script>
		<script src="assets/js/jquery.fileupload.js"></script>
		
		<!-- Our main JS file -->
		<script src="assets/js/script.js"></script>
<footer>© simple dropbox <?=$_CONFIG['scriptv']?> by <a href="http://nullfix.com">NuLLFiX</a><footer>
	</body>
</html>
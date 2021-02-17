<?php
include "./_common.php";

$data = new stdClass();
$errFiles = array();
$error = array();

for ($i = 0; $i < count($_FILES["file"]["name"]); $i++) {
	$isUpload = is_uploaded_file($_FILES['file']['tmp_name'][$i]);
	// SUCCESSFUL
	if ($isUpload) {
		$ym = date('ym', G5_SERVER_TIME);
	
		// $data_dir =  '/editor/' . $ym;
		$data_dir = G5_DATA_PATH . '/editor/' . $ym;
		$data_url =  '/data/editor/' . $ym;
		// $data_url = G5_DATA_URL . '/editor/' . $ym;
	
		@mkdir($data_dir, G5_DIR_PERMISSION);
		@chmod($data_dir, G5_DIR_PERMISSION);
	
		$tmp_name = $_FILES['file']['tmp_name'][$i];
		$name = $_FILES['file']['name'][$i];
	
		$filename_ext = strtolower(array_pop(explode('.', $name)));
		$mime_result = ' ' . @mime_content_type($tmp_name) . @shell_exec('file -bi ' . $tmp_name);
	
		// thanks to @dewoweb 
		if (!preg_match("/(jpe?g|gif|bmp|png)$/i", $filename_ext)) {   // check file extension 
			// error
			@unlink($tmp_name);
			array_push($errFiles, $name); // file type error 
			array_push($error, "파일 타입이 다릅니다.");
			// $errFiles[$i] = array('success' => false, 'error' => 100); // file type error 
		} else if (
			!stripos($mime_result, 'jpeg') &&							// check file mime-type 
			!stripos($mime_result, 'jpg') &&
			!stripos($mime_result, 'gif') &&
			!stripos($mime_result, 'bmp') &&
			!stripos($mime_result, 'png') 
		) {
			@unlink($tmp_name);
			array_psuh($errFiles, $name);
			array_psuh($error, "Mime 타입이 다릅니다.");
			// $errFiles[$i] = array('success' => false, 'error' => 101);
		} else if (!getimagesize($tmp_name)) {	// check image resolution, if resolutions is null, return fail 
			@unlink($tmp_name);
			array_push($errFiles, $name);
			array_push($error, "0 byte 파일은 업로드 할 수 없습니다.");
			// $errFiles[$i] = array('success' => false, 'error' => 102);
		} else {
	
			$file_name = sprintf('%u', ip2long($_SERVER['REMOTE_ADDR'])) . '_' . get_microtime() . "." . $filename_ext;
			$save_dir = sprintf('%s/%s', $data_dir, $file_name);
			$save_url = sprintf('%s/%s', $data_url, $file_name);
	
			@move_uploaded_file($tmp_name, $save_dir);
	
			// $json[$i] = array( $name => $save_url);
			$data->$name = $save_url;
		}
	} else {
		array_push($errFiles, $name);
		switch ((int)$_FILES['file']['error'][$i]) {
			case 1:
				array_push($error, "php.ini 업로드 용량 제한에 걸렸습니다.");
				break;
			case 2:
				array_push($error, "MAX_FILE_SIZE 보다 큰 파일은 업로드할 수 없습니다.");
				break;
			case 3:
				array_push($error, "파일이 일부분만 전송되었습니다.");
				break;
			case 4:
				array_push($error, "파일이 전송되지 않았습니다.");
				break;
			case 5:
				array_push($error, "임시 폴더가 없습니다.");
				break;
			case 6:
				array_push($error, "파일 쓰기 실패");
				break;
			case 7:
				array_push($error, "알수 없는 오류입니다.");
				break;
		}
		// array_push($error, $_FILES['file']['error'][$i]);
		// $error = $_FILES['file']['error'][$i];
	
		// refer to error code : http://www.php.net/manual/en/features.file-upload.errors.php
		// example)  1 is error for upload_max_filesize 
		// echo json_encode(array('success'=> false, 'error' => $error));
		$errFiles[$i] =  $name;
		// $errFiles[$i] = array('success' => false, 'error' => $error   );
	}
 }
 
//  $test = array('succMap' => $data, 'errFiles' => array($errFiles));
//  $test = array( 'errFiles' => ["1.png", "2.png"]);
if ($error) {
	$msg = "";
	for($i=0; $i<count($errFiles); $i++) {
		$msg .= $errFiles[$i]." : ".$error[$i]."<br>";
	}
} else {
	$msg = "파일이 성공적으로 업로드되었습니다.";
}

//  echo json_encode(array("data" => $test));
 echo json_encode(array('code' => 1, 'msg' => $msg, "data" => array('succMap' => $data, 'errFiles' => $errFiles )));
//  echo json_encode(array('code' => 1, 'msg' => "파일이 성공적으로 업로드되었습니다.", "data" => $test));

?>


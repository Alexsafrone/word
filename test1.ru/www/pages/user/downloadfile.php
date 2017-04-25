<?
			$file_url = './materials/hello@hello.hello/1/c6ru2m4CBD4.jpg';
			header('Content-Type: application/octet-stream');
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\""); 
			readfile($file_url); 
			?>
<?php
$directory = $path."/";
//echo $directory;
//echo "<br>";
      $files_array = array();
      
       
      $files_array = scandir($directory);
	 // print_r($files_array);
	 // exit;
	  foreach($files_array as $file){	
						if ($file != "." && $file != ".."){
							$post[] = $file;
						}
      				}
		//echo "<br>".$directory."<br>";
		//echo "<pre>";
		//print_r($post);
		//exit;
					//exit;
      if(count($files_array) > 0){
      			
      		$file_folder = $directory;	// folder to load files
      		$error = "";
      		if(extension_loaded('zip')){	// Checking ZIP extension is available
      			if(isset($post) and count($post) > 0){	// Checking files are selected
      				$zip = new ZipArchive();			// Load zip library	
      				$zip_name = "VisitorTracking_report.zip";			// Zip name
      				if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE){		// Opening zip file to load files
      					$error .=  "* Sorry ZIP creation failed at this time<br/>";
      				}
      				foreach($post as $file){				
      					$zip->addFile($file_folder.$file);	// Adding files into zip
      					
      				}
      				$zip->close();
					//exit;
      				if(file_exists($zip_name)){
      					// push to download the zip
      					header('Content-type: application/zip');
      					header('Content-Disposition: attachment; filename="'.$zip_name.'"');
      					readfile($zip_name);
      					// remove zip file is exists in temp path
      					unlink($zip_name);
      				}
      				
      			}else
      				$error .= "* Please select file to zip <br/>";
      		}else
      			$error .= "* You dont have ZIP extension<br/>";
      	}
		
?>
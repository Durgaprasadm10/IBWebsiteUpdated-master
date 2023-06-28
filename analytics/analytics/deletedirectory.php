<?php
 $dir = $path."/";
 
if ($handle = opendir($dir)) {
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != "..") { // strip the current and previous directory items
            unlink($dir . $file); // you can add some filters here, aswell, to filter datatypes, file, prefixes, suffixes, etc
        }
    }
    closedir($handle);
}
rmdir($dir);

?>
<?php
   $filename = $_GET['fic'];
   $size = filesize($filename);
   header("Pragma: no-cache");
   header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
   header("Expires: 0");
   header("Content-Transfer-Encoding: binary");
   header("Content-type: application/force-download");
   header("Content-Disposition: attachment; filename=$filename");
   header("Content-Length: $size");
   readfile("$filename");
?>

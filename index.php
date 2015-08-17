<?php
// Report all PHP errors
error_reporting(-1);

$interface="convis.php";
echo '<h1>List of conversations:</h1><br>';

$handle = @fopen("list.txt", "r");
if ($handle) {
    while (($entry = fgets($handle, 4096)) !== false) {
        echo '<a href="'.$interface.'?a=';	

        $pieces = explode(": ", $entry);        
        echo str_replace(".json","",$pieces[0]);

        echo '">';
        echo str_replace(".json","",$entry);
        echo '</a>';
        echo '<br><br>';        
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}

/*if ($handle = opendir('data/')) {
    while (false !== ($entry = readdir($handle))) {      
		if ($entry != "." && $entry != "..") {	
			echo '<a href="'.$interface.'?a=';	
			echo str_replace(".json","",$entry);
			
			echo '">';
			echo str_replace(".json","",$entry);
			echo '</a>';
			echo '<br>';
		}	
    }
    closedir($handle);
}*/
?>
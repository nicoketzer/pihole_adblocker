<?php
function update(){
	exec("sudo pihole -g");
	echo "Gravity Updated";
}
?>

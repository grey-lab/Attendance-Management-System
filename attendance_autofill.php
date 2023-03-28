<?php

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");

	handle_maintenance();

	header('Content-type: text/javascript; charset=' . datalist_db_encoding);

	$table_perms = getTablePermissions('attendance');
	if(!$table_perms[0]){ die('// Access denied!'); }

	$mfk=$_GET['mfk'];
	$id=makeSafe($_GET['id']);
	$rnd1=intval($_GET['rnd1']); if(!$rnd1) $rnd1='';

	if(!$mfk){
		die('// No js code available!');
	}

	switch($mfk){

		case 'student':
			if(!$id){
				?>
				$('regno<?php echo $rnd1; ?>').innerHTML='&nbsp;';
				<?php
				break;
			}
			$res = sql("SELECT `students`.`regno` as 'regno', `students`.`name` as 'name', IF(    CHAR_LENGTH(`courses1`.`name`), CONCAT_WS('',   `courses1`.`name`), '') as 'course' FROM `students` LEFT JOIN `courses` as courses1 ON `courses1`.`id`=`students`.`course`  WHERE `students`.`regno`='$id' limit 1", $eo);
			$row = db_fetch_assoc($res);
			?>
			$j('#regno<?php echo $rnd1; ?>').html('<?php echo addslashes(str_replace(array("\r", "\n"), '', nl2br($row['regno']))); ?>&nbsp;');
			<?php
			break;


	}

?>
<?php

$dir    = '../UserFiles/Files';
$list = array_values(array_diff(scandir($dir), array('..', '.')));
echo json_encode($list);

?>

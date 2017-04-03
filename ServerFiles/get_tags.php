<?php

error_reporting(E_ERROR | E_PARSE);

$xmlfile = '../schema.xsd';
$xmlparser = xml_parser_create();

// open a file and read data
$fp = fopen($xmlfile, 'r');
$xmldata = fread($fp, 4096);

xml_parse_into_struct($xmlparser,$xmldata,$values);

xml_parser_free($xmlparser);

$length = count($values);
$elements = [[]];
$name = "";
$i = 0;
$j = 0;
$found = true;

for ($i=0; $i < $length; $i++) {
  $tmp = [];
  if($values[$i]["tag"] == "XS:ELEMENT"){
      $name = $values[$i]["attributes"]["NAME"];
      $j = $i + 1;

      // if ($name == ""){
      //
      // }

      if ($name != "") {
          $found = false;
      }
  }

  $count = 0;

  while($found != true && $count < 100){

    if($values[$j]["tag"] == "XS:ATTRIBUTE"){

      array_push($tmp, $values[$j]["attributes"]["NAME"]);
    } else if ($values[$j]["tag"] == "XS:ELEMENT"){

      $found = true;
    }

    $j++;
    $count++;
  }
  if (!empty($tmp)){
    array_push($elements, array($name => $tmp));
  }
}

$output = array_values(array_filter($elements));

$newarray = [];
foreach($output as $value) {
  $newarray += $value;
}
//var_dump($new);

//print_r($values);
//print_r($output);
echo json_encode($newarray);
//$unset = unset($output["LiteraryWork"]);
//print_r($unset);

?>

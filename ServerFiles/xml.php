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
  for ($i=0; $i < $length; $i++) {

      if($values[$i]["tag"] == "XS:ELEMENT"){
          $elements[] = $values[$i]["attributes"]["NAME"];
      }
      // if($values[$i]["tag"] == "XS:ATTRIBUTE"){
      //     $elements[][] = $values[$i]["attributes"]["NAME"];
      // }
  }

  $output = array_values(array_filter($elements));

  echo json_encode($output);
  //$unset = unset($output["LiteraryWork"]);
  //print_r($unset);

?>

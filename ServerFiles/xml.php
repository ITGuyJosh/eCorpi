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

      //print_r("Element Name: " . $name . "<br />");

      if ($name == ""){
        //print_r("EMPTY <br />");
      }

      if ($name != "")
          $found = false;
  }

  $count = 0;

  while($found != true && $count < 100){

    if($values[$j]["tag"] == "XS:ATTRIBUTE"){
      //print_r("FOUND ATTRIBUTE: " . $values[$j]["attributes"]["NAME"] . "<br />");
      //$elements += $values[$j]["attributes"]["NAME"];
      //if ()
      array_push($tmp, $values[$j]["attributes"]["NAME"]);
    } else if ($values[$j]["tag"] == "XS:ELEMENT"){
      //print_r("FOUND ELEMENT: " . $values[$j]["attributes"]["NAME"] .  " <br />");
      $found = true;

      //print_r((($found)? "TRUE" : "FALSE") . "<br />");
      //$i = $j;
    }

    $j++;
    $count++;
  }

  if (!empty($tmp)){
    //print_r($tmp);
    //print_r("<br />");

    //$elements[$name] = $tmp;
    array_push($elements, array($name => $tmp));
  }



  //$elements[$name];

  //if not empty then push
  //if (!is_empty($tmp))
}



// foreach($values as $value){
//
//
//
//   $elements[][] = $values[$i]["attributes"]["NAME"];
//   $name = "";
// }
// $elements[] =

// for ($i=0; $i < $length; $i++) {
//
//     if($values[$i]["tag"] == "XS:ELEMENT"){
//         $name = $values[$i]["attributes"]["NAME"];
//         $elements[] = $values[$i]["attributes"]["NAME"];
//         //$elements[][] = $values[$i]["attributes"]["NAME"];
//       }
//       while($values[$i]["tag"] == "XS:ATTRIBUTE"){
//
//       }
//     if($values[$i]["tag"] == "XS:ATTRIBUTE"){
//         $elements[][] = $values[$i]["attributes"]["NAME"];
//     }
// }
//
// for ($i=0; $i < $length; $i++) {
//
//     if($values[$i]["tag"] == "XS:ELEMENT"){
//         $name = $values[$i]["attributes"]["NAME"];
//         array_push($elements,$name);
//     }
//
//     while($values[$i]["tag"] != "XS:ELEMENT"){
//       if($values[$i]["tag"] == "XS:ATTRIBUTE"){
//          $attrname = $values[$i]["attributes"]["NAME"];
//          array_push($elements, $attrname);
//       }
//       break;
//     }


    // while($values[$i]["tag"] == "XS:ATTRIBUTE"){
    //   $attrname = $values[$i]["attributes"]["NAME"];
    //   array_push($elements[$name],$name);
    //
    //   if($values[$i]["tag"] == "XS:ELEMENT"){
    //         break;
    //   }
    // }

    // if($values[$i]["tag"] == "XS:ATTRIBUTE"){
    //     $elements[][] = $values[$i]["attributes"]["NAME"];
    // }
//}
//print_r($xmldata);
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

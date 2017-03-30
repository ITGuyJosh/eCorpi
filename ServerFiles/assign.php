<?php



// $target_dir = "../UserFiles/Files/";
// //$filename = $_POST["filename"];
// $filename = "Chretien 1 Erec";
// //$element = $_POST["element"];
// $element = "Emotion";
// //$attribute = $_POST["attribute"];
// $attribute = "Type";
// //$value = $_POST["value"];
// $value = "Positive";
// //$selection = $_POST["selection"];
// $selection = "chose";
// $target_file = $target_dir . $filename . ".xml";
//
// //if(isset($_POST["submit"])) {
//   $xml = file_get_contents($target_file);
//   //print_r($xml);
//   $sxml = simplexml_load_string($xml);
//
//   //get current xml elements
//   $docElements = [];
//   array_push($docElements, $sxml->getName());
//   foreach ($sxml->children() as $child){
//       array_push($docElements, $child->getName());
//   }
// //print_r ($docElements);
//
//   if (in_array($element, $docElements, true)) {
//     echo "It's there! </br>";
//
//     $wholetag = "<" . $element . " " . $attribute . "='" . $value . "'>" . $selection . "</" . $element . ">";
//
//     $regex = "/\b$wholetag\b/i";
//     //$xml = preg_replace($regex, "<element attr='value'>" . $selection . "</element>", trim(strip_tags($xml)));
//     $xml = preg_replace($regex, "<" . $element . " " . $attribute . "='" . $value . "'>" . $selection . "</" . $element . ">", $xml);
//     //print_r($docElements);
//     //print_r($sxml);
//     file_put_contents($target_file, $xml);
//
//
//     //print_r($sxml->children());
//
//     // echo $sxml->getName() . "<br>";
//     // foreach ($sxml->children() as $child)
//     //   {
//     //   echo $child->getName() . "<br>";
//     //   }
//
//     //print($sxml->elements());
//     // foreach($sxml->attributes() as $row){
//     //   //$id = (string) $row['COMP_ID'];
//     //   print_r($row);
//     // }
//
//     // foreach ($sxml->Emotion as $row) {
//     //   foreach ($row->attributes() as $attKey => $attValue) {
//     //     // i.e., on first iteration: $attKey = 'COMP_ID', $attValue = '165462'
//     //     echo $row->attributes() . " and " . $attValue . "</br>";
//     //   }
//     // }
//
//     //$sxml->Emotion[0]->addAttribute("Form", "Anger");
//
//     //print_r($sxml->asXML());
//     //echo $sxml->asXML();
//
//     // foreach($sxml->$element->attributes() as $a => $b)
//     //   {
//     //       echo "Attr: " . $a . "</br>";
//     //       echo "Val: " . $b;
//     //   }
//
//   } else {
//     echo "It's not there!</br>";
//
//     $regex = "/\b$selection\b/i";
//     //$xml = preg_replace($regex, "<element attr='value'>" . $selection . "</element>", trim(strip_tags($xml)));
//     $xml = preg_replace($regex, "<" . $element . " " . $attribute . "='" . $value . "'>" . $selection . "</" . $element . ">", $xml);
//     //print_r($docElements);
//     //print_r($sxml);
//     file_put_contents($target_file, $xml);
//
//
//
// }
//
//

//echo empty($sXML->$element)  ? '+' : '-';
//print_r($sxml);
//$attr = $sxml->attributes();
//$ele = $sxml->getName();
//$words = explode(" ", $xml);
//$newstr = preg_replace('~\W|((?<=\w\w)\w)~', '', $xml);
//print_r($newstr);

//$result = $sxml->xpath($element);
//print_r($result);
//$sxe = new SimpleXMLElement($element);
//$sxe->addAttribute($attribute, $selection)

// if (preg_match_all("/\b$selection\b/i", $xml, $matches)) {
//   //$position = $matches[1];
//   echo "Found the word!";
//   print_r($matches[0]);
//   //print_r($sxml);
// }

// if(preg_match_all("/\b$selection\b/i", $xml, $matches)) {
//   $arraycount = count($matches[0]);
// }
//
// $counter = 0;
// while(true) {
// $result = preg_match("/\b$selection\b/i", $xml, $matches);
// if($result) {
//     // Add tag
//     $counter += 1;
//     echo $result . "</br>";
//     if ($counter == $arraycount) {
//       echo $counter;
//       break;
//     }
// } else {
//     break;
// }

//$newxml = str_ireplace($selection, "black", "<body text=%BODY%>");

// $regex = "/\b$selection\b/i";
//
// while (preg_match($regex, $xml)) {
//     $xml = preg_replace($regex, "<element attr='value'>" . $selection . "</element>", trim(strip_tags($xml)));
// }
//
// echo $xml;

//$doc = new DOMDocument();
//$doc->load($target_file);
//print_r($doc->getElementsByTagName("LiteraryWork"));

// foreach($dom->getElementsByTagName('*') as $element ){
//     print_r($element);
// }

  //print_r($ele);

  // if (strpos($a, 'are') !== false) {
  //   echo 'true';
  // }

// } else {
//   echo "An assignment issue, please try again.";
// }

?>

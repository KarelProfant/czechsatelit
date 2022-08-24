<?php
function tv_webname_to_normal($old_name){
	$new_name = str_replace("_", " ", $old_name);
	return $new_name;
}
function tv_name_to_web($old_name){
	$new_name = str_replace(" ", "_", $old_name);
	return $new_name;
}
function tv_name_to_GET_method($old_name){
	$new_name = str_replace("+", "%2B", $old_name);
	return $new_name;
}
$sort_czech = function ($a, $b)
{
  static $czechCharsS = array('Á', 'Č', 'Ď', 'É', 'Ě' , 'Ch' , 'Í', 'Ň', 'Ó', 'Ř', 'Š', 'Ť', 'Ú', 'Ů' , 'Ý', 'Ž', 'á', 'č', 'ď', 'é', 'ě' , 'ch' , 'í', 'ň', 'ó', 'ř', 'š', 'ť', 'ú', 'ů' , 'ý', 'ž');
  static $czechCharsR = array('AZ','CZ','DZ','EZ','EZZ','HZZZ','IZ','NZ','OZ','RZ','SZ','TZ','UZ','UZZ','YZ','ZZ','az','cz','dz','ez','ezz','hzzz','iz','nz','oz','rz','sz','tz','uz','uzz','yz','zz');
  $A = str_replace($czechCharsS, $czechCharsR, $a['name']);
  $B = str_replace($czechCharsS, $czechCharsR, $b['name']);
  return strnatcasecmp($A, $B);
};
?>

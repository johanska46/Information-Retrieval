<?php
require_once 'cosinesimilarity.php';
$v1 = array('php' => 5, 'web' => 2,  'google' => 1);
$v2 = array('php' => 0, 'web' => 5);
$v3 = array('php' => 0, 'web' => 10, 'googling' => 5);
$v4 = array('php' => 5, 'web' => 2,  'google' => 1);

$cs = new cosinesimilarity();

$result1 = $cs->similarity($v1,$v2); // similarity of 1 and 2
// $result2 = $cs->similarity($v1,$v3); // similarity of 1 and 3
// $result3 = $cs->similarity($v1,$v4); // similarity of 1 and 4
echo "array :";
print_r($v1);
var_dump($result1); // #=> float(0.32659863237109)
// var_dump($result2); // #=> float(0.40824829046386)
// var_dump($result3); // #=> float(1)


?>
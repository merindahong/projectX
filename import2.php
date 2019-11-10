
<?php

$file=fopen("etax.csv","w");
$str="";
for($i=0;$i<50;$i++){
    $num=rand(10000000,99999999);
    $month=rand(1,12);
    $str=$str.$num.",".$month."\r\n";
}
fwrite($file,$str);
fclose($file);

?>
<!DOCTYPE html>
<html>
<body>

<?php
echo "My first PHP script!";
?>

<?php

$send = urlencode("?ID=เมนูหลัก &Ref=เมนูย่อย") ;
echo $send ;

$receive = urldecode($send);
echo $receive ;


?>



</body>
</html>

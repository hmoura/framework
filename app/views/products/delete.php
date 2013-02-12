<?php
$produto = $dao->Retrieve('Product', $params[0]);
$dao->Delete($produto);
header('location:'.WWWROOT.'/products');
?>
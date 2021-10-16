<?php
header("Content-disposition: attachment; filename=musuario.pdf");
header("Content-type: application/pdf");
readfile("manual/musuario.pdf");
?>
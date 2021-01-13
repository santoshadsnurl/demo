<?php

include('config/function.php');

session_destroy();

echo "<script>document.location.href='".$site_root."'</script>";
exit;

?>


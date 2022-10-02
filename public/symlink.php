<?php
$targetFolder = __DIR__.'/exam-web/storage/app/public';
$linkFolder = __DIR__.'/public/storage';
symlink($targetFolder,$linkFolder);
echo 'Symlink process successfully completed';
?>
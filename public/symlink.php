<?php
// $targetFolder = __DIR__.'/../exam-web/storage/app/public';
// $linkFolder = __DIR__.'/public/storage';
// symlink($targetFolder,$linkFolder);
// echo 'Symlink process successfully completed';

    $target = $_SERVER['DOCUMENT_ROOT']."/../exam-web/storage/app/public";
    $link = $_SERVER['DOCUMENT_ROOT']."/storage";
    if(symlink( $target, $link )){
        echo "OK.";
    } else {
        echo "Gagal.";
    }
?>
<?php
$url = 'http://195.178.222.75:8083/pics/Card/RGBI_062009/006/00000527.pdf';
$offset = -3;
$length = 3;
$result = strtolower(substr($url, $offset,$length));
switch ($result) {
    case 'pdf':
        echo "расширение pdf";
        break;
    case 'jpg':
    case 'png':
        echo "расширение не pdf";
        break;
    default:
        echo "расширение не определено";
        break;
}
?>
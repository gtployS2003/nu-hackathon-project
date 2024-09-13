<?php
function str_url($siteUrl, $url_path) {
    $str = explode("..", $url_path);
    $url = $siteUrl.$str[1];
    return $url;
}

<?php
$lang = 1;

if(isset($_GET["lang"])){
    if($_GET["lang"]== "1" || $_GET["lang"] == "2" || $_GET["lang"]== "3"){
        $lang = $_GET["lang"];
    }
    setcookie("lang", $_GET["lang"], time()+(86400*30),"/");
}
else {
    if(!isset($_COOKIE["lang"])){
        setcookie("lang", $lang, time()+(86400*30), "/");
    }
    else {
        $lang = $_COOKIE["lang"];
    }
}

function getValue($data, $key){
    global $lang;
    if(!isset($data[$key]))
        return "";

    return $data[$key][0]["value_$lang"];
}

function getUrl($data, $key){
    global $siteUrl;
    return $siteUrl.getValue($data, $key);
}

?>
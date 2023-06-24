<?php
$url = '';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);
curl_close($ch);

preg_match_all('#<link.*?rel="stylesheet".*?href="(.*?)".*?>#is', $data, $styles);
preg_match_all('#<script.*?src="(.*?)".*?></script>#is', $data, $scripts);



$base_directory = 'css/';

foreach ($styles[1] as $css_file) {

    $directory = dirname($base_directory . $css_file);
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    $urll = $url . $css_file;
    $contents = file_get_contents($urll);
    file_put_contents($base_directory . loc($css_file), $contents);
    echo $css_file;
}


$base_directory = 'js/';

foreach ($scripts[1] as $js_file) {

    $directory = dirname($base_directory . $js_file);
    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    $urll = $url . $js_file;
    $contents = file_get_contents($urll);
    file_put_contents($base_directory . loc($js_file), $contents);
    echo $js_file;
}

function loc($text) {
    return explode("?",$text)[0];
}
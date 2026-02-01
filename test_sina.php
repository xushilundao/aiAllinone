<?php
$url='https://hq.sinajs.cn/list=sh601899';
$ch=curl_init();
curl_setopt_array($ch,array(
    CURLOPT_URL=>$url,
    CURLOPT_RETURNTRANSFER=>true,
    CURLOPT_TIMEOUT=>8,
    CURLOPT_SSL_VERIFYPEER=>false,
    CURLOPT_HTTPHEADER=>array('Referer: https://finance.sina.com.cn/','User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122 Safari/537.36')
));
$resp=curl_exec($ch);
$st=curl_getinfo($ch,CURLINFO_RESPONSE_CODE);
curl_close($ch);
var_dump($st);
echo "\n";
var_dump($resp);

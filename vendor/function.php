<?php
/**
 * Created by PhpStorm.
 * User: Hanson
 * Date: 2017/9/6
 * Time: 15:08
 */

function curl_get($url,$method='get',$data=''){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
    curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt ($ch,CURLOPT_REFERER,'');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $temp = curl_exec($ch);
    return $temp;
}
function curl_get_mobile($url,$method='get',$data=''){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
    curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt ($ch,CURLOPT_REFERER,'');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $temp = curl_exec($ch);
    return $temp;
}
/**
 * 随机字符串
 */
function randStr($strLength=0,$type=0){
    $content = '';
    $strUpper = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $strLower = strtolower($strUpper);
    $strNum="0123456789";
    switch($type){
        case 1:{
            $strPol=$strUpper;//只有大写字母
        }break;
        case 2:{
            $strPol=$strLower;//只有小写字母
        }break;
        case 3:{
            $strPol=$strNum;//只有数字
        }break;
        case 4:{
            $strPol=$strUpper.$strLower;//大小写字母
        }break;
        case 5:{
            $strPol=$strUpper.$strNum;//大写字母+数字
        }break;
        case 6:{
            $strPol=$strLower.$strNum;//小写字母+数字
        }break;
        default:{
            $strPol=$strUpper.$strLower.$strNum;//0或其他，全包括
        }break;
    }
    $max = strlen($strPol)-1;
    for($i=0;$i<$strLength;$i++){
        $content.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
    }
    return $content;
}


function pEncrypt($password,$salt){
       return  md5(md5($password).$salt);
}
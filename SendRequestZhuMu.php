<?php
/**
 * Created by PhpStorm.
 * User: 张秀雨
 * Date: 2019/7/31
 * Time: 9:23
 */
class SendRequestZhuMu{


    /**
     * appId
     * @var string
     */
    protected $api_key = '';


    /**
     * secretKey
     * @var string
     */
    protected $api_secret = '';



    const  SERVERAPIURL = 'https://api.zhumu.me';


    public $email = '@wanchangwang.com';



    public function __construct($api_key, $api_secret)
    {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
    }


    /**
     * 向外发送请求
     * @param $url string 请求地址
     * @param $data array 请求携带内容
     * @return bool|string
     */
    private function tCurl($url, $data)
    {
        $opts = [
            "ssl"=>[
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ],
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => json_encode($data)
            ],
        ];

        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        return $result;
    }


    public function requestUrl($params = [], $url = '')
    {

        $params['api_key'] = "{$this->api_key}";
        $params['api_secret'] = "{$this->api_secret}";

        $requestUrl =self::SERVERAPIURL . $url;
        $data = $this->curl($requestUrl, $params);
        return $data;

    }


    /**
     * 发起 server 请求
     * @param $action
     * @param $params
     * @param $httpHeader
     * @return mixed
     */
    public function curl($action, $params,$contentType='urlencoded',$httpMethod='POST') {

        $httpHeader =[];

        $ch = curl_init();
        if ($httpMethod=='POST' && $contentType=='urlencoded') {
            $httpHeader[] = 'Content-Type:application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->build_query($params));
        }
        if ($httpMethod=='POST' && $contentType=='json') {
            $httpHeader[] = 'Content-Type:Application/json';
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params) );
        }
        if ($httpMethod=='GET' && $contentType=='urlencoded') {
            $action .= strpos($action, '?') === false?'?':'&';
            $action .= $this->build_query($params);
        }
        curl_setopt($ch, CURLOPT_URL, $action);
        curl_setopt($ch, CURLOPT_POST, $httpMethod=='POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false); //处理http证书问题
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        @curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ret = curl_exec($ch);
        if (false === $ret) {
            $ret =  curl_errno($ch);
        }
        curl_close($ch);
        return $ret;
    }



    /**
     * 重写实现 http_build_query 提交实现(同名key)key=val1&key=val2
     * @param array $formData 数据数组
     * @param string $numericPrefix 数字索引时附加的Key前缀
     * @param string $argSeparator 参数分隔符(默认为&)
     * @param string $prefixKey Key 数组参数，实现同名方式调用接口
     * @return string
     */
    private function build_query($formData, $numericPrefix = '', $argSeparator = '&', $prefixKey = '') {
        $str = '';
        foreach ($formData as $key => $val) {
            if (!is_array($val)) {
                $str .= $argSeparator;
                if ($prefixKey === '') {
                    if (is_int($key)) {
                        $str .= $numericPrefix;
                    }
                    $str .= urlencode($key) . '=' . urlencode($val);
                } else {
                    $str .= urlencode($prefixKey) . '=' . urlencode($val);
                }
            } else {
                if ($prefixKey == '') {
                    $prefixKey .= $key;
                }
                if (isset($val[0]) && is_array($val[0])) {
                    $arr = array();
                    $arr[$key] = $val[0];
                    $str .= $argSeparator . http_build_query($arr);
                } else {
                    $str .= $argSeparator . $this->build_query($val, $numericPrefix, $argSeparator, $prefixKey);
                }
                $prefixKey = '';
            }
        }
        return substr($str, strlen($argSeparator));
    }

}
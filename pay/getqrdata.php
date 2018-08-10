<?php
header("Content-type: text/html; charset=UTF-8");

$data = 5;
$payty =$_GET['paytype'];
$gettype =$_GET['gettype'];

$pay_memberid = "004110154110001";   //商户ID
$pay_orderid = date("YmdHis").rand(100000,999999);    //订单号
$pay_amount = $data;    //交易金额
$pay_applydate = date("Y-m-d H:i:s");  //订单时间
$pay_bankcode = $payty==1?"903":"902";   //银行编码
$pay_notifyurl = "http://pay.sc-pay.com/notify.php";   //服务端返回地址
$pay_callbackurl = "http://test.pay.com/page.php";  //页面跳转返回地址
$Md5key = "E517AE612431461FCB3348A066D8DA04";   //密钥
$tjurl = "http://120.79.67.66:8084/online/wechatPay";   //网关提交地址

$jsapi = array(
    "merchno" => $pay_memberid,
    "goodsName" => "测试",
    "amount" =>$pay_amount,
    "settleType" => "02002",
    "payType"=>1,
    "notifyUrl"=>$pay_notifyurl,
    "key"=>$Md5key
);

ksort($jsapi);
$md5str = "";
foreach ($jsapi as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
unset($jsapi["key"]);//移除key
$md5str=rtrim($md5str,"&");//去掉尾部的&
$sign = strtoupper(md5($md5str));
$jsapi["sign"]=$sign;


function file_get_contents_post($url, $post){
    $options = array(
        'http'=> array(
            'method'=>'POST',
            'content'=> http_build_query($post),
        ),
    );
    $result = file_get_contents($url,false, stream_context_create($options));
    return $result;

}
$result = file_get_contents_post($tjurl,$jsapi);
$resultobj=json_decode($result);

if($resultobj->resp_code!="00"){
    echo  "获取支付页面失败";
}
$resultdata=array(
    "resp_code"=>$resultobj->resp_code,
    "sign"=>$resultobj->sign,
    "message"=>$resultobj->message,
    "order_id"=>$resultobj->order_id,
    "pay_url"=>$resultobj->pay_url,
    "key"=>$Md5key
);
$remoteSign=$resultdata["sign"];//远端签名
unset($resultdata["sign"]);//移除sign
ksort($resultdata);

$localviery = "";
foreach ($resultdata as $key => $val) {
    $localviery = $localviery . $key . "=" . $val . "&";
}
$localviery=rtrim($localviery,"&");//去掉尾部的&
$local_payurl_sign = strtoupper(md5($localviery));
if($remoteSign==$local_payurl_sign){
    echo header("Location: ".$resultobj->pay_url);
}
else {
    echo "RemoteSign:" . $remoteSign . "</br>";
    echo "LocalSign:" . $local_payurl_sign . "</br>";
    echo date("Y-m-d H:i:s");
}
exit;

?>
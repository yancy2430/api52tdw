<?php
header("Content-type: text/html; charset=UTF-8");
$pay_result=$_REQUEST["pay_result"];
$pay_desc=$_REQUEST["pay_desc"];
$t0RespCode=$_REQUEST["t0RespCode"];
$t0RespDesc=$_REQUEST["t0RespDesc"];
$order_id=$_REQUEST["order_id"];
$amount=$_REQUEST["amount"];
$orign_sign=$_REQUEST["sign"];
$Md5key = "709B93CA55DB4DB8067735FB6549AFD9";   //密钥
//var_dump($_REQUEST);

//ob_start();
//var_dump($_REQUEST);

$param_arry=array(
    "pay_result"=>$pay_result,
    "pay_desc"=>$pay_desc,
    /*"t0RespCode"=>$t0RespCode,
    "t0RespDesc"=>$t0RespDesc,*/
    "order_id"=>$order_id,
    "amount"=>$amount,
    "key"=>$Md5key
);
ksort($param_arry);
$md5str="";
foreach ($param_arry as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
unset($jsapi["key"]);//移除key
$md5str=rtrim($md5str,"&");
$sign = strtoupper(md5($md5str));
if($sign==$orign_sign){
    echo "success";
}else{
    echo "pay_result:".$pay_result."</br>\r\n";
    echo "pay_desc:".$pay_desc."</br>\r\n";
    echo "t0RespCode:".$t0RespCode."</br>\r\n";
    echo "t0RespDesc:".$t0RespDesc."</br>\r\n";
    echo "order_id:".$order_id."</br>\r\n";
    echo "amount:".$amount."</br>\r\n";
    echo "============================="."</br>\r\n";
    echo "Order_No:".$order_id."</br>\r\n";
    echo "Orign_Sign:".$orign_sign."</br>\r\n";
    echo "Local_Sign:".$sign."</br>\r\n";
}
//$result = ob_get_clean();
//file_put_contents("./notify.log",$result);
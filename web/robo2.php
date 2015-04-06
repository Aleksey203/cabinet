<?php
// your registration data
$mrh_login = "test";      // your login here
$mrh_pass1 = "securepass1";   // merchant pass1 here

// order properties
$inv_id    = 5;        // shop's invoice number
// (unique for shop's lifetime)
$inv_desc  = "desc";   // invoice desc
$out_summ  = "5.12";   // invoice summ

// build CRC value
$crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");

// build URL
$url = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$mrh_login&".
    "OutSum=$out_summ&InvId=$inv_id&Desc=$inv_desc&SignatureValue=$crc";

// print URL if you need
echo "<a href='/ru/$url'>Payment link</a>";

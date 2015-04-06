<?php
$mrh_login = "Aleksey203";
$mrh_pass1 = "calc.fire";
$inv_id = 0;
$inv_desc = "Техническая документация по ROBOKASSA";
$out_summ = "8.96";
$crc = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");
print
    "<html>".
    "<form action='http://test.robokassa.ru/Index.aspx' method=POST>".
    "<input type=hidden name=MrchLogin value=$mrh_login>".
    "<input type=hidden name=OutSum value=$out_summ>".
    "<input type=hidden name=InvId value=$inv_id>".
    "<input type=hidden name=Desc value='$inv_desc'>".
    "<input type=hidden name=SignatureValue value=$crc>".
    "<input type=submit value='Оплатить'>".
    "</form></html>";

<?php
function langg($phrase){
    static $lang=array(
        'message'=>'مرحبا',
        'admin'=>'الادمن'
    );
    return  $lang[$phrase];
}


?>
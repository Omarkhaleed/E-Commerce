<?php
function lang($phrase){
    static $lang=array(
        //navbar links
        'name'         =>'E-commerce',
        'home'         =>'Home',
        'cat'          =>'Categories',
        'items'        =>'Items',
        'members'      =>'Members',
        'comments'   =>'Comments',
        'statistics'   =>'Statistics',
        'logs'         =>'Logs'

    );
    return  $lang[$phrase];
}


?>
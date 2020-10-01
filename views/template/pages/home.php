<?php

    if(count($info->company->companies) == 1){
        include_once TEMPLATE_DIR . 'pages/single.php';
    }elseif(count($info->company->companies) > 1){
        include_once TEMPLATE_DIR . 'pages/multi.php';
    }elseif(count($info->company->companies) ==0 ){
        echo 'You don\'t have access to any accounts. Please contact your Account Manager or portal support.';
    }else{
        echo 'An error has occured. Please contact portal support.';

    }

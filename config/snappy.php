<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => storage_path('wkhtmltox/bin/wkhtmltopdf'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => storage_path('wkhtmltox/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);

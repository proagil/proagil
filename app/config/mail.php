<?php

return array(
 
    'driver' => 'smtp',
 
    'host' => 'smtp.gmail.com',
 
    'port' => 587,
 
    'from' => array('address' => 'proagilwebapp@gmail.com', 'name' => 'PROAGIL'),
 
    'encryption' => 'tls',
 
    'username' => 'proagilwebapp@gmail.com',
 
    'password' => '3l30n0r4',
 
    'sendmail' => '/usr/sbin/sendmail -bs',
 
    'pretend' => false,
 
);

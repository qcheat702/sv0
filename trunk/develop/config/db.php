<?php
 
if (in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1','sv0.local.com']))
{    
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=sv0',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'tablePrefix' => 'sv_',
    ];
}
else
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=qdm177261641.my3w.com;dbname=qdm177261641_db',
        'username' => 'qdm177261641',
        'password' => 'fK8cf4WMufqRw6',
        'charset' => 'utf8',
        'tablePrefix' => 'sv_',
    ]; 
// fK8cf4WMufqRw6
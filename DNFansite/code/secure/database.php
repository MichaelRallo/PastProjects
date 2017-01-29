<?php


define('HOST', 'host=' . getenv('OPENSHIFT_POSTGRESQL_DB_HOST'));
define('PORT', 'port=' . getenv('OPENSHIFT_POSTGRESQL_DB_PORT'));
define('USERNAME', 'user=' . getenv('OPENSHIFT_POSTGRESQL_DB_USERNAME'));
define('PASSWORD', 'password=' . getenv('OPENSHIFT_POSTGRESQL_DB_PASSWORD'));
define('DBNAME', 'dbname=' . getenv('OPENSHIFT_GEAR_NAME'));

        /*DEFINE("HOST","host=127.0.0.1");
        DEFINE("DBNAME","dbname=dragonnest");
        DEFINE("USERNAME","user=adminxaycqqp");
        DEFINE("PASSWORD","password=3s3vsp2TR2Vr");*/
?>

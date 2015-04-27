<?php
function unlock()
{
    $_ENV['dbhost'] = 'localhost';
    $_ENV['dbuser'] = 'titaniaa_test';
    $_ENV['dbpass'] = 'test';
    $_ENV['dbname'] = 'titaniaa_tutor';
}
function lock()
{
    unset($_ENV['dbhost']);
    unset($_ENV['dbuser']);
    unset($_ENV['dbpass']);
    unset($_ENV['dbname']);
}
?>
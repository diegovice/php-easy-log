<?php
/**
 * Test for easy logger
 * 
 * @author Diego Vicentini
 * @version 1.0
 */

include '../src/log.php';

// Test compelte logger
$filepath = './test.log';
$lev = EasyLogger::FINE;

$logger = EasyLogger::getInstance($filepath, $lev, 300);

$logger->fine('fine message');
$logger->info('info message');
$logger->warning('warning message');
$logger->severe('severe warning');

$logger->close();

?>
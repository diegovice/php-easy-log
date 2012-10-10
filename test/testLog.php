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

$logger = new EasyLogger($filepath, $lev, 300);

$logger->fine('fine message');
$logger->info('info message');
$logger->warning('warning message');
$logger->severe('severe warning');

$logger->close();

// Test log with only log file (no rotation)
$filepath = './test_onlylog.log';
$lev = EasyLogger::FINE;

$logger = new EasyLogger($filepath, $lev);

$logger->fine('fine message');
$logger->info('info message');
$logger->warning('warning message');
$logger->severe('severe warning');

$logger->close();

?>
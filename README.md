Usage
========
$logger = new EasyLogger($filepath, $lev, 300);

$logger->fine('fine message');
$logger->info('info message');
$logger->warning('warning message');
$logger->severe('severe warning');

$logger->close();

##Usage example

    $logger = new EasyLogger('/path/to/file.log', EasyLogger::FINE, 300);
    $logger->fine('fine message');
    $logger->info('info message');
    $logger->warning('warning message');
    $logger->severe('severe warning');
    $logger->close();

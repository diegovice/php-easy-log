<?php
/**
 * Easy logger for PHP
 * 
 * @author Diego Vicentini
 * @version 1.1
 */

class EasyLogger {
	
	const FINE = 0;
	const INFO = 1;
	const WARNING = 2;
	const SEVERE = 3;
	
	/**
	 * Log file name
	 * 
	 * @var unknown_type
	 */
	private $filename = '';
	
	/**
	 * Log level selected
	 * 0 - fine
	 * 1 - info
	 * 2 - warning
	 * 3 - severe
	 */
	private $level = 0;
	
	/**
	 * File resource
	 * 
	 * @var unknown_type
	 */
	private $f = null;
	
	/**
	 * File size for log rotation.
	 * 
	 * @var unknown_type
	 */
	private $filesize = 0;

	/**
	 * Create a new logger
	 * 
	 * @param $filepath file path
	 * @param $lev log level
	 * @param $rotateSize size limiti for rotation (in bytes) 0 for no rotation
	 */
	public function __construct($filepath, $lev, $rotateSize = 0) {
		$this->filename = $filepath;
		$this->level = $lev;
		
		// Log rotation
		if ($rotateSize > 0) {
			// Check filesize
			$this->filesize = filesize($this->filename);
			if ($this->filesize >= $rotateSize) {
				// Rotate log
				$strdate = date('Ymd');
				$rotationFileName = $this->filename.'.'.$strdate;
				// Check existing rotation
				rename($this->filename, $this->checkRotationFilename($rotationFileName));
			}	
		}
		
		// Open log file
		$this->f = fopen($this->filename, 'a');
	}
		
	/**
	 * Check if a rotation filename exists.
	 * In this case append to filename a number.
	 * 
	 * @param unknown_type $filename
	 * @param unknown_type $count
	 */
	private function checkRotationFilename(&$filename, $count = 0) {
		if ( file_exists($filename) ) {
			$count++;
			$filename .= '.'.$count;
			return $this->checkRotationFilename($filename, $count);
		} else {
			return $filename;
		}
	}
	
	/**
	 * Close log file
	 * 
	 */
	public function close() {
		// Chiude log file
		fclose($this->f);
	}
	
	/**
	 * Returns the formatted message to write into the log.
	 * 
	 * @param unknown_type $msg
	 */
	private function getLogLine($msg) {
		return "[".date("d/m/Y H:i:s")."] ".$msg."\n";
	}
	
	/**
	 * Write a line into log file with formatted timestamp
	 * 
	 * @param $msg message to write
	 */
	private function writeLog($msg) {
		$line = $this->getLogLine($msg);
		fwrite($this->f, $line);
		fflush($this->f);
	}
	
	/**
	 * Write a vector into log file useing FINE level by default
	 * 
	 * @param $vector vector to write
	 */
	private function writeVectorLog($vector) {
		$this->fine("----------------------------------------");
		foreach ($vector as $key => $value) {
			if ( is_array($value) ) {
				$msg = $key.':';
				$this->fine($msg);
				$this->writeVectorLog($value);
			} else {
				$msg = $key.' => '.$value;
				$this->fine($msg);
			}
		}
		$this->fine("----------------------------------------");
	}
	
	/**
	 * Write a FINE line into log file
	 * 
	 * @param unknown_type $msg message to write
	 */
	public function fine($msg) {
		if ( $this->level <= self::FINE && !empty($msg) ) {
			$this->writeLog("FINE: ".$msg);
		}
	}
	
	/**
	 * Write a FINE vector into log file
	 * 
	 * @param unknown_type $vec vector to write
	 */
	public function fineVector($vec) {
		if ( $this->level <= self::FINE && !empty($vec) ) {
			$this->writeVectorLog($vec);
		}
	}

	/**
	 * Write an INFO line into log file
	 * 
	 * @param unknown_type $msg message to write
	 */
	public function info($msg) {
		if ( $this->level <= self::INFO && !empty($msg) ) {
			$this->writeLog("INFO: ".$msg);
		}
	}
	
	/**
	 * Write a WARNING line into log file
	 * 
	 * @param unknown_type $msg message to write
	 */
	public function warning($msg) {
		if ( $this->level <= self::WARNING && !empty($msg) ) {
			$this->writeLog("WARN: ".$msg);
		}
	}

	/**
	 * Write a SEVERE line into log file
	 * 
	 * @param unknown_type $msg message to write
	 */
	public function severe($msg) {
		if ( $this->level <= self::SEVERE && !empty($msg) ) {
			$this->writeLog("SEVERE: ".$msg);
		}
	}
}
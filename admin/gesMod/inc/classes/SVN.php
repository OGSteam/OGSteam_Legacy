<?php
class SVN {
	public static function ls ( $url ) {
		exec('svn ls ' . escapeshellarg($url), $output);
		return $output;
	}

	public static function export ( $from, $to ) {
		exec('svn --force export ' . escapeshellarg($from) . ' ' . escapeshellarg($to), $array, $return);
		return $return === 0;
	}

	public static function cat ( $url ) {
		exec('svn cat ' . escapeshellarg($url), $content, $return);
		return implode(PHP_EOL, $content);
	}
}
?>
<?php
class Folder {
	public static function rm( $dir ) {
		$dir_content = scandir($dir);
		if ( $dir_content !== FALSE ) {
			foreach ( $dir_content as $entry ) {
				if ( !in_array($entry, array('.', '..')) ) {
					$entry = $dir . '/' . $entry;
					if ( !is_dir($entry) ) {
						unlink($entry);
					} else {
						self::rm($entry);
					}
				}
			}
		}

		rmdir($dir);
	}

	public static function zip ( $from, $to ) {
		if ( !is_dir($from) ) {
			return -1;
		}

		exec('cd ' . escapeshellarg($from) . ' && zip -r9 ' . escapeshellarg($to) . ' .', $array, $return);
		return $return === 0;
	}

	public static function xpi ( $from, $to ) {
		$info = pathinfo($to);
		if ( !file_exists($from . '/install.rdf' ) || $info['extension'] !== 'xpi' ) {
			return false;
		}

		return self::zip($from, $to);
	}
}
?>
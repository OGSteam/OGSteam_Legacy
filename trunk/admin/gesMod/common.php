<?php
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

function __autoload ( $class ) {
	require_once dirname(__FILE__) . '/inc/classes/' . $class . '.php';
}

define('BASE_SVN', 'file:///home/ogsteam/svn/');
define('BASE_TAGS', BASE_SVN . 'tags/');
define('BASE_DOWNLOAD', dirname(__FILE__) . '/cache/download/');
define('BASE_TMP', dirname(__FILE__) . '/cache/tmp/');
?>
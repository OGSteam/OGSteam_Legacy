<?php
/***********************************************************************

  Copyright (C) 2008  FluxBB.org

  Based on code copyright (C) 2002-2008  PunBB.org

  This file is part of FluxBB.

  FluxBB is free software; you can redistribute it and/or modify it
  under the terms of the GNU General Public License as published
  by the Free Software Foundation; either version 2 of the License,
  or (at your option) any later version.

  FluxBB is distributed in the hope that it will be useful, but
  WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston,
  MA  02111-1307  USA

************************************************************************/


// Make sure no one attempts to run this script "directly"
if (!defined('FORUM'))
	exit;


//
// Validate an e-mail address
//
function is_valid_email($email)
{
	if (strlen($email) > 80)
		return false;

	return preg_match('/^(([^<>()[\]\\.,;:\s@"\']+(\.[^<>()[\]\\.,;:\s@"\']+)*)|("[^"\']+"))@((\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\])|(([a-zA-Z\d\-]+\.)+[a-zA-Z]{2,}))$/', $email);
}


//
// Check if $email is banned
//
function is_banned_email($email)
{
	global $forum_db, $forum_bans;

	foreach ($forum_bans as $cur_ban)
	{
		if ($cur_ban['email'] != '' &&
			($email == $cur_ban['email'] ||
			(strpos($cur_ban['email'], '@') === false && stristr($email, '@'.$cur_ban['email']))))
			return true;
	}

	return false;
}


//
// Wrapper for PHP's mail()
//
function forum_mail($to, $subject, $message, $reply_to = '')
{
	global $forum_config, $lang_common;

	($hook = get_hook('em_forum_mail_start')) ? eval($hook) : null;

	// Default sender address
	$from = '"'.sprintf($lang_common['Forum mailer'], str_replace('"', '', $forum_config['o_board_title'])).'" <'.$forum_config['o_webmaster_email'].'>';

	// Do a little spring cleaning
	$to = trim(preg_replace('#[\n\r]+#s', '', $to));
	$subject = trim(preg_replace('#[\n\r]+#s', '', $subject));
	$from = trim(preg_replace('#[\n\r:]+#s', '', $from));

	$headers = 'From: '.$from."\r\n".'Date: '.gmdate('r')."\r\n".'MIME-Version: 1.0'."\r\n".'Content-transfer-encoding: 8bit'."\r\n".'Content-type: text/plain; charset=utf-8'."\r\n".'X-Mailer: FluxBB Mailer';

	if (!empty($reply_to))
		$headers .= "\r\n".'Reply-To: '.trim(preg_replace('#[\n\r:]+#s', '', $reply_to));

	// Make sure all linebreaks are CRLF in message (and strip out any NULL bytes)
	$message = str_replace(array("\n", "\0"), array("\r\n", ''), forum_linebreaks($message));

	($hook = get_hook('em_forum_mail_pre_send')) ? eval($hook) : null;

	if ($forum_config['o_smtp_host'] != '')
		smtp_mail($to, $subject, $message, $headers);
	else
	{
		// Change the linebreaks used in the headers according to OS
		if (strtoupper(substr(PHP_OS, 0, 3)) == 'MAC')
			$headers = str_replace("\r\n", "\r", $headers);
		else if (strtoupper(substr(PHP_OS, 0, 3)) != 'WIN')
			$headers = str_replace("\r\n", "\n", $headers);

		mail($to, $subject, $message, $headers);
	}
}


//
// This function was originally a part of the phpBB Group forum software phpBB2 (http://www.phpbb.com).
// They deserve all the credit for writing it. I made small modifications for it to suit FluxBB and it's coding standards.
//
function server_parse($socket, $expected_response)
{
	$server_response = '';
	while (substr($server_response, 3, 1) != ' ')
	{
		if (!($server_response = fgets($socket, 256)))
			error('Couldn\'t get mail server response codes. Please contact the forum administrator.', __FILE__, __LINE__);
	}

	if (!(substr($server_response, 0, 3) == $expected_response))
		error('Unable to send e-mail. Please contact the forum administrator with the following error message reported by the SMTP server: "'.$server_response.'"', __FILE__, __LINE__);
}


//
// This function was originally a part of the phpBB Group forum software phpBB2 (http://www.phpbb.com).
// They deserve all the credit for writing it. I made small modifications for it to suit FluxBB and it's coding standards.
//
function smtp_mail($to, $subject, $message, $headers = '')
{
	global $forum_config;

	$recipients = explode(',', $to);

	// Are we using port 25 or a custom port?
	if (strpos($forum_config['o_smtp_host'], ':') !== false)
		list($smtp_host, $smtp_port) = explode(':', $forum_config['o_smtp_host']);
	else
	{
		$smtp_host = $forum_config['o_smtp_host'];
		$smtp_port = 25;
	}

	if ($forum_config['o_smtp_ssl'] == '1')
		$smtp_host = 'ssl://'.$smtp_host;

	if (!($socket = fsockopen($smtp_host, $smtp_port, $errno, $errstr, 15)))
		error('Could not connect to smtp host "'.$forum_config['o_smtp_host'].'" ('.$errno.') ('.$errstr.').', __FILE__, __LINE__);

	server_parse($socket, '220');

	if ($forum_config['o_smtp_user'] != '' && $forum_config['o_smtp_pass'] != '')
	{
		fwrite($socket, 'EHLO '.$smtp_host."\r\n");
		server_parse($socket, '250');

		fwrite($socket, 'AUTH LOGIN'."\r\n");
		server_parse($socket, '334');

		fwrite($socket, base64_encode($forum_config['o_smtp_user'])."\r\n");
		server_parse($socket, '334');

		fwrite($socket, base64_encode($forum_config['o_smtp_pass'])."\r\n");
		server_parse($socket, '235');
	}
	else
	{
		fwrite($socket, 'HELO '.$smtp_host."\r\n");
		server_parse($socket, '250');
	}

	fwrite($socket, 'MAIL FROM: <'.$forum_config['o_webmaster_email'].'>'."\r\n");
	server_parse($socket, '250');

	@reset($recipients);
	while (list(, $email) = @each($recipients))
	{
		fwrite($socket, 'RCPT TO: <'.$email.'>'."\r\n");
		server_parse($socket, '250');
	}

	fwrite($socket, 'DATA'."\r\n");
	server_parse($socket, '354');

	fwrite($socket, 'Subject: '.$subject."\r\n".'To: <'.implode('>, <', $recipients).'>'."\r\n".$headers."\r\n\r\n".$message."\r\n");

	fwrite($socket, '.'."\r\n");
	server_parse($socket, '250');

	fwrite($socket, 'QUIT'."\r\n");
	fclose($socket);

	return true;
}

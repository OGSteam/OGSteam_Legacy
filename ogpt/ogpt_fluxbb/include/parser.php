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


// Here you can add additional smilies if you like (please note that you must escape singlequote and backslash)
$smilies = array(':)' => 'smile.png', '=)' => 'smile.png', ':|' => 'neutral.png', '=|' => 'neutral.png', ':(' => 'sad.png', '=(' => 'sad.png', ':D' => 'big_smile.png', '=D' => 'big_smile.png', ':o' => 'yikes.png', ':O' => 'yikes.png', ';)' => 'wink.png', ':/' => 'hmm.png', ':P' => 'tongue.png', ':lol:' => 'lol.png', ':mad:' => 'mad.png', ':rolleyes:' => 'roll.png', ':cool:' => 'cool.png');

($hook = get_hook('ps_start')) ? eval($hook) : null;


//
// Make sure all BBCodes are lower case and do a little cleanup
//
function preparse_bbcode($text, &$errors, $is_signature = false)
{
	global $forum_config;

	$return = ($hook = get_hook('ps_preparse_bbcode_start')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	if ($is_signature)
	{
		global $lang_profile;

		if (preg_match('#\[quote=(&quot;|"|\'|)(.*)\\1\]|\[quote\]|\[/quote\]|\[code\]|\[/code\]#i', $text))
			$errors[] = $lang_profile['Signature quote/code'];
	}

	// If the message contains a code tag we have to split it up (text within [code][/code] shouldn't be touched)
	if (strpos($text, '[code]') !== false && strpos($text, '[/code]') !== false)
	{
		list($inside, $outside) = split_text($text, '[code]', '[/code]', $errors);
		$text = implode('[%]', $outside);
	}

	// Tidy up lists
	$pattern = array('#\[list\](.*?)\[/list\]#ems',
					 '#\[list=([1a\*])\](.*?)\[/list\]#ems');

	$replace = array('preparse_list_tag(\'$1\', \'*\', $errors)',
					 'preparse_list_tag(\'$2\', \'$1\', $errors)');

	$text = preg_replace($pattern, $replace, $text);

	if ($forum_config['o_make_links'] == '1')
		$text = do_clickable($text);

	// If we split up the message before we have to concatenate it together again (code tags)
	if (isset($inside))
	{
		$outside = explode('[%]', $text);
		$text = '';

		$num_tokens = count($outside);

		for ($i = 0; $i < $num_tokens; ++$i)
		{
			$text .= $outside[$i];
			if (isset($inside[$i]))
				$text .= '[code]'.$inside[$i].'[/code]';
		}
	}

	$temp_text = false;
	if (empty($errors))
		$temp_text = preparse_tags($text, $errors, $is_signature);

	if ($temp_text !== false)
		$text = $temp_text;

	$return = ($hook = get_hook('ps_preparse_bbcode_end')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	return trim($text);
}

function preparse_tags($text, &$errors, $is_signature = false)
{
	global $lang_common, $forum_config;

	// Start off by making some arrays of bbcode tags and what we need to do with each one

	// List of all the tags
	$tags = array('quote', 'code', 'b', 'i', 'u', 'color', 'colour', 'url', 'email', 'img', 'list', '*');
	// List of tags that we need to check are open (You could not put b,i,u in here then illegal nesting like [b][i][/b][/i] would be allowed)
	$tags_opened = $tags;
	// and tags we need to check are closed (the same as above, added it just in case)
	$tags_closed = $tags;
	// Tags we can nest and the depth they can be nested to (only quotes )
	$tags_nested = array('quote' => $forum_config['o_quote_depth']);
	// Tags to ignore the contents of completely (just code)
	$tags_ignore = array('code');
	// Block tags, block tags can only go within another block tag, they cannot be in a normal tag
	$tags_block = array('quote', 'code', 'list');
	// Tags we trim interior lines
	$tags_trim = array('url', 'email', 'img', '*');
	// Tags we remove quotes from the argument
	$tags_quotes = array('url', 'email', 'img');
	// Tags we limit bbcode in
	$tags_limit_bbcode = array('url' => array('b', 'i', 'u', 'color', 'colour', 'img'), 'email' => array('b', 'i', 'u', 'color', 'colour', 'img'), 'img' => array());
	// Tags we can automatically fix
	$tags_fix = array('quote', 'b', 'i', 'u');

	$return = ($hook = get_hook('ps_preparse_tags_start')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	$split_text = preg_split("/(\[[a-zA-Z0-9-\/]*?(?:=.*?)?\])/", $text, -1, PREG_SPLIT_DELIM_CAPTURE);

	$open_tags = array('post');
	$opened_tag = 0;
	$new_text = '';
	$current_ignore = '';
	$current_nest = '';
	$current_depth = array();
	$content = 0;
	$limit_bbcode = $tags;

	foreach ($split_text as $current)
	{
		if ($current == '')
			continue;

		if (substr($current, 0, 1) != '[' || substr($current, -1, 1) != ']')
		{
			// Its not a bbcode tag so we put it on the end and continue
			if (!$current_nest)
			{
				if (trim($current) != '')
					$content = 1;

				if (in_array($open_tags[$opened_tag], $tags_trim))
					$new_text .= trim($current, "\r\n");
				else
					$new_text .= $current;
			}

			continue;
		}

		if (strpos($current, '/') === 1)
		{
			$current_tag = substr($current, 2, -1);
		}
		else if (strpos($current, '=') === false)
		{
			$current_tag = substr($current, 1, -1);
		}
		else
		{
			$current_tag = substr($current, 1, strpos($current, '=')-1);
			$current_arg = substr($current, strpos($current, '=')+1, -1);
		}

		$current_tag = strtolower($current_tag);

		if (!in_array($current_tag, $tags))
		{
			$content = 1;

			// Its not a bbcode tag so we put it on the end and continue
			if (!$current_nest)
				$new_text .= $current;

			continue;
		}

		// We definitely have a bbcode tag.

		//This is if we are currently in a tag which escapes other bbcode such as code
		if ($current_ignore)
		{
			$content = 1;

			if ('[/'.$current_ignore.']' == $current)
			{
				$current = '[/'.$current_tag.']';
				$current_ignore = '';
			}

			$new_text .= $current;

			continue;
		}

		if ($equalpos = strpos($current,'='))
		{
			if (strlen(substr($current, $equalpos)) == 2)
			{
				$errors[] = sprintf($lang_common['BBCode error 6'], $current_tag);
				return false;
			}
			$current = strtolower(substr($current, 0, $equalpos)).substr($current, $equalpos);
		}
		else
			$current = strtolower($current);

		if (!in_array($current_tag, $limit_bbcode) && $current_tag != $open_tags[$opened_tag])
		{
			$errors[] = sprintf($lang_common['BBCode error 3'], $current_tag, $open_tags[$opened_tag]);
			return false;
		}

		if ($current_nest)
		{
			// We are currently too deeply nested so lets see if we are closing the tag or not.
			if ($current_tag != $current_nest)
				continue;

			if (substr($current, 1, 1) == '/')
				$current_depth[$current_nest]--;
			else
				$current_depth[$current_nest]++;

			if ($current_depth[$current_nest] <= $tags_nested[$current_nest])
				$current_nest = '';

			continue;
		}

		if (substr($current, 1, 1) == '/')
		{
			//This is if we are closing a tag

			if ($opened_tag == 0 || !in_array($current_tag, $open_tags))
			{
				//We tried to close a tag which is not open
				if (in_array($current_tag, $tags_opened))
				{
					$errors[] = sprintf($lang_common['BBCode error 1'], $current_tag);
					return false;
				}
			}
			elseif ($content == 0)
			{
				$errors[] = sprintf($lang_common['BBCode error 2'], $current_tag);
				return false;
			}
			else
			{
				while (true)
				{
					if ($open_tags[$opened_tag] == $current_tag)
					{
						array_pop($open_tags);
						$opened_tag--;
						break;
					}

					if (in_array($open_tags[$opened_tag], $tags_closed) && in_array($current_tag, $tags_closed))
					{
						if (in_array($current_tag, $open_tags))
						{
							$temp_opened = array();
							$temp = '';
							while (!empty($open_tags))
							{
								$temp_tag = array_pop($open_tags);

								if (!in_array($temp_tag, $tags_fix))
								{
									$errors[] = sprintf($lang_common['BBCode error 5'], array_pop($temp_opened));
									return false;
								}
								array_push($temp_opened, $temp_tag);

								if ($temp_tag == $current_tag)
									break;
								else
									$temp .= '[/'.$temp_tag.']';
							}
							$current = $temp.$current;
							$temp = '';
							array_pop($temp_opened);
							while (!empty($temp_opened))
							{
								$temp_tag = array_pop($temp_opened);
								$temp .= '['.$temp_tag.']';
								array_push($open_tags, $temp_tag);
							}
							$current .= $temp;
							$opened_tag--;
							break;
						}
						else
						{
							$errors[] = sprintf($lang_common['BBCode error 1'], $current_tag);
							return false;
						}
					}
					else if (in_array($open_tags[$opened_tag], $tags_closed))
						break;
					else
					{
						array_pop($open_tags);
						$opened_tag--;
					}
				}
			}

			if (in_array($current_tag, array_keys($tags_nested)))
			{
				if (isset($current_depth[$current_tag]))
					$current_depth[$current_tag]--;
			}

			if (in_array($open_tags[$opened_tag], array_keys($tags_limit_bbcode)))
				$limit_bbcode = $tags_limit_bbcode[$open_tags[$opened_tag]];
			else
				$limit_bbcode = $tags;

			$new_text .= $current;

			continue;
		}
		else
		{
			// We are opening a tag

			$content = 0;

			if (in_array($current_tag, $tags_block) && !in_array($open_tags[$opened_tag], $tags_block) && $opened_tag != 0)
			{
				// We tried to open a block tag within a non-block tag
				$errors[] = sprintf($lang_common['BBCode error 3'], $current_tag, $open_tags[$opened_tag]);
				return false;
			}

			if (in_array($current_tag, $tags_ignore))
			{
				// Its an ignore tag so we don't need to worry about whats inside it,
				$current_ignore = $current_tag;
				$new_text .= $current;
				continue;
			}

			if (in_array($current_tag, $open_tags) && !in_array($current_tag, array_keys($tags_nested)))
			{
				// We tried to open a tag within itself that shouldn't be allowed.
				$errors[] = sprintf($lang_common['BBCode error 4'], $current_tag);
				return false;
			}

			if (in_array($current_tag, array_keys($tags_nested)))
			{
				if (isset($current_depth[$current_tag]))
					$current_depth[$current_tag]++;
				else
					$current_depth[$current_tag] = 1;

				if ($current_depth[$current_tag] > $tags_nested[$current_tag])
				{
					$current_nest = $current_tag;
					continue;
				}
			}

			if (strpos($current, '=') !== false && in_array($current_tag, $tags_quotes))
			{
				$current = preg_replace('#\['.$current_tag.'=("|\'|)(.*?)\\1\]\s*#i', '['.$current_tag.'=$2]', $current);
			}

			if (in_array($current_tag, array_keys($tags_limit_bbcode)))
				$limit_bbcode = $tags_limit_bbcode[$current_tag];

			$open_tags[] = $current_tag;
			$opened_tag++;
			$new_text .= $current;
			continue;
		}
	}

	// Check we closed all the tags we needed to
	foreach ($tags_closed as $check)
	{
		if (in_array($check, $open_tags))
		{
			// We left an important tag open
			$errors[] = sprintf($lang_common['BBCode error 5'], $check);
			return false;
		}
	}

	if ($current_ignore)
	{
		// We left an ignore tag open
		$errors[] = sprintf($lang_common['BBCode error 5'], $current_ignore);
		return false;
	}

	$return = ($hook = get_hook('ps_preparse_tags_end')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	return $new_text;
}


//
// Preparse the contents of [list] bbcode
//
function preparse_list_tag($content, $type = '*', &$errors)
{
	global $lang_common;

	if (strpos($content,'[list') !== false)
	{
		$errors['list'] = $lang_common['BBCode nested list'];
		return '[list='.$type.']'.$content.'[/list]';
	}

	$items = explode('[*]', str_replace('\"', '"', $content));

	$content = '';
	foreach ($items as $item)
	{
		if (trim($item) != '')
			$content .= trim('[*]'.str_replace('[/*]', '', $item))."[/*]\n";
	}

	return '[list='.$type.']'."\n".$content.'[/list]';
}


//
// Split text into chunks ($inside contains all text inside $start and $end, and $outside contains all text outside)
//
function split_text($text, $start, $end, &$errors, $retab = true)
{
	global $forum_config, $lang_common;

	$tokens = explode($start, $text);

	$outside[] = $tokens[0];

	$num_tokens = count($tokens);
	for ($i = 1; $i < $num_tokens; ++$i)
	{
		$temp = explode($end, $tokens[$i]);

		if (count($temp) != 2)
		{
			$errors[] = $lang_common['BBCode code problem'];
			return array(null, array($text));
		}
		$inside[] = $temp[0];
		$outside[] = $temp[1];
	}

	if ($forum_config['o_indent_num_spaces'] != 8 && $retab)
	{
		$spaces = str_repeat(' ', $forum_config['o_indent_num_spaces']);
		$inside = str_replace("\t", $spaces, $inside);
	}

	return array($inside, $outside);
}


//
// Truncate URL if longer than 55 characters (add http:// or ftp:// if missing)
//
function handle_url_tag($url, $link = '', $bbcode = false)
{
	$return = ($hook = get_hook('ps_handle_url_tag_start')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	$full_url = str_replace(array(' ', '\'', '`', '"'), array('%20', '', '', ''), $url);
	if (strpos($url, 'www.') === 0)			// If it starts with www, we add http://
		$full_url = 'http://'.$full_url;
	else if (strpos($url, 'ftp.') === 0)	// Else if it starts with ftp, we add ftp://
		$full_url = 'ftp://'.$full_url;
	else if (!preg_match('#^([a-z0-9]{3,6})://#', $url)) 	// Else if it doesn't start with abcdef://, we add http://
		$full_url = 'http://'.$full_url;

	// Ok, not very pretty :-)
	if (!$bbcode)
		$link = ($link == '' || $link == $url) ? ((utf8_strlen($url) > 55) ? utf8_substr($url, 0 , 39).' &#133; '.utf8_substr($url, -10) : $url) : stripslashes($link);

	$return = ($hook = get_hook('ps_handle_url_tag_end')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	if ($bbcode)
	{
		if ($full_url == $link)
			return '[url]'.$link.'[/url]';
		else
			return '[url='.$full_url.']'.$link.'[/url]';
	}
	else
		return '<a href="'.$full_url.'">'.$link.'</a>';
}


//
// Turns an URL from the [img] tag into an <img> tag or a <a href...> tag
//
function handle_img_tag($url, $is_signature = false, $alt = null)
{
	global $lang_common, $forum_user;

	$return = ($hook = get_hook('ps_handle_img_tag_start')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	if ($alt == null)
		$alt = $url;

	$img_tag = '<a href="'.$url.'">&lt;'.$lang_common['Image link'].'&gt;</a>';

	if ($is_signature && $forum_user['show_img_sig'] != '0')
		$img_tag = '<img class="sigimage" src="'.$url.'" alt="'.forum_htmlencode($alt).'" />';
	else if (!$is_signature && $forum_user['show_img'] != '0')
		$img_tag = '<span class="postimg"><img src="'.$url.'" alt="'.forum_htmlencode($alt).'" /></span>';

	$return = ($hook = get_hook('ps_handle_img_tag_end')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	return $img_tag;
}


//
// Parse the contents of [list] bbcode
//
function handle_list_tag($content, $type = '*')
{
	$content = preg_replace('#\s*\[\*\](.*?)\[/\*\]\s*#s', '<li>$1</li>', trim($content));

	if ($type == '*')
		$content = '<ul>'.$content.'</ul>';
	else
		if ($type == 'a')
			$content = '<ol class="alpha">'.$content.'</ol>';
		else
			$content = '<ol class="decimal">'.$content.'</ol>';

	return '</p>'.$content.'<p>';
}


//
// Convert BBCodes to their HTML equivalent
//
function do_bbcode($text, $is_signature = false)
{
	global $lang_common, $forum_user, $forum_config;

	$return = ($hook = get_hook('ps_do_bbcode_start')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	if (strpos($text, '[quote') !== false)
	{
		$text = preg_replace('#\[quote\]\s*#', '</p><div class="quotebox"><blockquote><p>', $text);
		$text = preg_replace('#\[quote=(&quot;|"|\'|)(.*)\\1\]#seU', '"</p><div class=\"quotebox\"><cite>".str_replace(array(\'[\', \'\\"\'), array(\'&#91;\', \'"\'), \'$2\')." ".$lang_common[\'wrote\'].":</cite><blockquote><p>"', $text);
		$text = preg_replace('#\s*\[\/quote\]#', '</p></blockquote></div><p>', $text);
	}

	$pattern = array('#\[list=([1a\*])\](.*?)\[/list\]*#ems',
					 '#\[b\](.*?)\[/b\]#s',
					 '#\[i\](.*?)\[/i\]#s',
					 '#\[u\](.*?)\[/u\]#s',
					 '#\[colou?r=([a-zA-Z]{3,20}|\#[0-9a-fA-F]{6}|\#[0-9a-fA-F]{3})](.*?)\[/colou?r\]#s');

	$replace = array('handle_list_tag(\'$2\', \'$1\')',
					 '<strong>$1</strong>',
					 '<em>$1</em>',
					 '<span class="bbu">$1</span>',
					 '<span style="color: $1">$2</span>');

	if (($is_signature && $forum_config['p_sig_img_tag'] == '1') || (!$is_signature && $forum_config['p_message_img_tag'] == '1'))
	{
		$pattern[] = '#\[img\]((ht|f)tps?://)([^\s<"]*?)\[/img\]#e';
		$pattern[] = '#\[img=([^\[]*?)\]((ht|f)tps?://)([^\s<"]*?)\[/img\]#e';
		if ($is_signature)
		{
			$replace[] = 'handle_img_tag(\'$1$3\', true)';
			$replace[] = 'handle_img_tag(\'$2$4\', true, \'$1\')';
		}
		else
		{
			$replace[] = 'handle_img_tag(\'$1$3\', false)';
			$replace[] = 'handle_img_tag(\'$2$4\', false, \'$1\')';
		}
	}

	$pattern[] = '#\[url\]([^\[]*?)\[/url\]#e';
	$pattern[] = '#\[url=([^\[]+?)\](.*?)\[/url\]#e';
	$pattern[] = '#\[email\]([^\[]*?)\[/email\]#';
	$pattern[] = '#\[email=([^\[]+?)\](.*?)\[/email\]#';

	$replace[] = 'handle_url_tag(\'$1\')';
	$replace[] = 'handle_url_tag(\'$1\', \'$2\')';
	$replace[] = '<a href="mailto:$1">$1</a>';
	$replace[] = '<a href="mailto:$1">$2</a>';

	$return = ($hook = get_hook('ps_do_bbcode_replace')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	// This thing takes a while! :)
	$text = preg_replace($pattern, $replace, $text);

	$return = ($hook = get_hook('ps_do_bbcode_end')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	return $text;
}


//
// Make hyperlinks clickable
//
function do_clickable($text)
{
	$text = ' '.$text;

	$text = preg_replace('#([\s\(\)])(https?|ftp|news){1}://([\w\-]+\.([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^"\s\(\)<\[]*)?)#ie', '\'$1\'.handle_url_tag(\'$2://$3\', \'$2://$3\', true)', $text);
	$text = preg_replace('#([\s\(\)])(www|ftp)\.(([\w\-]+\.)*[\w]+(:[0-9]+)?(/[^"\s\(\)<\[]*)?)#ie', '\'$1\'.handle_url_tag(\'$2.$3\', \'$2.$3\', true)', $text);

	return utf8_substr($text, 1);
}


//
// Convert a series of smilies to images
//
function do_smilies($text)
{
	global $forum_config, $base_url, $smilies;

	$text = ' '.$text.' ';

	foreach ($smilies as $smiley_text => $smiley_img)
	{
		if (strpos($text, $smiley_text) !== false)
			$text = preg_replace("#(?<=.\W|\W.|^\W)".preg_quote($smiley_text, '#')."(?=.\W|\W.|\W$)#m", '$1<img src="'.$base_url.'/img/smilies/'.$smiley_img.'" width="15" height="15" alt="'.substr($smiley_img, 0, strrpos($smiley_img, '.')).'" />$2', $text);
	}

	return utf8_substr($text, 1, -1);
}


//
// Parse message text
//
function parse_message($text, $hide_smilies, $is_signature = false)
{
	global $forum_config, $lang_common, $forum_user;

	$return = ($hook = get_hook('ps_parse_message_start')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	if ($forum_config['o_censoring'] == '1')
		$text = censor_words($text);

	$return = ($hook = get_hook('ps_parse_message_post_censor')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	// Convert applicable characters to HTML entities
	$text = forum_htmlencode($text);

	$return = ($hook = get_hook('ps_parse_message_pre_split')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	// If the message contains a code tag we have to split it up (text within [code][/code] shouldn't be touched)
	if (strpos($text, '[code]') !== false && strpos($text, '[/code]') !== false && $is_signature === false)
	{
		list($inside, $outside) = split_text($text, '[code]', '[/code]', $errors);
		$text = implode('[%]', $outside);
	}

	$return = ($hook = get_hook('ps_parse_message_post_split')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	if ($forum_config['p_message_bbcode'] == '1' && strpos($text, '[') !== false && strpos($text, ']') !== false)
		$text = do_bbcode($text, $is_signature);
		
	if ($forum_config['o_smilies'] == '1' && $forum_user['show_smilies'] == '1' && $hide_smilies == '0')
		$text = do_smilies($text);

	$return = ($hook = get_hook('ps_parse_message_bbcode')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	// Deal with newlines, tabs and multiple spaces
	$pattern = array("\n", "\t", '  ', '  ');
	$replace = array('<br />', '&nbsp; &nbsp; ', '&nbsp; ', ' &nbsp;');
	$text = str_replace($pattern, $replace, $text);

	$return = ($hook = get_hook('ps_parse_message_pre_merge')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	// If we split up the message before we have to concatenate it together again (code tags)
	if (isset($inside))
	{
		$outside = explode('[%]', $text);
		$text = '';

		$num_tokens = count($outside);

		for ($i = 0; $i < $num_tokens; ++$i)
		{
			$text .= $outside[$i];
			if (isset($inside[$i]))
				$text .= '</p><div class="codebox"><pre><code>'.trim($inside[$i], "\n\r").'</code></pre></div><p>';
		}
	}

	$return = ($hook = get_hook('ps_parse_message_post_merge')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	// Add paragraph tag around post, but make sure there are no empty paragraphs
	if ($is_signature === false)
	{
		$text = preg_replace('#<br />\s*?<br />((\s*<br />)*)#i', "</p>$1<p>", $text);
		$text = str_replace('<p><br />', '<p>', $text);
		$text = str_replace('<p></p>', '', '<p>'.$text.'</p>');
	}

	$return = ($hook = get_hook('ps_parse_message_end')) ? eval($hook) : null;
	if ($return != null)
		return $return;

	return $text;
}


//
// Parse signature text
//
function parse_signature($text)
{
	global $forum_config, $lang_common, $forum_user;

	$return = ($hook = get_hook('ps_parse_signature_start')) ? eval($hook) : null;
	if ($return != null)
		return $return;
	
	return parse_message($text, false, true);
}

define('FORUM_PARSER_LOADED', 1);

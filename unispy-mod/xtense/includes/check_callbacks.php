<?php
	require_once('mod/Xtense/class/Callback.php');

	// Vidange de la table
	$db->sql_query('TRUNCATE TABLE `'.TABLE_XTENSE_CALLBACKS.'`');
	
	
	$insert = array(); 
	$callInstall = array('errors' => array(), 'success' => array()); 
	 
	if(version_compare($server_config['version'], '3.99', '<')) $query = $db->sql_query('SELECT action, root, id, title FROM '.TABLE_MOD.' WHERE active = 1');
	else $query = $db->sql_query('SELECT action, root, id FROM '.TABLE_MOD.' WHERE active = 1'); 
	while ($data = mysql_fetch_assoc($query)) { 
	        if (!file_exists('mod/'.$data['root'].'/_xtense.php')) continue; 
				if(!version_compare($server_config['version'], '3.99', '<')) $data['title'] = mod_info_title($data['root']);
	
	        try { 
	                $call = Callback::load($data['root']); 
					$error = false;
	        } catch (Exception $e) { 
	                $callInstall['errors'][] = $data['title'].' ('.__('callback install load').') : '.$e->getMessage(); 
					$error = true;
	        } 
	        if(!$error)
	        foreach ($call->getCallbacks() as $k => $c) { 
	                try { 
	                        if (empty($c)) continue; 
	                        if (!isset($c['function'], $c['type'])) throw new Exception(__('callback get invalid', $k)); 
	                        if (!in_array($c['type'], $callbackTypesNames)) throw new Exception(__('callback invalid type', __($c['type']))); 
	                        if (!isset($c['active'])) $c['active'] = 1; 
	                        if (!method_exists($call, $c['function'])) throw new Exception(__('callback get method', $c['function'])); 
	                        $insert[] = '('.$data['id'].', "'.$c['function'].'", "'.$c['type'].'", '.$c['active'].')'; 
	                        $callInstall['success'][] = $data['title'].' (#'.$k.') : '.__($c['type']); 
	                } catch (Exception $e) { 
	                        $callInstall['errors'][] = $data['title'].' : '.$e->getMessage(); 
	                } 
	        } 
	} 
	 
	if (!empty($insert)) { 
	        $db->sql_query('REPLACE INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES '.implode(', ', $insert)); 
	} 
	$tpl->assign('callInstall', $callInstall); 
	?>
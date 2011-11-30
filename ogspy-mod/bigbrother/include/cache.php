<?php

abstract class cache
{


    protected function set_cache($query)
    {
        global $db, $table_prefix, $server_config;

        $data = null;
        $result = $db->sql_query($query);

        while ($row = $db->sql_fetch_assoc($result)) {
            $data[$row['id']] = $row;
        }
        require_once (MOD_URL . "include/ally.php");
        $fh = @fopen(MOD_URL . 'cache/' . get_class($this) . '.php', 'wb');
        if (!$fh) {            {
                // impossible de creer le cache
                return false;
            }

        } else {
            fwrite($fh, '<?php' . "\n\n" . ' $temp = ' . var_export($data, true) . ';' . "\n\n" .
                '?>');

            fclose($fh);

        }


    }

}

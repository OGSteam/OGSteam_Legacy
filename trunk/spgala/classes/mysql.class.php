<?php
define('DEBUG', true);

	class DATABASE
	{
		var $connection = 0;
		var $query_id   = 0;

		function database($db_host, $db_user, $db_password, $db_name)
		{
			$this->connection = @mysql_connect($db_host, $db_user, $db_password);

			if ( !$this->connection )
				die('Database connection failed.');

			@mysql_select_db($db_name, $this->connection);
			$this->query('set names utf8');
			return $this->connection;
		}

		function close_db()
		{
			if ( $this->connection )
			{
				if ( $this->query_id )
					@mysql_free_result($this->query_id);

				@mysql_close($this->connection);
			}
		}

		function query( $query_string )
		{
			unset($this->query_id);

			if ( DEBUG )
				$this->query_id = mysql_query($query_string, $this->connection) or die(mysql_error($this->connection));
			else
				$this->query_id = @mysql_query($query_string, $this->connection) ;

			return $this->query_id;
		}

		function first_result($query_string)
		{
			$this->query($query_string);

			if ( $this->query_id !== false && mysql_num_rows($this->query_id) !== 0 )
			{
				$result = @mysql_result($this->query_id, 0);

				@mysql_free_result($this->query_id);

				return $result;
			}
			else
			{
				return false;
			}
		}

		function first_row($query_string)
		{
			$this->query($query_string);

			if ( $this->query_id !== false && mysql_num_rows($this->query_id) !== 0 )
			{
				$result = @mysql_fetch_array($this->query_id);

				@mysql_free_result($this->query_id);

				return $result;
			}
			else
			{
				return false;
			}
		}

	}
?>
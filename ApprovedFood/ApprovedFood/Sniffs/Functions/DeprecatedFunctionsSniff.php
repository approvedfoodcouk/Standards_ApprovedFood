<?php
if (class_exists('Generic_Sniffs_PHP_ForbiddenFunctionsSniff', true) === false) {
    throw new PHP_CodeSniffer_Exception('Class Generic_Sniffs_PHP_ForbiddenFunctionsSniff not found');
}

class ApprovedFood_Sniffs_Functions_DeprecatedFunctionsSniff extends Generic_Sniffs_PHP_ForbiddenFunctionsSniff
{
    /**
     * A list of forbidden functions with their alternatives.
     *
     * The value is NULL if no alternative exists. IE, the
     * function should just not be used.
     *
     * @var array(string => string|null)
     */
    public $forbiddenFunctions = array(
      'DB::insert' => 'DB::insertArray',
      'DB::update' => 'DB::updateArray',
      'DB::result' => 'DB::getvar',
      'DB::append' => 'DB::insertArray / DB::updateArray',
      // aliases
      'call_user_method'         => 'call_user_func',
      'call_user_method_array'   => 'call_user_func_array',
      'dir'                      => 'getdir',
      'diskfreespace'            => 'disk_free_space',
      'doubleval'                => 'floatval',
      'mysql_db_query'           => 'mysql_select_db and mysql_query',
      'mysql_escape_string'      => 'mysql_real_escape_string',
      'pos'                      => 'current',
      'session_is_registered'    => 'use $_SESSION',
      'session_register'         => 'use $_SESSION',
      'session_unregister'       => 'use $_SESSION',
      'set_socket_blocking'      => 'stream_set_blocking',
      'sizeof'                   => 'count',
      'split'                    => 'preg_split',
      'spliti'                   => 'preg_split',
      'strchr'                   => 'strstr',

      # 1) Discourages the use of alias functions that are kept in PHP for compatibility with older versions.
      'sizeof'          => 'count',
      'delete'          => 'unset',
      'print'           => 'echo',
      'is_null'         => 'comparison ($var === null)', // $var === null should be used instead
      'is_double'       => 'is_float', # odd alias, not deprecated
      'is_integer'      => 'is_int', # odd alias, not deprecated
      'is_long'         => 'is_int', # odd alias, not deprecated
      'is_real'         => 'is_float', # odd alias, not deprecated
      'create_function' => null,
      'chop'            => 'rtrim', # odd alias, not deprecated
      'ini_alter'       => 'ini_set',    # odd alias, not deprecated
      'join'            => 'implode',    # odd alias, not deprecated
      'key_exists'      => 'array_key_exists', # odd alias, not deprecated
      'fputs'           => 'fwrite',
      'is_writeable'    => 'is_writable', # odd alias, not deprecated (http://www.dict.cc/?s=writable)

      # 3) Discourages the use of PHP debugging functions
      // 'print_r'          => null,
      // 'var_dump'         => null,
      // 'error_log'        => null,

      //  # 4) Discourages the use of normal string functions, thereby enforces the usage of mbstring functions
      // 'strcut'          => 'mb_strcut',       # Get part of string
      // 'trimwidth'       => 'mb_strimwidth',   # Get truncated string with specified width
      // 'stripos'         => 'mb_stripos',      # Finds position of first occurrence of a string within another, case insensitive
      // 'stristr'         => 'mb_stristr',      # Finds first occurrence of a string within another, case insensitive
      // 'strlen'          => 'mb_strlen',       # Get string length
      // 'strpos'          => 'mb_strpos',       # Find position of first occurrence of string in a string
      // 'strrchr'         => 'mb_strrichr',     # Finds the last occurrence of a character in a string within another, case insensitive
      // 'strripos'        => 'mb_strripos',     # Finds position of last occurrence of a string within another, case insensitive
      // 'strrpos'         => 'mb_strrpos',      # Find position of last occurrence of a string in a string
      // 'strstr'          => 'mb_strstr',       # Finds first occurrence of a string within another
      // 'strtolower'      => 'mb_strtolower',   # Make a string lowercase
      // 'strtoupper'      => 'mb_strtoupper',   # Make a string uppercase
      // 'strwidth'        => 'mb_strwidth',     # Return width of string
      // 'substr_count'    => 'mb_substr_count', # Count the number of substring occurrences
      // 'substr'          => 'mb_substr',       # Get part of string
      // # 4b) Discourages the use of odd multi-bytes string aliases
      // 'mbstrcut'        => 'mb_strcut',
      // 'mbstrlen'        => 'mb_strlen',
      // 'mbstrpos'        => 'mb_strpos',
      // 'mbstrrpos'       => 'mb_strrpos',
      // 'mbsubstr'        => 'mb_substr',

      # 5) Discourages the use of ereg-functions in general = no ereg*() and no mb_ereg_*()
      'ereg'              => 'preg_match',
      'mb_ereg'           => 'preg_match',
      'eregi'             => 'preg_match with modifier i',
      'mb_eregi'          => 'preg_match with modifier i',
      'ereg_replace'      => 'preg_match with modifier i',
      'mb_ereg_replace'   => 'preg_match with modifier i',
      'eregi_replace'     => 'preg_match with modifier i',
      'mb_eregi_replace'  => 'preg_match with modifier i',

      # 6) deprecated functions as of php 5.3
      # http://www.php.net/manual/en/migration53.deprecated.php
      'call_user_method'         => 'call_user_func',
      'call_user_method_array'   => 'call_user_func_array',
      'define_syslog_variables'  => null,
      'dl'                       => null,
      'set_magic_quotes_runtime' => null,
      'session_register'         => 'use $_SESSION instead', # function
      'session_unregister'       => 'use $_SESSION instead', # function
      'session_is_registered'    => 'use $_SESSION instead', # function
      'set_socket_blocking'      => 'use stream_set_blocking instead',
      'split'                    => 'use preg_split instead',
      'spliti'                   => 'use preg_split with modifier i instead',
      'sql_regcase'              => null,
      'mysql_db_query'           => 'use mysql_select_db() and mysql_query() instead',
      'mysql_escape_string'      => 'use mysql_real_escape_string instead',
      # 7) deprecated ini directives / functions as of php 5.3
      # http://www.php.net/manual/en/migration53.deprecated.php
      'register_globals'         => null,
      'register_long_arrays'     => null,
      'safe_mode'                => null,
      'magic_quotes_gpc'         => null,
      'magic_quotes_runtime'     => null,
      'magic_quotes_sybase'      => null,
      'enable_dl'                => null,


      ## 7b) deprecated ini directives / functions as of php 5.4
      'session.bug_compat_warn'        => null, # ini
      'session.bug_compat42'           => null, # ini
      'y2k_compliance'                 => null, # ini
      'import_request_variables'       => null, # function
      'allow_call_time_pass_reference' => null, # ini
      'highlight.bg'                   => null,
      'safe_mode_gid'                  => null,
      'safe_mode_include_dir'          => null,
      'safe_mode_exec_dir'             => null,
      'safe_mode_allowed_env_vars'     => null,
      'safe_mode_protected_env_vars'   => null,
      #@todo add filter for putenv("TZ=") which was removed with 5.4.0b (15.11.2011)
      'get_magic_quotes_gpc'     => null, # function
      'get_magic_quotes_runtime' => null, # function
      'mcrypt_generic_end'       => 'use mcrypt_generic_deinit instead', # function
      'mysql_'                   => 'mysql is deprecated, use mysqli or PDO',
      'mysql_list_dbs'           => null, # function
      'mysql_db_query'           => 'use mysql_select_db and mysql_query',
      'mysql_escape_string'      => 'use mysql_real_escape_string',
      # Alias Functions Cleanups
      'mysqli_bind_param'        => 'use mysqli_stmt_bind_param instead',
      'mysqli_bind_result'       => 'use mysqli_stmt_bind_result instead',
      'mysqli_client_encoding'   => 'use mysqli_character_set_name instead',
      'mysqli_fetch'             => 'use mysqli_stmt_fetch instead',
      'mysqli_param_count'       => 'use mysqli_stmt_param_count instead',
      'mysqli_get_metadata'      => 'use mysqli_stmt_result_metadata instead',
      'mysqli_send_long_data'    => 'use mysqli_stmt_send_long_data instead',
      'mysqli::client_encoding'  => 'use mysqli::character_set_name instead',
      'mysqli_stmt::stmt'        => null,
      'die'                      => 'use exit instead',
      'flush'                    => 'rename method from flush to send',
      'set_socket_blocking'      => 'use stream_set_blocking instead',
      'xsl.security_prefs'       => 'use XsltProcessor::setSecurityPrefs instead',
      # deprecated function since PHP 5.5
      'mcrypt_ecb'               => 'use mcrypt_encrypt and mcrypt_decrypt instead',
      'mcrypt_cbc'               => 'use mcrypt_encrypt and mcrypt_decrypt instead',
      'mcrypt_cfb'               => 'use mcrypt_encrypt and mcrypt_decrypt instead',
      'mcrypt_ofb'               => 'use mcrypt_encrypt and mcrypt_decrypt instead',
      'datefmt_set_timezone_id'  => 'use datefmt_set_timezone or IntlDateFormatter::setTimeZone instead',
      'setTimeZoneID'            => 'use datefmt_set_timezone or IntlDateFormatter::setTimeZone instead',
      # deprecated ini directives since PHP 5.6
      'icon.input_encoding'        => 'use php.input_encoding, php.internal_encoding and php.output_encoding instead',
      'iconv.output_encoding'      => 'use php.input_encoding, php.internal_encoding and php.output_encoding instead',
      'iconv.internal_encoding'    => 'use php.input_encoding, php.internal_encoding and php.output_encoding instead',
      'mbstring.http_input'        => 'use php.input_encoding, php.internal_encoding and php.output_encoding instead',
      'mbstring.http_output'       => 'use php.input_encoding, php.internal_encoding and php.output_encoding instead',
      'mbstring.internal_encoding' => 'use php.input_encoding, php.internal_encoding and php.output_encoding instead',
      # 8) due to performance reasons the following methods are forbidden
      # Yes, you might call these premature optimizations, if applied!
      'file_exists'              => 'is_file',
      'strtr'                    => 'Use the faster str_replace instead of strtr',
      # The next one treats code clarity against performance. Now shut up!
      'array_unique'             => 'array_keys(array_flip($array))',

      // 9. use type casting in preference to functions
      'floatval'                 => 'type cast (float)', // type casting should be used instead
      'strval'                   => 'type cast (string)', // type casting should be used instead
      'intval'                   => 'type cast (int)', // type casting should be used instead

      //  configuration changes
        'set_include_path' => null,
        'restore_include_path' => null,
        'get_include_path' => null,
        'ini_set' => null,
        'ini_restore' => null,
        'ini_get' => null,
        'ini_get_all' => null,
        'ini_alter' => null,
        'get_cfg_var' => null,

        // Shell interaction
        'exec' => null,
        'shell_exec' => null,
        'popen' => null,
        'system' => null,
        'passthru' => null,

        // Code climate - Security
        'parse_str' => null,
        'sleep' => null,
        'usleep' => null,
    );

    /**
     * If true, an error will be thrown; otherwise a warning.
     *
     * @var bool
     */
    public $error = false;
}//end class

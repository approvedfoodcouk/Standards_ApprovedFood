<?php
if (class_exists('Generic_Sniffs_PHP_ForbiddenFunctionsSniff', true) === false) {
    throw new PHP_CodeSniffer_Exception('Class Generic_Sniffs_PHP_ForbiddenFunctionsSniff not found');
}

class ApprovedFood_Sniffs_Functions_ForbiddenFunctionsSniff extends Generic_Sniffs_PHP_ForbiddenFunctionsSniff
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
      'db_query' => 'DB::query',
      'db_append' => 'DB::append',
      'db_getvar' => 'DB::getvar',
      'db_getrow' => 'DB::getrow',
      'dblog' => 'use Log:: methods',
      'myesc' => 'DB::myesc',
      'insertID' => null,
      'mysql_insert_id' => null,
    );

    /**
     * If true, an error will be thrown; otherwise a warning.
     *
     * @var bool
     */
    public $error = true;
}//end class

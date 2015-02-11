<?php
class ApprovedFood_Sniffs_Strings_QueryStringsSniff implements PHP_CodeSniffer_Sniff
{
  /**
   * Returns the token types that this sniff is interested in.
   *
   * @return array(int)
   */
  public function register() {
    return array(
      T_CONSTANT_ENCAPSED_STRING
    );
  }
  /**
   * Processes the tokens that this sniff is interested in.
   *
   * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
   * @param int                  $stackPtr  The position in the stack where
   *                                        the token was found.
   *
   * @return void
   */
  public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
    $tokens = $phpcsFile->getTokens();
    $starter_keywords = array(
      'UPDATE',
      'INSERT INTO',
      'DELETE',
      'SELECT'
    );
    $keywords = array(
      'ADD',
      'ALL',
      'ALTER',
      'ANALYZE',
      'AND',
      'AS',
      'ASC',
      'ASENSITIVE',
      'BEFORE',
      'BETWEEN',
      'BIGINT',
      'BINARY',
      'BLOB',
      'BOTH',
      'BY',
      'CALL',
      'CASCADE',
      'CASE',
      'CHANGE',
      'CHAR',
      'CHARACTER',
      'CHECK',
      'COLLATE',
      'COLUMN',
      'CONDITION',
      'CONSTRAINT',
      'CONTINUE',
      'CONVERT',
      'CREATE',
      'CROSS',
      'CURRENT_DATE',
      'CURRENT_TIME',
      'CURRENT_TIMESTAMP',
      'CURRENT_USER',
      'CURSOR',
      'DATABASE',
      'DATABASES',
      'DAY_HOUR',
      'DAY_MICROSECOND',
      'DAY_MINUTE',
      'DAY_SECOND',
      'DEC',
      'DECIMAL',
      'DECLARE',
      'DEFAULT',
      'DELAYED',
      'DELETE',
      'DESC',
      'DESCRIBE',
      'DETERMINISTIC',
      'DISTINCT',
      'DISTINCTROW',
      'DIV',
      'DOUBLE',
      'DROP',
      'DUAL',
      'EACH',
      'ELSE',
      'ELSEIF',
      'ENCLOSED',
      'ESCAPED',
      'EXISTS',
      'EXIT',
      'EXPLAIN',
      'FALSE',
      'FETCH',
      'FLOAT',
      'FLOAT4',
      'FLOAT8',
      'FOR',
      'FORCE',
      'FOREIGN',
      'FROM',
      'FROM_UNIXTIME',
      'FULLTEXT',
      'GRANT',
      'GROUP',
      'HAVING',
      'HIGH_PRIORITY',
      'HOUR_MICROSECOND',
      'HOUR_MINUTE',
      'HOUR_SECOND',
      'IF',
      'IGNORE',
      'IN',
      'INDEX',
      'INFILE',
      'INNER',
      'INOUT',
      'INSENSITIVE',
      'INSERT',
      'INT',
      'INT1',
      'INT2',
      'INT3',
      'INT4',
      'INT8',
      'INTEGER',
      'INTERVAL',
      'INTO',
      'IS',
      'ITERATE',
      'JOIN',
      'KEY',
      'KEYS',
      'KILL',
      'LEADING',
      'LEAVE',
      'LEFT',
      'LIKE',
      'LIMIT',
      'LINES',
      'LOAD',
      'LOCALTIME',
      'LOCALTIMESTAMP',
      'LOCK',
      'LONG',
      'LONGBLOB',
      'LONGTEXT',
      'LOOP',
      'LOW_PRIORITY',
      'MATCH',
      'MEDIUMBLOB',
      'MEDIUMINT',
      'MEDIUMTEXT',
      'MIDDLEINT',
      'MINUTE_MICROSECOND',
      'MINUTE_SECOND',
      'MOD',
      'MODIFIES',
      'NATURAL',
      'NOT',
      'NO_WRITE_TO_BINLOG',
      'NULL',
      'NUMERIC',
      'ON',
      'OPTIMIZE',
      'OPTION',
      'OPTIONALLY',
      'OR',
      'ORDER',
      'OUT',
      'OUTER',
      'OUTFILE',
      'PRECISION',
      'PRIMARY',
      'PROCEDURE',
      'PURGE',
      'READ',
      'READS',
      'REAL',
      'REFERENCES',
      'REGEXP',
      'RELEASE',
      'RENAME',
      'REPEAT',
      'REPLACE',
      'REQUIRE',
      'RESTRICT',
      'RETURN',
      'REVOKE',
      'RIGHT',
      'RLIKE',
      'SCHEMA',
      'SCHEMAS',
      'SECOND_MICROSECOND',
      'SELECT',
      'SENSITIVE',
      'SEPARATOR',
      'SET',
      'SHOW',
      'SMALLINT',
      'SONAME',
      'SPATIAL',
      'SPECIFIC',
      'SQL',
      'SQLEXCEPTION',
      'SQLSTATE',
      'SQLWARNING',
      'SQL_BIG_RESULT',
      'SQL_CALC_FOUND_ROWS',
      'SQL_SMALL_RESULT',
      'SSL',
      'STARTING',
      'STRAIGHT_JOIN',
      'TABLE',
      'TERMINATED',
      'THEN',
      'TINYBLOB',
      'TINYINT',
      'TINYTEXT',
      'TO',
      'TRAILING',
      'TRIGGER',
      'TRUE',
      'TRUNCATE',
      'UNDO',
      'UNION',
      'UNIQUE',
      'UNLOCK',
      'UNSIGNED',
      'UPDATE',
      'USAGE',
      'USE',
      'USING',
      'UTC_DATE',
      'UTC_TIME',
      'UTC_TIMESTAMP',
      'VALUES',
      'VARBINARY',
      'VARCHAR',
      'VARCHARACTER',
      'VARYING',
      'WHEN',
      'WHERE',
      'WHILE',
      'WITH',
      'WRITE',
      'XOR',
      'YEAR_MONTH',
      'ZEROFILL',
      'ASENSITIVE',
      'CALL',
      'CONDITION',
      'CONNECTION',
      'CONTINUE',
      'CURSOR',
      'DECLARE',
      'DETERMINISTIC',
      'EACH',
      'ELSEIF',
      'EXIT',
      'FETCH',
      'GOTO',
      'INOUT',
      'INSENSITIVE',
      'ITERATE',
      'LABEL',
      'LEAVE',
      'LOOP',
      'MODIFIES',
      'OUT',
      'READS',
      'RELEASE',
      'REPEAT',
      'RETURN',
      'SCHEMA',
      'SCHEMAS',
      'SENSITIVE',
      'SPECIFIC',
      'SQL',
      'SQLEXCEPTION',
      'SQLSTATE',
      'SQLWARNING',
      'TRIGGER',
      'UNDO',
      'UPGRADE',
      'WHILE',
      'MAX',
      'SUM',
      'CONCAT',
      'AVG',
      'MIN',
      'COUNT',
      'BETWEEN'
    );
    foreach($starter_keywords as $keyword) {
      if(strtoupper(substr($tokens[$stackPtr]['content'], 1, strlen($keyword))) == $keyword) {
        $tokens[$stackPtr]['content'] = substr($tokens[$stackPtr]['content'], 1, -1);
        $pieces = explode(' ', $tokens[$stackPtr]['content']);
        foreach($pieces as $piece) {
          if(in_array(strtoupper($piece), $keywords)) {
            if(strtoupper($piece) == 'SELECT' && strpos(strtoupper($tokens[$stackPtr]['content']), 'FROM')) {
              if(strtoupper($piece) !== $piece) {
                $error = 'SQL keywords must be uppercase; expected "' . strtoupper($piece) . '" but found "' .
                $piece . '".';
                $phpcsFile->addError($error, $stackPtr);
              }
            }
            continue;
          }
        }
      }
    }
    #print_r($stackPtr);
    #echo "\n\n\n";
    #print_r($tokens[$stackPtr]);
    #echo "\n\n\n";
    #print_r($tokens[$stackPtr]);exit();
    #$t = $tokens[$stackPtr]['line'] + 1;
    #while($tokens[$t]['line'] < ($tokens[$stackPtr]['line'] + 2)) {
    #  if($tokens[$t]['line'] == $tokens[$stackPtr]['line']) {
    #    $t++;
    #    continue;
    #  }
    #  if($tokens[$t]['code'] !== T_WHITESPACE) return;
    #  $t++;
    #}
    #$error = 'The first line of a function must not be blank';
    #$phpcsFile->addError($error, $stackPtr);
  }
}

<?php

class ApprovedFood_Sniffs_Functions_DatabaseFunctionSniff implements PHP_CodeSniffer_Sniff
{
    public $methods = array('cmd', 'insert', 'update');

    public $cmd_map = array(
        'UPDATE' => array('replace' => 'DB::updateArray'),
        'INSERT' => array('replace' => 'DB::insertArray'),
        'DELETE' => array('replace' => 'DB::delete'),
        'SELECT' => array('replace' => 'alternatives DB::getrow or DB::getvar'),
        );
    
    public $regex_delete = '/DELETE\s+(LOW_PRIORITY\s+)?(QUICK\s+)?(IGNORE\s+)?FROM\s+/i';
    public $regex_insert = '/INSERT\s+((LOW_PRIORITY|DELAYED|HIGH_PRIORITY)\s+)?(IGNORE\s+)?INTO\s+/i';
    public $regex_select = array('/SELECT\s+.+\s+FROM\s+/i', '/SELECT\s+(.+\s+)+FROM\s+/i');
    public $regex_select_approx = '/SELECT\s+/i';
    public $regex_update  = array('/(?<!ON)\s*UPDATE\s+.+\s+SET\s+/i', '/(?<!ON)\s*UPDATE\s+(.+\s+)+SET\s+/i');
    public $regex_update_approx = '/(?<!ON)\s*UPDATE\s+/i';

    /**
    * Returns the token types that this sniff is interested in.
    *
    * @return array(int)
    */
    public function register()
    {
        return array(T_STRING);
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
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (!isset($tokens[$stackPtr - 2])) {
            return;
        }
        if (!isset($tokens[$stackPtr - 1])) {
            return;
        }

        $static_class = $tokens[$stackPtr - 2]['content'].$tokens[$stackPtr - 1]['content'];

        if ($static_class !== 'DB::') {
            //Only process DB:: class
            return;
        }

        $func_name = $tokens[$stackPtr]['content'];
        //Get the content that's passed to the function
        $s = $phpcsFile->findNext(T_OPEN_PARENTHESIS, $stackPtr);
        $closer = $tokens[$s]['parenthesis_closer'];
        $s = $phpcsFile->findNext(PHP_CodeSniffer_Tokens::$emptyTokens, $s+1, $closer, true);
        $pattern = $tokens[$s]['content'];
        if ($tokens[$s]['code'] == T_CONSTANT_ENCAPSED_STRING) {
            $command = 'SELECT *';
            if (substr($pattern, 1, strlen($command)) === $command) {
                $phpcsFile->addWarning('Using "SELECT *" can be very slow and memory hungry. Used named columns.', $stackPtr, 'DbSelectStar');
            }
        }

        if (in_array($func_name, $this->methods)) {
            if ($tokens[$s]['code'] == T_CONSTANT_ENCAPSED_STRING) {
                $match_found = false;
                foreach ($this->cmd_map as $command => $data) {
                    if (substr($pattern, 1, strlen($command)) === $command) {
                        $phpcsFile->addWarning('Usage of DB::'.$func_name.' with "'.$command.'" is deprecated. Use "'.$data['replace'].'"', $stackPtr, 'DbCmdDeprecated');
                        $match_found = true;
                        break;
                    }
                }

                if (!$match_found) {
                    $phpcsFile->addWarning('Weird usage of DB::'.$func_name.' with "'.$pattern.'"', $stackPtr, 'DbCmdWeird');
                }
            } elseif ($tokens[$s]['code'] == 309) {
                //Variable type
                $replace_string = '';
                $pre = '';
                foreach ($this->cmd_map as $command => $data) {
                    $replace_string .= $pre.$data['replace'];
                    $pre = ', ';
                }
                $phpcsFile->addWarning('DB::'.$func_name.'($variable) alternatives '.$replace_string, $stackPtr, 'DbCmdVariable');
            } else {
                $phpcsFile->addWarning('Weird usage of DB::'.$func_name.' with type '.$tokens[$s]['code'], $stackPtr, 'DbCmdNotString');
            }
        }
    }
}//end class

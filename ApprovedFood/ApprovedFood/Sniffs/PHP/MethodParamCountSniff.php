<?php
/**
 * Counts if certain function have the correct amount of parameters
 * 
 * ie: PDO::bindValue takes 2 parameters but the 3th parameter is to indicate the data type therefor its required
 * 
 * @package Codesniffer
 * @author Marcel Remmerts <marcelremmerts84@gmail.com>
 */
class ApprovedFood_Sniffs_PHP_MethodParamCountSniff implements PHP_CodeSniffer_Sniff {
    public $arr_methods = array(
        //methodname => mandatory paramcount (minimum)
        "bindValue" => 3,
    );
    /**
     * register the tokens were looking for
     * 
     * @return array
     */
    public function register() {
        return array(
            T_DOUBLE_COLON,
            T_OBJECT_OPERATOR,
        );
    }
    /**
     * check the file
     * 
     * @param PHP_CodeSniffer_File $phpcsFile the current file being processed
     * @param integer $stackPtr the location of the found token
     * 
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();
        $tokens = $phpcsFile->getTokens();
        if (in_array($tokens[$stackPtr]["code"], $this->register()) === false) {
            return;
        }
        $method_start = $phpcsFile->findNext(T_STRING, $stackPtr);
        $method = $tokens[$method_start]["content"];
        if (array_key_exists($method, $this->arr_methods) === false) {
            return;
        }
        //We need to deal with functioncalls, inline if-statements etc.
        //Therefore, find the first open parenthesis ( and keep track of some stack.
        //The end is always a semicolon.
        $method_end = $phpcsFile->findNext(T_SEMICOLON, $method_start);
        //Check if the method end is direct after the start. In other words: is there at least 1 param.
        $has_params = false;
        for ($i = $method_start + 1; $i < $method_end; $i ++) {
            $notParantesis = $tokens[$i]["code"] !== T_OPEN_PARENTHESIS && $tokens[$i]["code"] !== T_CLOSE_PARENTHESIS;
            if ($tokens[$i]["code"] !== T_WHITESPACE && $notParantesis === true) {
                $has_params = true;
                break;
            }
        }
        $param_count = 0;
        $current = $method_start + 1;
        $parenthesis_counter = 0;
        //Keep track of the parenthesis ( and ) and stack them.
        //If stack if 1 (or 0), than count the params.
        for ($i = $current; $i < $method_end; $i ++) {
            switch ($tokens[$i]["code"]) {
                case T_OPEN_PARENTHESIS:
                    $parenthesis_counter++;
                    continue 2;
                case T_CLOSE_PARENTHESIS:
                    $parenthesis_counter--;
                    continue 2;
                case T_COMMA:
                    if ($parenthesis_counter === 1) {
                        $param_count++;
                    }
                    break;
            }
        }
        //Always add 1 to the param count, if there are params. Because we only match on comma's, there will be 2 matches for 3 params for instance.
        if ($has_params === true) {
            $param_count ++;
        }
        if ($param_count !== $this->arr_methods[$method]) {
            $phpcsFile->addError(sprintf("Method '%s' only has %d params, it should have %d", $method, $param_count, $this->arr_methods[$method]), $stackPtr);
        }
    }
}

<?php
/**
 * Checks that a catch does not catch the Exception 
 * 
 * Catching the standard Exception is dangerous it will catch all exceptions even those
 * you did not calculate
 * 
 * @package Codesniffer
 * @author Marcel Remmerts <marcelremmerts84@gmail.com>
 */
class ApprovedFood_Sniffs_PHP_ExceptionCatchSniff implements PHP_CodeSniffer_Sniff {
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register() {
        return array(T_CATCH);
    }
    //end register()
    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer $stackPtr  The position of the current token in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $item = $phpcsFile->findNext(T_STRING, $stackPtr);
        $arr_tokens = $phpcsFile->getTokens();
        if ($arr_tokens[$item]["content"] === "Exception") {
            $phpcsFile->addWarning("Base class 'Exception' caught this can hide other important exceptions, please be more specific", $item);
        }
    }
}

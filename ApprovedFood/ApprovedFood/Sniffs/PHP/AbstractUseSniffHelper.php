<?php
abstract class ApprovedFood_Sniffs_PHP_AbstractUseSniffHelper implements PHP_CodeSniffer_Sniff
{
    protected function buildClasses($phpcsFile, $ptr, &$lastPtr = NULL)
    {
        $tokens = $phpcsFile->getTokens();
        $uses = array();
        while (TRUE) {
            $use = $phpcsFile->findNext(array(T_USE), $ptr);
            if ($use === FALSE) {
                break;
            }
            $ptr = $use + 1;
            $parenthesis = $phpcsFile->findNext(array(T_OPEN_PARENTHESIS), $use);
            if ($tokens[$use]['line'] === $tokens[$parenthesis]['line']) {
                continue; // use keyword from anonymous function
            }
            $uses[] = $use;
        }
        $classes = array();
        $usePtr = $ptr;
        foreach ($uses as $usePtr) {
            $class = $this->buildClassNameFromUse($phpcsFile, $usePtr);
            if ($class) {
                $classes[$usePtr] = $class;
            }
        }
        $lastPtr = $usePtr;
        return $classes;
    }
    public function buildClassNameFromUse($phpcsFile, $usePtr, $ns = FALSE)
    {
        $tokens = $phpcsFile->getTokens();
        $semicolon = $phpcsFile->findNext(array(T_SEMICOLON), $usePtr);
        $firstString = $phpcsFile->findNext(array(T_STRING), $usePtr);
        if (!$semicolon || $tokens[$semicolon]['line'] !== $tokens[$usePtr]['line'] || !$firstString) {
            $phpcsFile->addError(sprintf('Invalid %s clausule.', $ns === TRUE ? 'namespace' : 'use'), $usePtr);
            return NULL;
        }
        $class = '';
        for ($i = $firstString; $i < $semicolon; $i++) {
            $class .= $tokens[$i]['content'];
        }
        return $class;
    }
}

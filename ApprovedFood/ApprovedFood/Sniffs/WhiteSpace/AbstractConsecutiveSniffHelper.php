<?php
abstract class ApprovedFood_Sniffs_WhiteSpace_AbstractConsecutiveSniffHelper implements PHP_CodeSniffer_Sniff {
    protected function isEmptyLine($phpcsFile, $stackPtr) {
        return $phpcsFile->findFirstOnLine(array(T_WHITESPACE), $stackPtr, TRUE) === FALSE;
    }
}

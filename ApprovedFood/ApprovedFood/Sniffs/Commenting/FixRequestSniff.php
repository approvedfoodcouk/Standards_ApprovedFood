<?php
class ApprovedFood_Sniffs_Commenting_FixRequestSniff implements PHP_CodeSniffer_Sniff {
    protected $_fixRequests  = array('@todo', '@fixme', '@xxx');
    
    public function register()
    {
        return array(T_COMMENT);
    }
    
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        foreach ($this->_fixRequests as $fixRequest) {
            if (stripos($tokens[$stackPtr]['content'], $fixRequest)) {
                $phpcsFile->addError($fixRequest, $stackPtr);
                continue;
            }
        }
    }
}

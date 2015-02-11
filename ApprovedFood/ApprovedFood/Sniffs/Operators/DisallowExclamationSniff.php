<?php
class ApprovedFood_Sniffs_Operators_DisallowExclamationSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_BOOLEAN_NOT);
    }
    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile All the tokens found in the document.
     * @param int                  $stackPtr  The position of the current token in
     *                                        the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $varName = $tokens[$stackPtr];
        if ($varName['content'] == '!') {
            $warning = '! was found. Only usage with knowledge and wisdom is advisable';
            $phpcsFile->addWarning($warning, $stackPtr, 'RiskyLanguageConstruct', null, 1);
        }
    }
}

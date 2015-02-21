<?php
/**
 * Exception names must end with "Exception"
 * @author ondrej
 */
class ApprovedFood_Sniffs_Classes_ExceptionNamesSniff
    implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_CLASS,
        );
    }//end register()
    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $classNamePtr = $phpcsFile->findNext(T_STRING, $stackPtr);
        $className = $tokens[$classNamePtr]['content'];
        $extendsPtr = $phpcsFile->findNext(T_EXTENDS, $stackPtr);
        if ($extendsPtr !== FALSE) {
            $extendsName = $this->buildClassName($phpcsFile, $extendsPtr);
            if (substr($extendsName, -strlen('Exception')) === 'Exception') {
                if (substr($className, -strlen('Exception')) !== 'Exception') {
                    $phpcsFile->addError('Exception class names must end with "Exception".', $stackPtr);
                }
            }
        }
    }
    private function buildClassName(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $name = '';
        $next = $phpcsFile->findNext(T_WHITESPACE, $stackPtr + 1, NULL, TRUE);
        while (TRUE) {
            $next = $phpcsFile->findNext(array(T_WHITESPACE, T_STRING, T_NS_SEPARATOR), $next);
            if ($next === FALSE || $tokens[$next]['code'] === T_WHITESPACE) {
                break;
            }
            $name .= $tokens[$next]['content'];
            $next += 1;
        }
        return $name;
    }
}

<?php
/**
 * Prohibit some specific exceptions in catch statement
 * @author ondrej
 */
class ApprovedFood_Sniffs_ControlStructures_DisallowedExceptionsInCatchSniff implements PHP_CodeSniffer_Sniff
{
    private $prohibitedClasses = array(
        '\Exception',
        '\InvalidArgumentException',
        '\Collabim\Exception\InvalidStateException',
    );
    private $suppressPattern = '/@SuppressWarnings\("?CS(\.DisallowedExceptionsInCatch)?"?\)/';
    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(
            T_CATCH,
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
        $opener = $tokens[$stackPtr]['parenthesis_opener'];
        $ptr = $opener + 1;
        $class = '';
        while (TRUE) {
            $next = $phpcsFile->findNext(array(T_NS_SEPARATOR, T_STRING, T_WHITESPACE), $ptr);
            if ($next === FALSE || $tokens[$next]['code'] === T_WHITESPACE) {
                break;
            }
            $class .= $tokens[$next]['content'];
            $ptr = $next + 1;
        }
        if (in_array($class, $this->prohibitedClasses) && !$this->isCatchSuppressed($phpcsFile, $stackPtr)) {
            $throwExceptionStatementContent = NULL;
            $throwExceptionStatement = $this->findThrowExceptionStatementInCatch($phpcsFile, $stackPtr, $throwExceptionStatementContent);
            if ($throwExceptionStatement !== FALSE) {
                $firstInterruptStatement = $this->findInterruptStatementInBlock($phpcsFile, $stackPtr);
                if ($throwExceptionStatement !== $firstInterruptStatement) {
                    $phpcsFile->addError(
                        sprintf(
                            '"%s" while catching "%s" is allowed only if it\'s the first interruption statement in catch block. You can suppress this with @SuppressWarnings(CS.DisallowedExceptionsInCatch) annotation above function or class.',
                            $throwExceptionStatementContent,
                            $class
                        ),
                        $throwExceptionStatement
                    );
                }
            } else {
                $phpcsFile->addError(sprintf('Catching "%s" is prohibited. You can suppress this with @SuppressWarnings(CS.DisallowedExceptionsInCatch) annotation above function or class.', $class), $stackPtr);
            }
        }
    }
    private function isCatchSuppressed(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $function = $phpcsFile->findPrevious(T_FUNCTION, $stackPtr);
        $class = $phpcsFile->findPrevious(T_CLASS, $stackPtr);
        $tokens = $phpcsFile->getTokens();
        foreach(array($function, $class) as $block) {
            if ($block !== FALSE && $this->isBlockSuppressed($phpcsFile, $block)) {
                $opener = $tokens[$block]['scope_opener'];
                $closer = $tokens[$block]['scope_closer'];
                if ($opener < $stackPtr && $stackPtr < $closer) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }
    private function isBlockSuppressed(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $docPtr = $phpcsFile->findPrevious(T_DOC_COMMENT, $stackPtr);
        if ($docPtr === FALSE || $tokens[$docPtr]['line'] !== $tokens[$stackPtr]['line'] - 1) {
            return FALSE;
        }
        $doc = '';
        while ($docPtr !== FALSE && $tokens[$docPtr]['content'] !== "/**\n") {
            $doc = $tokens[$docPtr]['content'] . $doc;
            $docPtr = $phpcsFile->findPrevious(T_DOC_COMMENT, $docPtr - 1);
        }
        return preg_match($this->suppressPattern, $doc);
    }
    private function findThrowExceptionStatementInCatch(PHP_CodeSniffer_File $phpcsFile, $stackPtr, &$content)
    {
        $tokens = $phpcsFile->getTokens();
        $opener = $tokens[$stackPtr]['scope_opener'];
        $closer = $tokens[$stackPtr]['scope_closer'];
        $varPtr = $phpcsFile->findNext(T_VARIABLE, $tokens[$stackPtr]['parenthesis_opener'], $tokens[$stackPtr]['parenthesis_closer']);
        $var = $tokens[$varPtr]['content'];
        $next = $opener;
        while (TRUE) {
            $throw = $phpcsFile->findNext(T_THROW, $next, $closer);
            if ($throw === FALSE) {
                break;
            }
            $varCandidate = $phpcsFile->findNext(T_WHITESPACE, $throw + 1, $closer, TRUE);
            if ($varCandidate !== FALSE && $tokens[$varCandidate]['content'] === $var) {
                $content = 'throw ' . $var;
                return $throw;
            }
            $next = $throw + 1;
        }
        return FALSE;
    }
    private function findInterruptStatementInBlock(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        return $phpcsFile->findNext(
            array(T_RETURN, T_BREAK, T_CONTINUE, T_THROW),
            $tokens[$stackPtr]['scope_opener'],
            $tokens[$stackPtr]['scope_closer']
        );
    }
}

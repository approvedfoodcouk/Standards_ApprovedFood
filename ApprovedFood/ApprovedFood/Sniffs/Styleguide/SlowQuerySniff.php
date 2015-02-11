<?php
class ApprovedFood_Sniffs_Styleguide_SlowQuerySniff implements PHP_CodeSniffer_Sniff
{
    public $rawStatements = array(
        'GROUP BY',
        'HAVING',
        'DISTINCT',
        'LIKE',
        'UNION',
    );

    public $forbiddenStatements = array(
      'ALTER',
      'DROP'
    );

    protected function getStrTokens()
    {
        return array_merge(PHP_CodeSniffer_Tokens::$stringTokens, array(T_HEREDOC, T_NOWDOC));
    }

    public function register()
    {
        return array_merge(array(T_STRING), $this->getStrTokens());
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $ignoredTokens = array_merge(array(T_WHITESPACE, T_OPEN_PARENTHESIS), PHP_CodeSniffer_Tokens::$stringTokens);
        $prev = $tokens[$phpcsFile->findPrevious($ignoredTokens, $stackPtr - 1, null, true)];

        if (in_array($tokens[$stackPtr]['code'], $this->getStrTokens()) && ($prev['code'] === T_EQUAL || $prev['code'] == T_STRING || $prev['content'] === '.')) {
            foreach ($this->rawStatements as $statement) {
                if (preg_match('/'.$statement.'\s/i', trim($tokens[$stackPtr]['content']))) {
                    $phpcsFile->addWarning('Slow SQL detected using "'.$statement.'" in statement %s.', $stackPtr, 'SlowRawSql', array(trim($tokens[$stackPtr]['content'])));
                }
            }

            foreach ($this->forbiddenStatements as $statement) {
                if (preg_match('/'.$statement.'\s/i', trim($tokens[$stackPtr]['content']))) {
                    $phpcsFile->addError('Forbidden SQL detected using "'.$statement.'" in statement %s.', $stackPtr, 'ForbiddenRawSql', array(trim($tokens[$stackPtr]['content'])));
                }
            }
        }
    }
}

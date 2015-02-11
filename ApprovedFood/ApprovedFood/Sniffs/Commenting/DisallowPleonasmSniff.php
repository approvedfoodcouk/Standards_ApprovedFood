<?php
/**
 * Class HowdenStandard_Sniffs_Commenting_DisallowPleonasmSniff
 *
 * Disallows superfleus words in comment strings (such as function to, function for). They're
 * called "pleonasms" #themoreyouknow
 */
class ApprovedFood_Sniffs_Commenting_DisallowPleonasmSniff implements PHP_CodeSniffer_Sniff {
    private static $pleonasms = array(
        'function to',
        'function for',
        'function that',
        'method to',
        'method for',
        'method that',
        'class to',
        'class for',
        'class that',
        'undertaken',
     //  'of the',
     // 'that',
        'analysis of',
        'bother',
        'seems',
        'an array of',
        'has issues',
        'in the case of'
    );
    public function register()
    {
        return array(T_COMMENT, T_DOC_COMMENT);
    }
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();
        foreach(self::$pleonasms as $pleonasm) {
            // Convert content to lower case for comparison.
            $content = strtolower($tokens[$stackPtr]['content']);
            if (strpos($content, $pleonasm) !== false) {
                $error = 'Remove pleonasm (' . $pleonasm . ')';
                $data = array(trim($tokens[$stackPtr]['content']));
                $phpcsFile->addError($error, $stackPtr, 'Found', $data);
            }
        }
    }
}

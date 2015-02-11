<?php
/**
 * Checks if casting is as described in the styleguide
 *
 * @author  Tijs Verkoyen <tijs@sumocoders.be>
 */
class ApprovedFood_Sniffs_Styleguide_CastingSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Processes the code.
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $current = $tokens[$stackPtr];
        $next = $tokens[$stackPtr + 1];
        // handle all types
        switch($current['code'])
        {
            // there should be exactly one space after the closing brace
            case T_BOOL_CAST:
                if($current['content'] != '(bool)') $phpcsFile->addError('We use (bool) instead of (boolean)', $stackPtr);
                break;
            case T_DOUBLE_CAST:
                if($current['content'] != '(float)')
                {
                    $phpcsFile->addError('We use (float) instead of (double)', $stackPtr);
                }
                break;
            case T_ARRAY_CAST:
            case T_INT_CAST:
            case T_OBJECT_CAST:
            case T_STRING_CAST:
            case T_UNSET_CAST:
                break;
        }
        unset($tokens);
        unset($current);
        unset($next);
    }
    /**
     * Register on typecasting
     *
     * @return array
     */
    public function register()
    {
        return array(T_ARRAY_CAST, T_BOOL_CAST, T_DOUBLE_CAST, T_INT_CAST, T_OBJECT_CAST, T_STRING_CAST, T_UNSET_CAST);
    }
}

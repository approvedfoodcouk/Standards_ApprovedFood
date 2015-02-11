<?php
/**
 * Type casting sniff.
 *
 * Throws errors if type-casting expressions are not spaced properly or
 * if long forms of type-casting operators are used.
 *
 * @author     Kohana Team
 * @copyright  Copyright (C) 2011 Kohana Team
 * @license    BSD-3-Clause
 */
class ApprovedFood_Sniffs_Operators_TypeCastingSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return array(
            T_ARRAY_CAST,
            T_BOOL_CAST,
            T_DOUBLE_CAST,
            T_INT_CAST,
            T_OBJECT_CAST,
            T_STRING_CAST,
            T_UNSET_CAST
        );
    }
    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        switch (strtolower($tokens[$stackPtr]['content'])) {
            case '(integer)':
            case '(boolean)':
                $error = '(int) and (bool) should be used instead of (integer) and (boolean)';
                $phpcsFile->addError($error, $stackPtr);
                break;
        }
    }
}

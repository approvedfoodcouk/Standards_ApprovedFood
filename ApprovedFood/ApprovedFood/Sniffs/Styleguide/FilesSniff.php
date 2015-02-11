<?php
/**
 * Checks if a file is formatted as described in the styleguide
 *
 * @author Tijs Verkoyen <tijs@sumocoders.be>
 */
class ApprovedFood_Sniffs_Styleguide_FilesSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Processes the code.
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        // check line endings
        if($phpcsFile->eolChar !== "\n")
        {
            $phpcsFile->addError('We expect lines to end with "\n".', $stackPtr);
        }
    }
    /**
     * Registers on php opening/closing tags
     *
     * @return array
     */
    public function register()
    {
        return array(T_OPEN_TAG, T_CLOSE_TAG);
    }
}

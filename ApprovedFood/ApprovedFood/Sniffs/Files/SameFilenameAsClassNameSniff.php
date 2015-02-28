<?php
/**
 * @author ondrej
 */
class ApprovedFood_Sniffs_Files_SameFilenameAsClassNameSniff extends ApprovedFood_Sniffs_PHP_AbstractUseSniffHelper
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
            T_INTERFACE
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
        $name = $phpcsFile->getDeclarationName($stackPtr);
        $filename = pathinfo($phpcsFile->getFilename(), PATHINFO_FILENAME);
        if ($name.'.class' !== $filename) {
            $phpcsFile->addWarning("Class name '$name' and file name '$filename.php' do not match.", $stackPtr);
        }
    }
}//end class

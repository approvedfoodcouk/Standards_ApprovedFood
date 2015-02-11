<?php
/**
 * Give warning if file length is 500+, give error if file length is 1000+.
 *
 * @author Jassiem Moore
 * @author Ryan Masters
 */
class ApprovedFood_Sniffs_Files_FileLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     */
    public function register()
    {
        return array( T_CLOSE_TAG );
    }
    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param PHP_CodeSniffer_File $oPHPCSFile     The file where the token was found.
     * @param int                  $iStackPointer  The position in the stack where the token was found.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $oPHPCSFile, $iStackPointer)
    {
        // get all the tokens in the file
        $aTokens   = $oPHPCSFile->getTokens();
        // get the line this token is on
        $iFileSize = $aTokens[ $iStackPointer ][ 'line' ];
        // throw warning for 500 < line <= 1000
        if( $iFileSize > 500 && $iFileSize <= 1000 )
        {
            // add warning
            $sWarn = 'File length is greater than 500 lines. Consider refactoring.';
            $oPHPCSFile->addWarning( $sWarn, $iStackPointer );
        }
        // throw error for line > 1000
        else if( $iFileSize > 1000 )
        {
            // add error
            $sError = 'File has exceeded 1000 lines. Refactor.';
            $oPHPCSFile->addError( $sError, $iStackPointer );
        }
    }
}

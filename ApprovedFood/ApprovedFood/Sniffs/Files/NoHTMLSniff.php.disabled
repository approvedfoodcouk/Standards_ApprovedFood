<?php
/**
 * Make sure there is no html in the file.  This includes html tags in strings.
 *
 * @author Jassiem Moore
 * @author Ryan Masters
 */
class ApprovedFood_Sniffs_Files_NoHTMLSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     */
    public function register()
    {
        return array( T_CONSTANT_ENCAPSED_STRING, T_INLINE_HTML );
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
        // get all the tokens in this file
        $aTokens = $oPHPCSFile->getTokens();
        // check if this is inline HTML or not
        if( $aTokens[ $iStackPointer ][ 'type' ] == T_INLINE_HTML )
        {
            // add error
            $sError = 'HTML tags are not allowed in php files.';
            $oPHPCSFile->addError( $sError, $iStackPointer );
        }
        else
        {
            // compare the original string to the stripped version
            $sText = $aTokens[ $iStackPointer ][ 'content' ];
            // check if there are html tags in string
            if( preg_match( "/<[^<]+>/", $sText ) != 0 )
            {
                // add error
                $sError = 'HTML tags are not allowed in php files.';
                $oPHPCSFile->addError( $sError, $iStackPointer );
            }
        }
    }
}

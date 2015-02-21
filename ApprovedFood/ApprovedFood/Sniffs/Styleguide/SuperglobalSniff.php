<?php
class ApprovedFood_Sniffs_Styleguide_SuperglobalSniff implements PHP_CodeSniffer_Sniff
{
    public $errSuperglobals = array(
        '$_REQUEST' => 'Use $_GET or $_POST',
        '$_ENV' => '',
    );

    public $warnSuperglobals = array(
        '$GLOBALS' => '',
        '$_SERVER' => '',
        '$_GET' => 'Beware of security issues',
        '$_POST' => 'Beware of security issues',
        '$_FILES' => 'Beware of security issues',
        '$_COOKIE' => 'Beware of security issues',
        '$_SESSION' => 'Beware of security issues',
    );

    public function register()
    {
        return array(T_VARIABLE);
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $var = $tokens[$stackPtr]['content'];
        if (array_key_exists($var, $this->errSuperglobals)) {
            $phpcsFile->addError('Use of %s Superglobal forbidden. '.$this->errSuperglobals[$var], $stackPtr, 'SuperglobalForbidden', array($var));
        }
        if (array_key_exists($var, $this->warnSuperglobals)) {
            $phpcsFile->addWarning('Direct use of %s Superglobal detected. '.$this->warnSuperglobals[$var], $stackPtr, 'SuperglobalUsage', array($var));
        }
    }
}

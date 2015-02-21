<?php
class ApprovedFood_Sniffs_Files_FileExtensionSniff  implements PHP_CodeSniffer_Sniff
{
    public function register()
    {
        return array(T_OPEN_TAG);
    }//end register()

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $prevOpenTag = $phpcsFile->findPrevious(T_OPEN_TAG, ($stackPtr - 1));

        if ($prevOpenTag !== false) {
            return;
        }

        $fileName  = $phpcsFile->getFileName();
        $nextClass = $phpcsFile->findNext(array(T_CLASS, T_INTERFACE), $stackPtr);

        if (preg_match('/(.*)\.class\.php/i', $fileName)
            || preg_match('/class\.(.*)\.php/i', $fileName)
            ) {
            if ($nextClass === false) {
                $error = 'No interface or class found in ".class.php" file; use ".php" extension instead';
                $phpcsFile->addError($error, $stackPtr);
            }
        } elseif (!preg_match('/class\.(.*)\.php/i', $fileName)) {
            if ($nextClass !== false && false === strpos($fileName, 'model')) {
                $error = 'Use "<CLASSNAME>.class.php" filename instead of "class.<CLASSNAME>.php for PSR4 compat." ';
                $phpcsFile->addWarning($error, $stackPtr);
            }
        } elseif (!preg_match('/(.*)\.class\.php/i', $fileName)) {
            if ($nextClass !== false && false === strpos($fileName, 'model')) {
                $error = 'Use "<CLASSNAME>.class.php" extension for the class file';
                $phpcsFile->addError($error, $stackPtr);
            }
        }
    }//end process()
}//end class

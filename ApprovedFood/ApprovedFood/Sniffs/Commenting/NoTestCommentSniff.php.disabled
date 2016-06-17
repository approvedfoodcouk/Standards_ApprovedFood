<?php
/**
 * @property string $testPaths
 */
class ApprovedFood_Sniffs_Commenting_NoTestCommentSniff implements PHP_CodeSniffer_Sniff
{
    public function register()
    {
        return array(
            T_CLASS
        );
    }//end register()

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $namespace = $this->getNamespace($phpcsFile, $stackPtr);
        $className = pathinfo($phpcsFile->getFilename(), PATHINFO_FILENAME);
        if ($this->shouldBeSkiped($className, $namespace)) {
            return;
        }

        $classNameWithNamespace = $namespace ? ($namespace.'\\'.$className) : $className;
        $testClassExists = $this->checkIfTestClassExists($className, $namespace);
        if ($testClassExists === true) {
            return;
        }

        $testPaths = $this->getTestPathString($className, $namespace);
        $classCommentEndStackPtr = $phpcsFile->findPrevious(T_DOC_COMMENT, $stackPtr);
        if ($classCommentEndStackPtr) {
            $this->checkClassComments($phpcsFile, $classCommentEndStackPtr, $stackPtr);
        } else {
            $this->noAnnotationExists($phpcsFile, $stackPtr, $testPaths);
        }
    }//end process()

    private function getNamespace(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $namespaceStackPtr = $phpcsFile->findPrevious(T_NAMESPACE, $stackPtr);
        if ($namespaceStackPtr) {
            $tokens = $phpcsFile->getTokens();
            $namespaceStartStackPtr = $phpcsFile->findNext(T_STRING, $namespaceStackPtr);
            $namespaceName = '';
            $i = $namespaceStartStackPtr;
            do {
                $token = $tokens[$i];
                if ($token['type'] === 'T_SEMICOLON') {
                    break;
                }

                $namespaceName .= $token['content'];
                $i++;
            } while (true);

            return $namespaceName;
        }//end if
        return null;
    }//end getNamespace()

    private function shouldBeSkiped($className, $namespace)
    {
        if (substr($className, -6) === 'Mapper') {
            // Mappers should have long tests, not src tests
            return true;
        } elseif (substr($className, -7) === 'Factory') {
            return true;
        } elseif ($namespace === 'Model\Configuration') {
            // No need to test mapper configuration objects
            return true;
        }
        return false;
    }

    private function checkClassComments(PHP_CodeSniffer_File $phpcsFile, $classCommentPartStackPtr, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        do {
            $classCommentPartStackPtr = $phpcsFile->findPrevious(T_DOC_COMMENT, $classCommentPartStackPtr - 1);
            if ($classCommentPartStackPtr === false) {
                $this->noAnnotationExists($phpcsFile, $stackPtr);
                break;
            }
            $classCommentPartContent = $tokens[$classCommentPartStackPtr]['content'];
            if (mb_strpos($classCommentPartContent, '@noTest') !== false) {
                if (!$this->reasonDefined($classCommentPartContent)) {
                    $phpcsFile->addError('Reason does not exist for @noTest class annotation', $classCommentPartStackPtr);
                }
                return;
            }
        } while (true);
    }//end checkClassComments()

    private function noAnnotationExists(PHP_CodeSniffer_File $phpcsFile, $stackPtr, $testPaths = '')
    {
        $err = 'Neither test class nor @noTest class annotation exist.';
        if (!empty($testPaths)) {
            $err .= 'Expected file '.$testPaths;
        }
        $phpcsFile->addError($err, $stackPtr);
    }//end noAnnotationExists()

    private function reasonDefined($classCommentPartContent)
    {
        return (bool) preg_match('~@noTest[\s]+[^\s]+~i', $classCommentPartContent);
    }//end reasonDefined()

    private function checkIfTestClassExists($className, $namespace)
    {
        foreach ($this->getTestPaths() as $supportedDir) {
            if ($namespace) {
                $testPath = $supportedDir.'/'.str_replace('\\', '/', $namespace).'/'.$className.'Test.php';
            } else {
                $testPath = $supportedDir.'/'.$className.'Test.php';
            }

            if (file_exists($testPath)) {
                return true;
            }
        }
        return false;
    }//end checkIfTestClassExists()

    private function getTestPathString($className, $namespace)
    {
        $testPath = '';
        $testPre = '';
        foreach ($this->getTestPaths() as $supportedDir) {
            if ($namespace) {
                $testPath .= $testPre.$supportedDir.'/'.str_replace('\\', '/', $namespace).'/'.$className.'Test.php';
            } else {
                $testPath .= $testPre.$supportedDir.'/'.$className.'Test.php';
            }
            $testPre = ', ';
        }
        return $testPath;
    }//end getTestPathString()

    private function getTestPaths()
    {
        $this->testPaths = str_replace('{rootDirectory}', realpath(dirname(__FILE__).'/../../'), $this->testPaths);
        if (substr($this->testPaths, -1, 1) === ';') {
            return explode(';', substr($this->testPaths, 0, -1));
        }

        return explode(';', $this->testPaths);
    }//end getTestPaths()
}//end class

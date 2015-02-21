<?php
class ApprovedFood_Sniffs_Styleguide_UsesFromTheSameNamespaceSniff implements PHP_CodeSniffer_Sniff {
    private $useStatementClassFinder;
    public function __construct() {
        $this->useStatementClassFinder = ApprovedFood_Lib_DependencyInjection_Container::getUseStatementClassFinderCached();
    }
    public function register() {
        return array(
            T_OPEN_TAG,
        );
    }
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $classesInUse = $this->useStatementClassFinder->findClasses($phpcsFile);
        $namespacePtr = $phpcsFile->findNext(T_NAMESPACE, $stackPtr);
        if ($namespacePtr === FALSE) {
            return;
        }
        $namespace = $this->useStatementClassFinder->buildClassNameFromUse($phpcsFile, $namespacePtr, TRUE);
        foreach ($classesInUse->getClasses() as $class) {
            $fullClassName = $class->getFullClassName();
            if (substr($fullClassName, 0, strlen($namespace)) === $namespace) {
                $rest = substr($fullClassName, strlen($namespace));
                if (strlen($rest) > 0 && substr($rest, 0, 1) !== '\\') {
                    continue;
                }
                if ($this->str_count($rest, '\\') > 1) {
                    continue;
                }
                $phpcsFile->addError('Use clausule with class from the same namespace is prohibited.', $class->getUsePtr());
            }
        }
    }
    private function str_count($haystack, $needle) {
        $count = 0;
        $pos = strpos($haystack, $needle);
        while ($pos !== FALSE) {
            $pos = strpos($haystack, $needle, $pos + 1);
            $count++;
        }
        return $count;
    }
}

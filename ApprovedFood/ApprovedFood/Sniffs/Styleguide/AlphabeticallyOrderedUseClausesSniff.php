<?php
class ApprovedFood_Sniffs_Styleguide_AlphabeticallyOrderedUseClausesSniff implements PHP_CodeSniffer_Sniff {
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
        $sortedClassNames = $classesInUse->getFullClassNames();
        sort($sortedClassNames, SORT_STRING); //SORT_FLAG_CASE | 
        foreach ($classesInUse->getClasses() as $index => $class) {
            if ($class->getFullClassName() !== $sortedClassNames[$index]) {
                $phpcsFile->addError('Use clause must be alphabetically ordered.', $class->getUsePtr());
                break;
            }
        }
    }
}

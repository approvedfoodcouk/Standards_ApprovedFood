<?php
class ApprovedFood_Sniffs_Styleguide_UnusedUseClausesSniff implements PHP_CodeSniffer_Sniff {
    private $classFinder;
    private $phpDocsClassFinder;
    private $useStatementClassFinder;
    public function __construct() {
        $this->classFinder = ApprovedFood_Lib_DependencyInjection_Container::getClassFinderCached();
        $this->phpDocsClassFinder = ApprovedFood_Lib_DependencyInjection_Container::getPhpDocsClassFinderCached();
        $this->useStatementClassFinder = ApprovedFood_Lib_DependencyInjection_Container::getUseStatementClassFinderCached();
    }
    public function register() {
        return array(
            T_OPEN_TAG,
        );
    }
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $classesInUses = $this->useStatementClassFinder->findClasses($phpcsFile)->getIndexedByUsePtr();
        $usedClasses = $this->classFinder->findClasses($phpcsFile);
        $classesUsedInPhpDocs = $this->phpDocsClassFinder->findClasses($phpcsFile);
        foreach ($classesInUses as $ptr => $class) {
            $classNameOrAs = $class->getNameOrAs();
            if ($classesUsedInPhpDocs->containsClass($classNameOrAs)) {
                continue;
            }
            if (!$usedClasses->containsClass($classNameOrAs)) {
                $phpcsFile->addError(
                    sprintf('Identifier %s from use clause is not used in this file.', $classesInUses[$ptr]->getFullClassNmeOrAs()),
                    $ptr
                );
            }
        }
    }
}

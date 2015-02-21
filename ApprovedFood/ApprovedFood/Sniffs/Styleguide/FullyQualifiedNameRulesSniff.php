<?php
class ApprovedFood_Sniffs_Styleguide_FullyQualifiedNameRulesSniff implements PHP_CodeSniffer_Sniff {
    private $classFinder;
    private $phpDocsClassFinder;
    private $classInPhpDocsFinder;
    private $allClassFinder;
    private $namespaceSeparatorDetector;
    private $classNameComposerForward;
    private $classNameParser;
    public function __construct() {
        $this->classFinder = ApprovedFood_Lib_DependencyInjection_Container::getClassFinderCached();
        $this->phpDocsClassFinder = ApprovedFood_Lib_DependencyInjection_Container::getPhpDocsClassFinderCached();
        $this->classInPhpDocsFinder = ApprovedFood_Lib_DependencyInjection_Container::getClassInPhpDocsFinder();
        $this->allClassFinder = ApprovedFood_Lib_DependencyInjection_Container::getAllClassFinder();
        $this->namespaceSeparatorDetector = ApprovedFood_Lib_DependencyInjection_Container::getNamespaceSeparatorDetector();
        $this->classNameComposerForward = ApprovedFood_Lib_DependencyInjection_Container::getClassNameComposerForward();
        $this->classNameParser = ApprovedFood_Lib_DependencyInjection_Container::getClassNameParser();
    }
    public function register() {
        return array(
            T_NS_SEPARATOR,
            T_DOC_COMMENT
        );
    }
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$stackPtr]['type'] === 'T_NS_SEPARATOR') {
            $this->processNamespaceSeparator($phpcsFile, $stackPtr);
        }
        else if ($tokens[$stackPtr]['type'] === 'T_DOC_COMMENT') {
            $this->processPhpDocComment($phpcsFile, $stackPtr);
        }
    }
    private function processNamespaceSeparator(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        /* NOT WORKING AS EXPECTED
        $tokens = $phpcsFile->getTokens();
        if (!$this->namespaceSeparatorDetector->isFirstNamespaceSeparator($phpcsFile, $stackPtr)) {
            return;
        }
        $classDefinedBeforeCurrentStackPtr = $phpcsFile->findPrevious(T_CLASS, $stackPtr);
        if ($classDefinedBeforeCurrentStackPtr) {
            if ($tokens[$stackPtr - 1]['type'] === 'T_STRING') {
                $phpcsFile->addError('Partial use statements are NOT allowed.', $stackPtr);
            }
            else {
                $fullClassName = $this->classNameComposerForward->composeClassName($phpcsFile, $stackPtr);
                $class = $this->classNameParser->parse($fullClassName);
                $allUsedClasses = $this->allClassFinder->findClassesIncludingFileClass($phpcsFile);
                $foundClass = $allUsedClasses->findClassSameNameDifferentNamespace($class->getName(), $class->getNamespace());
                if (!$foundClass) {
                    $phpcsFile->addError('Fully qualified class name must NOT be used', $stackPtr);
                }
            }
        }
        */
    }
    private function processPhpDocComment(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        /* NOT WORKING AS EXPECTED
        $tokens = $phpcsFile->getTokens();
        $tokenContent = $tokens[$stackPtr]['content'];
        $classInPhpDocs = $this->classInPhpDocsFinder->find($tokenContent);
        if ($this->isFullyQualifiedClassDefinition($classInPhpDocs)) {
            $allUsedClasses = $this->allClassFinder->findClassesIncludingFileClass($phpcsFile);
            $foundClass = $allUsedClasses->findClassSameNameDifferentNamespace($classInPhpDocs->getName(), $classInPhpDocs->getNamespace());
            if (!$foundClass) {
                $phpcsFile->addError('Fully qualified class name must NOT be used even in PHPDocs comments', $stackPtr);
            }
        }
        */
    }
    private function isFullyQualifiedClassDefinition(ApprovedFood_Lib_ClassDefinition $classInPhpDocs = null) {
        return $classInPhpDocs && $classInPhpDocs->getNamespace();
    }
}

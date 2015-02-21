<?php

class ApprovedFood_Lib_ClassFinder  {

	private $classNameParser;
	private $implementsParser;
	private $staticCallsParser;
	private $typeHintingParser;
	private $simpleParser;

	public function __construct(
		ApprovedFood_Lib_ClassNameParser $classNameParser,
		ApprovedFood_Lib_ClassFinder_ImplementsParser $implementsParser,
		ApprovedFood_Lib_ClassFinder_StaticCallsParser $staticCallsParser,
		ApprovedFood_Lib_ClassFinder_TypeHintingParser $typeHintingParser,
		ApprovedFood_Lib_ClassFinder_SimpleParser $simpleParser
	) {
		$this->classNameParser = $classNameParser;
		$this->implementsParser = $implementsParser;
		$this->staticCallsParser = $staticCallsParser;
		$this->typeHintingParser = $typeHintingParser;
		$this->simpleParser = $simpleParser;
	}

	public function findClasses(PHP_CodeSniffer_File $phpcsFile) {
		$classNames = array();
		$classNames = array_merge($classNames, $this->getClassesFromNewInstanceOfExtends($phpcsFile));
		$classNames = array_merge($classNames, $this->staticCallsParser->getClassNames($phpcsFile));
		$classNames = array_merge($classNames, $this->typeHintingParser->getClassNames($phpcsFile));
		$classNames = array_merge($classNames, $this->implementsParser->getClassNames($phpcsFile));

		return $this->formatOutput($classNames);
	}

	public function findClassesIncludingFileClass(PHP_CodeSniffer_File $phpcsFile) {
		$classNames = array();
		$classNames = array_merge($classNames, $this->getClassesFromClassNewInstanceOfExtends($phpcsFile));
		$classNames = array_merge($classNames, $this->staticCallsParser->getClassNames($phpcsFile));
		$classNames = array_merge($classNames, $this->typeHintingParser->getClassNames($phpcsFile));
		$classNames = array_merge($classNames, $this->implementsParser->getClassNames($phpcsFile));

		return $this->formatOutput($classNames);
	}

	private function getClassesFromNewInstanceOfExtends(PHP_CodeSniffer_File $phpcsFile) {
		return $this->simpleParser->getClassNames($phpcsFile, array(T_NEW, T_INSTANCEOF, T_EXTENDS));
	}

	private function getClassesFromClassNewInstanceOfExtends(PHP_CodeSniffer_File $phpcsFile) {
		return $this->simpleParser->getClassNames($phpcsFile, array(T_CLASS, T_NEW, T_INSTANCEOF, T_EXTENDS));
	}

	private function formatOutput(array $classNames) {
		$fullClassNames = array_unique($classNames);
		$classes = array();

		foreach($fullClassNames as $fullClassName) {
			$classes[] = $this->classNameParser->parse($fullClassName);
		}

		return new ApprovedFood_Lib_ClassDefinitionList($classes);
	}

}

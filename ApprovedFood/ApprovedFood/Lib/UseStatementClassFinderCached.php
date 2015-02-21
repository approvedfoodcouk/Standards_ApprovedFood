<?php

class ApprovedFood_Lib_UseStatementClassFinderCached  {

	private $useStatementClassFinder;
	private $cachedResults;

	public function __construct(ApprovedFood_Lib_UseStatementClassFinder $useStatementClassFinder) {
		$this->useStatementClassFinder = $useStatementClassFinder;
		$this->cachedResults = array();
	}

	/**
	 * @return ApprovedFood_Lib_ClassInUseStatementList
	 */
	public function findClasses(PHP_CodeSniffer_File $phpcsFile) {
		$cacheKey = $phpcsFile->getFilename();

		if (!array_key_exists($cacheKey, $this->cachedResults)) {
			$this->cachedResults[$cacheKey] = $this->useStatementClassFinder->findClasses($phpcsFile);
		}

		return $this->cachedResults[$cacheKey];
	}

	public function buildClassNameFromUse(PHP_CodeSniffer_File $phpcsFile, $usePtr, $ns = false) {
		return $this->useStatementClassFinder->buildClassNameFromUse($phpcsFile, $usePtr, $ns);
	}

}

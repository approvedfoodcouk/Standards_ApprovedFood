<?php

class ApprovedFood_Lib_PhpDocsClassFinderCached  {

	private $phpDocsClassFinder;
	private $cachedResults;

	public function __construct(ApprovedFood_Lib_PhpDocsClassFinder $phpDocsClassFinder) {
		$this->phpDocsClassFinder = $phpDocsClassFinder;
		$this->cachedResults = array();
	}

	/**
	 * @return ApprovedFood_Lib_ClassDefinitionList
	 */
	public function findClasses(PHP_CodeSniffer_File $phpcsFile) {
		$cacheKey = $phpcsFile->getFilename();

		if (!array_key_exists($cacheKey, $this->cachedResults)) {
			$this->cachedResults[$cacheKey] = $this->phpDocsClassFinder->findClasses($phpcsFile);
		}

		return $this->cachedResults[$cacheKey];
	}

}

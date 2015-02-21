<?php

class ApprovedFood_Lib_ClassFinderCached  {

	private $classFinder;
	private $cachedResults1;
	private $cachedResults2;

	public function __construct(ApprovedFood_Lib_ClassFinder $classFinder) {
		$this->classFinder = $classFinder;
		$this->cachedResults1 = array();
		$this->cachedResults2 = array();
	}

	/**
	 * @return ApprovedFood_Lib_ClassDefinitionList
	 */
	public function findClasses(PHP_CodeSniffer_File $phpcsFile) {
		$cacheKey = $phpcsFile->getFilename();

		if (!array_key_exists($cacheKey, $this->cachedResults1)) {
			$this->cachedResults1[$cacheKey] = $this->classFinder->findClasses($phpcsFile);
		}

		return $this->cachedResults1[$cacheKey];
	}

	/**
	 * @return ApprovedFood_Lib_ClassDefinitionList
	 */
	public function findClassesIncludingFileClass(PHP_CodeSniffer_File $phpcsFile) {
		$cacheKey = $phpcsFile->getFilename();

		if (!array_key_exists($cacheKey, $this->cachedResults2)) {
			$this->cachedResults2[$cacheKey] = $this->classFinder->findClassesIncludingFileClass($phpcsFile);
		}

		return $this->cachedResults2[$cacheKey];
	}

}

<?php

class ApprovedFood_Lib_UseStatementClassFinder  {

	public function findClasses(PHP_CodeSniffer_File $phpcsFile) {
		$ptr = 0;

		$tokens = $phpcsFile->getTokens();
		$uses = array();
		while (true) {
			$use = $phpcsFile->findNext(array(T_USE), $ptr);
			if ($use === false) {
				break;
			}
			$ptr = $use + 1;
			$parenthesis = $phpcsFile->findNext(array(T_OPEN_PARENTHESIS), $use);
			if ($tokens[$use]['line'] === $tokens[$parenthesis]['line']) {
				continue; // use keyword from anonymous function
			}
			$uses[] = $use;
		}

		$classes = array();

		foreach ($uses as $usePtr) {
			$className = $this->buildClassNameFromUse($phpcsFile, $usePtr);

			if ($className) {
				$classes[] = $this->getClassObject($className, $usePtr);
			}
		}

		return new ApprovedFood_Lib_ClassInUseStatementList($classes);
	}

	private function getClassObject($fullClassname, $usePtr) {
		if (!preg_match('~^([\w\\\\]+\\\\)?([\w]+)(?: as ([\w\\\\]+))?$~', $fullClassname, $matches)) {
			throw new \Exception('Invalid class name: ' . $fullClassname);
		}

		$namespace = $matches[1] !== '' ? $matches[1] : null;
		$className = $matches[2];
		$as = isset($matches[3]) && $matches[3] !== '' ? $matches[3] : null;

		return new ApprovedFood_Lib_ClassInUseStatement($className, $namespace, $as, $usePtr);
	}

	public function buildClassNameFromUse(PHP_CodeSniffer_File $phpcsFile, $usePtr, $ns = false) {
		$tokens = $phpcsFile->getTokens();
		$semicolon = $phpcsFile->findNext(array(T_SEMICOLON), $usePtr);
		$firstString = $phpcsFile->findNext(array(T_STRING), $usePtr);

		if (!$semicolon || $tokens[$semicolon]['line'] !== $tokens[$usePtr]['line'] || !$firstString) {
			$phpcsFile->addError(sprintf('Invalid %s clausule.', $ns === true ? 'namespace' : 'use'), $usePtr);
			return null;
		}

		$class = '';

		for ($i = $firstString; $i < $semicolon; $i++) {
			$class .= $tokens[$i]['content'];
		}

		return $class;
	}

}

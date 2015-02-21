<?php

class ApprovedFood_Lib_ClassFinder_ImplementsParser {

	private $classNameComposerForward;

	public function __construct(ApprovedFood_Lib_ClassNameComposerForward $classNameComposerForward) {
		$this->classNameComposerForward = $classNameComposerForward;
	}

	public function getClassNames(PHP_CodeSniffer_File $phpcsFile) {
		$classNames = array();

		$implementsPtr = $phpcsFile->findNext(T_IMPLEMENTS, 0);

		if ($implementsPtr === false) {
			return array();
		}

		$endParenthsisPtr = $phpcsFile->findNext(T_OPEN_CURLY_BRACKET, $implementsPtr + 1);

		$start = $implementsPtr + 1;

		while ($firstStringAfterImplementsPtr = $phpcsFile->findNext(array(T_STRING, T_NS_SEPARATOR), $start, $endParenthsisPtr)) {
			$classNames[] = $this->classNameComposerForward->composeClassName($phpcsFile, $firstStringAfterImplementsPtr);

			$nextCommaPtr = $phpcsFile->findNext(T_COMMA, $firstStringAfterImplementsPtr, $endParenthsisPtr);

			if ($nextCommaPtr === false) {
				break;
			}

			$start = $nextCommaPtr + 1;
		}

		return $classNames;
	}

}

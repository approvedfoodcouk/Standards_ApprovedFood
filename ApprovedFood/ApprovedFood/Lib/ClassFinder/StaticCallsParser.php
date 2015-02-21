<?php

class ApprovedFood_Lib_ClassFinder_StaticCallsParser {

	private $classNameComposerBackward;

	public function __construct(ApprovedFood_Lib_ClassNameComposerBackward $classNameComposerBackward) {
		$this->classNameComposerBackward = $classNameComposerBackward;
	}

	public function getClassNames(PHP_CodeSniffer_File $phpcsFile) {
		$start = 0;
		$classNames = array();

		while ($ptr = $phpcsFile->findNext(T_DOUBLE_COLON, $start)) {
			$classNames[] = $this->classNameComposerBackward->composeClassName($phpcsFile, $ptr);

			$start = $ptr + 1;
		}

		return $classNames;
	}

}

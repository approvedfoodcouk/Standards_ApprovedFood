<?php

class ApprovedFood_Lib_Namespace_SeparatorDetector {

	public function isFirstNamespaceSeparator(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
		$currentStackPtr = $stackPtr;
		$tokens = $phpcsFile->getTokens();

		do {
			$currentStackPtr--;

			$tokenType = $tokens[$currentStackPtr]['type'];

			if ($tokenType === 'T_NS_SEPARATOR') {
				return false;
			}
			else if ($tokenType === 'T_WHITESPACE') {
				return true;
			}
		}
		while (true);
	}

}

<?php

class ApprovedFood_Lib_ClassFinder_TypeHintingParser {

	private $classNameComposerForward;

	public function __construct(ApprovedFood_Lib_ClassNameComposerForward $classNameComposerForward) {
		$this->classNameComposerForward = $classNameComposerForward;
	}

	public function getClassNames(PHP_CodeSniffer_File $phpcsFile) {
		$start = 0;
		$tokens = $phpcsFile->getTokens();
		$classNames = array();

		while ($ptr = $phpcsFile->findNext(T_OPEN_PARENTHESIS, $start)) {
			$endParenthsisPtr = $phpcsFile->findNext(T_CLOSE_PARENTHESIS, $ptr + 1);

			$subWhileStart = $ptr + 1;

			while ($firstStringAfterParenthisisPtr = $phpcsFile->findNext(array(T_STRING, T_NS_SEPARATOR), $subWhileStart, $endParenthsisPtr)) {
				$tokenContent = $tokens[$firstStringAfterParenthisisPtr]['content'];
				$tokenType = $tokens[$firstStringAfterParenthisisPtr]['type'];

				if ($tokenType === 'T_NS_SEPARATOR' || ($tokenType === 'T_STRING' && preg_match('~^[A-Z]+~', $tokenContent))) {
					$classNames[] = $this->classNameComposerForward->composeClassName($phpcsFile, $firstStringAfterParenthisisPtr);
				}

				$nextCommaPos = $phpcsFile->findNext(T_COMMA, $firstStringAfterParenthisisPtr, $endParenthsisPtr);

				if ($nextCommaPos === false) {
					break;
				}

				$subWhileStart = $nextCommaPos + 1;
			}

			$start = $ptr + 1;
		}

		return $classNames;
	}

}

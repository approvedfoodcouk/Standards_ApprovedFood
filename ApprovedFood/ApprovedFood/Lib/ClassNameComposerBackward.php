<?php

class ApprovedFood_Lib_ClassNameComposerBackward {

	public function composeClassName(PHP_CodeSniffer_File $phpcsFile, $startPtr) {
		$tokens = $phpcsFile->getTokens();
		$classNameEndPtr = $phpcsFile->findPrevious(array(T_STRING, T_NS_SEPARATOR), $startPtr - 1, null, true);
		$className = '';

		for ($i = $classNameEndPtr + 1; $i < $startPtr; $i++) {
			$className .= $tokens[$i]['content'];
		}

		return $className;
	}

}

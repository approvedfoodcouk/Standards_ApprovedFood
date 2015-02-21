<?php

class ApprovedFood_Lib_ClassNameParser  {

	public function parse($fullClassName) {
		$lastSlashPosition = strrpos($fullClassName, '\\');

		if ($lastSlashPosition !== false) {
			$className = substr($fullClassName, $lastSlashPosition + 1);
			$namespace = substr($fullClassName, 0, $lastSlashPosition + 1);

			return new ApprovedFood_Lib_ClassDefinition($className, $namespace !== '' ? $namespace : null);
		}
		else {
			return new ApprovedFood_Lib_ClassDefinition($fullClassName, null);
		}
	}

}

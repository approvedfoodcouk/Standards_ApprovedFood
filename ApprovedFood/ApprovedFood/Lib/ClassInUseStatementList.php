<?php

class ApprovedFood_Lib_ClassInUseStatementList {

	/** @var ApprovedFood_Lib_ClassInUseStatement[] */
	protected $classes;

	public function __construct($classes = array()) {
		$this->classes = $classes;
	}

	/**
	 * @return ApprovedFood_Lib_ClassInUseStatement[]
	 */
	public function getIndexedByUsePtr() {
		$classesInUsesIndexedByUsePtr = array();

		foreach ($this->classes as $class) {
			$classesInUsesIndexedByUsePtr[$class->getUsePtr()] = $class;
		}

		return $classesInUsesIndexedByUsePtr;
	}

	public function getFullClassNames() {
		$classNames = array();

		foreach ($this->classes as $class) {
			$classNames[] = $class->getFullClassName();
		}

		return $classNames;
	}

	/**
	 * @return ApprovedFood_Lib_ClassInUseStatement[]
	 */
	public function getClasses() {
		return $this->classes;
	}

}

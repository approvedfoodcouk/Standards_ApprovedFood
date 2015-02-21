<?php

class ApprovedFood_Lib_ClassDefinitionList  {

	private $classes;

	/**
	 * @param ApprovedFood_Lib_ClassDefinition[] $classes
	 */
	public function __construct($classes = array()) {
		$this->classes = $classes;
	}

	public function containsClass($searchClass) {
		foreach ($this->classes as $class) {
			if ($class->getName() === $searchClass) {
				return $class;
			}
		}

		return false;
	}

	public function containsClassWithNamespace($searchClass) {
		foreach ($this->classes as $class) {
			if ($class->getFullClassName() === $searchClass) {
				return $class;
			}
		}

		return false;
	}

	public function findClassSameNameDifferentNamespace($searchClass, $namespace) {
		foreach ($this->classes as $class) {
			if ($class->getName() === $searchClass && $class->getNamespace() !== $namespace) {
				return $class;
			}
		}

		return false;
	}

	public function getClasses() {
		return $this->classes;
	}

}

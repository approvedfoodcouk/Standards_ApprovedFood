<?php

class ApprovedFood_Lib_ClassDefinition  {

	private $name;
	private $namespace;

	public function __construct($name, $namespace) {
		$this->name = $name;
		$this->namespace = $namespace;
	}

	public function getName() {
		return $this->name;
	}

	public function getFullClassName() {
		if ($this->namespace) {
			return $this->namespace . $this->name;
		}
		else {
			return $this->name;
		}
	}

	public function getNamespace() {
		return $this->namespace;
	}

}

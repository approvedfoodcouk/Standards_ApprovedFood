<?php

class ApprovedFood_Lib_ClassInUseStatement  {

	private $name;
	private $namespace;
	private $as;
	private $usePtr;

	public function __construct($name, $namespace, $as, $usePtr) {
		$this->name = $name;
		$this->namespace = $namespace;
		$this->as = $as;
		$this->usePtr = $usePtr;
	}

	public function getAs() {
		return $this->as;
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

	public function getUsePtr() {
		return $this->usePtr;
	}

	public function getNameOrAs() {
		return $this->as ? $this->as : $this->name;
	}

	public function getFullClassNmeOrAs() {
		return $this->as ? $this->as : $this->getFullClassName();
	}

}

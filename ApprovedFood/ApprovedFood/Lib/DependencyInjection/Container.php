<?php

class ApprovedFood_Lib_DependencyInjection_Container {

	private static $services = array();

	/**
	 * @return ApprovedFood_Lib_AllClassFinder
	 */
	public static function getAllClassFinder() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_AllClassFinder(
					ApprovedFood_Lib_DependencyInjection_Container::getPhpDocsClassFinderCached(),
					ApprovedFood_Lib_DependencyInjection_Container::getClassFinderCached()
				);
			}
		);
	}

	/**
	 * @return ApprovedFood_Lib_ClassFinder
	 */
	public static function getClassFinder() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_ClassFinder(
					ApprovedFood_Lib_DependencyInjection_Container::getClassNameParser(),
					ApprovedFood_Lib_DependencyInjection_Container::getClassFinder_ImplementsParser(),
					ApprovedFood_Lib_DependencyInjection_Container::getClassFinder_StaticCallsParser(),
					ApprovedFood_Lib_DependencyInjection_Container::getClassFinder_TypeHintingParser(),
					ApprovedFood_Lib_DependencyInjection_Container::getClassFinder_SimpleParser()
				);
			}
		);
	}

	/**
	 * @return ApprovedFood_Lib_ClassFinderCached
	 */
	public static function getClassFinderCached() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_ClassFinderCached(
					ApprovedFood_Lib_DependencyInjection_Container::getClassFinder()
				);
			}
		);
	}

	/**
	 * @return ApprovedFood_Lib_ClassFinder_ImplementsParser
	 */
	public static function getClassFinder_ImplementsParser() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_ClassFinder_ImplementsParser(
					ApprovedFood_Lib_DependencyInjection_Container::getClassNameComposerForward()
				);
			}
		);
	}

	/**
	 * @return ApprovedFood_Lib_ClassFinder_SimpleParser
	 */
	public static function getClassFinder_SimpleParser() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_ClassFinder_SimpleParser(
					ApprovedFood_Lib_DependencyInjection_Container::getClassNameComposerForward()
				);
			}
		);
	}

	/**
	 * @return ApprovedFood_Lib_ClassFinder_StaticCallsParser
	 */
	public static function getClassFinder_StaticCallsParser() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_ClassFinder_StaticCallsParser(
					ApprovedFood_Lib_DependencyInjection_Container::getClassNameComposerBackward()
				);
			}
		);
	}

	/**
	 * @return ApprovedFood_Lib_ClassFinder_TypeHintingParser
	 */
	public static function getClassFinder_TypeHintingParser() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_ClassFinder_TypeHintingParser(
					ApprovedFood_Lib_DependencyInjection_Container::getClassNameComposerForward()
				);
			}
		);
	}

	/**
	 * @return ApprovedFood_Lib_ClassInPhpDocsFinder
	 */
	public static function getClassInPhpDocsFinder() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_ClassInPhpDocsFinder();
			}
		);
	}

	/**
	 * @return ApprovedFood_Lib_ClassNameComposerBackward
	 */
	public static function getClassNameComposerBackward() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_ClassNameComposerBackward();
			}
		);
	}

	/**
	 * @return ApprovedFood_Lib_ClassNameComposerForward
	 */
	public static function getClassNameComposerForward() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_ClassNameComposerForward();
			}
		);
	}

	/**
	 * @return ApprovedFood_Lib_ClassNameParser
	 */
	public static function getClassNameParser() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_ClassNameParser();
			}
		);
	}

	/**
	 * @return ApprovedFood_Lib_Namespace_SeparatorDetector
	 */
	public static function getNamespaceSeparatorDetector() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_Namespace_SeparatorDetector();
			}
		);
	}

	/**
	 * @return ApprovedFood_Lib_PhpDocsClassFinder
	 */
	public static function getPhpDocsClassFinder() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_PhpDocsClassFinder(
					ApprovedFood_Lib_DependencyInjection_Container::getClassNameParser(),
					ApprovedFood_Lib_DependencyInjection_Container::getClassInPhpDocsFinder()
				);
			}
		);
	}

	/**
	 * @return ApprovedFood_Lib_PhpDocsClassFinderCached
	 */
	public static function getPhpDocsClassFinderCached() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_PhpDocsClassFinderCached(
					ApprovedFood_Lib_DependencyInjection_Container::getPhpDocsClassFinder()
				);
			}
		);
	}

	/**
	 * @return ApprovedFood_Lib_UseStatementClassFinder
	 */
	public static function getUseStatementClassFinder() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_UseStatementClassFinder();
			}
		);
	}

	/**
	 * @return ApprovedFood_Lib_UseStatementClassFinderCached
	 */
	public static function getUseStatementClassFinderCached() {
		return ApprovedFood_Lib_DependencyInjection_Container::getService(
			__FUNCTION__,
			function() {
				return new ApprovedFood_Lib_UseStatementClassFinderCached(
					ApprovedFood_Lib_DependencyInjection_Container::getUseStatementClassFinder()
				);
			}
		);
	}

	private static function getService($name, Closure $createInstanceCallback) {
		if (!array_key_exists($name, ApprovedFood_Lib_DependencyInjection_Container::$services)) {
			ApprovedFood_Lib_DependencyInjection_Container::$services[$name] = $createInstanceCallback();
		}

		return ApprovedFood_Lib_DependencyInjection_Container::$services[$name];
	}

}

<?php

/**
 * ownCloud - Music app
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Pauli Järvinen <pauli.jarvinen@gmail.com>
 * @copyright Pauli Järvinen 2020
 */

namespace OCA\Music\Utility;

/**
 * Utility functions to be used from the front-end templates
 */
class HtmlUtil {

	/**
	 * Sanitized printing
	 * @param string $string
	 */
	public static function p($string) {
		print(/** @scrutinizer ignore-type */ \OCP\Util::sanitizeHTML($string));
	}

	/**
	 * Print path to a icon of the Music app
	 * @param string $iconName Name of the icon without path or the '.svg' suffix
	 */
	public static function printSvgPath($iconName) {
		print(\OCP\Template::image_path('music', $iconName.'.svg'));
	}

	/**
	 * Print AngularJS template whose contents can be found under templates/partials
	 * @param string $templateName
	 */
	public static function printNgTemplate($templateName) {
		print(
			'<script type="text/ng-template" id="'.$templateName.'.html">' .
				self::partialContent($templateName) .
			'</script>'
		);
	}

	/**
	 * Print a partial template
	 * @param string $partialName Name of the file under templates/partials without the '.php' suffix
	 */
	public static function printPartial($partialName) {
		print(self::partialContent($partialName));
	}

	/**
	 * @param string $partialName
	 */
	private static function partialContent($partialName) {
		$fileName = \join(DIRECTORY_SEPARATOR, [\dirname(__DIR__), 'templates', 'partials', $partialName.'.php']);

		\ob_start();
		try {
			include $fileName;
			$data = \ob_get_contents();
		} catch (\Exception $e) {
			\ob_end_clean();
			throw $e;
		}
		\ob_end_clean();

		return $data;
	}
}

<?php
/**
 * µ Functions plugin for Craft CMS 3.x
 *
 * Functions developed for UNDiario
 *
 * @link      https://cballenar.me
 * @copyright Copyright (c) 2018 Carlos Ballena
 */

namespace undiario\u\twigextensions;

use undiario\u\Functions;

use Craft;

/**
 * Twig can be extended in many ways; you can add extra tags, filters, tests, operators,
 * global variables, and functions. You can even extend the parser itself with
 * node visitors.
 *
 * http://twig.sensiolabs.org/doc/advanced.html
 *
 * @author    Carlos Ballena
 * @package   Functions
 * @since     2.0.0
 */
class FunctionsTwigExtension extends \Twig_Extension
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'Functions';
    }

    /**
     * Returns an array of Twig filters, used in Twig templates via:
     *
     *      {{ 'something' | someFilter }}
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('someFilter', [$this, 'camelToScored', 'scoredToCamel']),
        ];
    }

    /**
     * Returns an array of Twig functions, used in Twig templates via:
     *
     *      {% set this = someFunction('something') %}
     *
     * @return array
     *
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('someFunction', [$this, 'camelToScored', 'scoredToCamel']),
        ];
    }*/

    /**
     * Camelcase string to scored
     * As seen in http://stackoverflow.com/questions/1993721/how-to-convert-camelcase-to-camel-case
     *
     * @param null $input
     *
     * @return string
     */
    public function camelToScored($input = null){
        preg_match_all('([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)', $input, $matches);
        $result = $matches[0];
        foreach ($result as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('-', $result);
    }

    /**
     * Scored string to camelcase
     * As seen in http://stackoverflow.com/questions/2791998/convert-dashes-to-camelcase-in-php
     *
     * @param null $input
     *
     * @return string
     */
    public function scoredToCamel($input = null){
        $result = str_replace(' ', '', ucwords(str_replace('-', ' ', $input)));
        $result[0] = strtolower($result[0]);
        return $result;
    }
}

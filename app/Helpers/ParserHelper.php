<?php

namespace App\Helpers;

use \DOMDocument;
use \DOMXPath;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Component\CssSelector\CssSelectorConverter;

/**
 * Класс-помощник парсера web-страниц
 *
 * @author Sergey Vedernikov <ved8ser@ya.ru>
 */
class ParserHelper
{
    /**
     * Сопоставление названия аттрибутов html-тэгов
     * их обозначениям в правилах css-выборки
     *
     * @var array
     */
    const HTML_ATTRIBUTES_FOR_CSS_SELECTOR = [
        'class' => '.',
        'id' => '#'
    ];

    /**
     * Возвращает результат работы парсера
     *
     * @param string $url
     * @param string $cssSelector
     * @return mixed
     */
    public function parse(string $url, string $cssSelector)
    {
        $src = $this->getPageSourceByUrl($url);
        $src = $this->parseDom($src, $cssSelector);
        $src = strip_tags($src, '<h1><h2><h3><h4><p><table><tr><td>');
        return $src;
    }

    /**
     * Возвращает ссылку из строки
     * 
     * @param string $string = ''
     * @return string
     */
    public function getUrlFromString(string $string='')
    {
        $pattern = "#https?://\w+(-|\.|/\w+)*\.\w+[[:graph:]]*#i";
        preg_match($pattern, $string, $matches);
        if (empty($matches)) {
            return '';
        } else {
            return $matches[0];
        };
    }

    /**
     * Возвращает список [название аттрибута]="[значение аттрибута]"
     *
     * @param string $string=''
     * @return array
     */
    public function getAttrValueListFromString(string $string='')
    {
        $pattern = '#\w+="\w+"#i';
        preg_match_all($pattern, $string, $matches);
        return $matches[0];
    }

    /**
     * Возвращает строку css-выборки из массива,
     * в коротом элементы имеют вид [название аттрибута]="[значение аттрибута]"
     *
     * @param array $keyValueList=[]
     * @return string
     */
    public function getCssSelectorStringFromAttrValueList(array $attrValueList)
    {
        $attributes = self::HTML_ATTRIBUTES_FOR_CSS_SELECTOR;
        $selectorItems = [];
        foreach ($attrValueList as $attrValue) {
            $attrValue = explode('=', $attrValue);
            $attrName = $attrValue[0];
            $allowAttrNameList = array_keys($attributes);
            if ( in_array($attrName, $allowAttrNameList) ) {
                $attrValue = trim($attrValue[1], '"');
                if (strlen($attrValue)) {
                    $selectorItems[] = $attributes[$attrName] . $attrValue;
                }
            }
        }

        return implode(' ', $selectorItems);
    }

    /**
     * Возвращает строку css-выборки из строки,
     * в коротом элементы имеют вид [название аттрибута]="[значение аттрибута]"
     *
     * @param array $keyValueList=[]
     * @return string
     */
    public function getCssSelectorStringFromString(string $string)
    {
        $list = $this->getAttrValueListFromString($string);
        return $this->getCssSelectorStringFromAttrValueList($list);
    }

    /**
     * Возвращает содержимое web-страницы по ссылке
     *
     * @param string $url
     * @param string $cssSelector
     * @return string
     */
    public function getPageSourceByUrl(string $url)
    {
        $client = new Client();
        try {
            $response = $client->get($url);
            $code = $response->getStatusCode();
        } catch ( \GuzzleHttp\Exception\ConnectException $e ) {
            $code = -1;
        }
        if ($code == 200) {
            $body = $response->getBody();
            $src = $body->getContents();
            return $src;
        } else {
            return '';
        }
    }

    /**
     * Возвращает отфильтрованный DOM
     *
     * @param string $src
     * @param string $cssSelector
     * @return mixed
     */
    public function parseDom(string $src, string $cssSelector)
    {
        $result = '';
        $isValideCssSelector = $this->isValideCssSelector($cssSelector);
        if ($isValideCssSelector) {
            $domDoc = new DOMDocument();
            $domDoc->loadHTML($src, LIBXML_NOERROR);
            $xpathExpr = $this->convertCssToXPath($cssSelector);
            $xpath = new DOMXPath($domDoc);
            $nodes = $xpath->query($xpathExpr);
            $src = [];
            foreach ($nodes as $node) {
                $src[] = $node->C14N();
            }
            $src = implode('', $src);

            return $src;
        }
        return $result;
    }

    /**
     * Возвращает сгенерированную строку шаблона регулярного выражения
     * для проверки проверки правила css-выборки
     *
     * @return string
     */
    private function getPatternForValidateCssSelector()
    {
        $attributes = self::HTML_ATTRIBUTES_FOR_CSS_SELECTOR;
        foreach ($attributes as $key => $value) {
            if ( in_array($value, ['.']) ) {
                $attributes[$key] = "\\$value";
            }
        }
        $attrPrefix=implode('|', $attributes);
        $pattern = "/($attrPrefix)\w+( ($attrPrefix)\w+)*/";
        return $pattern;
    }

    /**
     * Проверка правила выборки css-выборки
     *
     * @param string $cssSelector
     * @return bollean
     */
    private function isValideCssSelector(string $cssSelector='')
    {
        $pattern = $this->getPatternForValidateCssSelector();
        return boolval(preg_match($pattern, $cssSelector));
    }

    /**
     * Конвертирует правило css-выборки в XPath
     *
     * @param string $cssSelector
     */
    private function convertCssToXPath(string $cssSelector)
    {
        $converter = new CssSelectorConverter();
        return $converter->toXPath($cssSelector);
    }
}
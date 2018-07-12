<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ParserHelper;

class ParserApiController extends Controller
{
  /**
   * Экремпляр помощника парсера
   *
   * @var App\Helpers\ParserHelper
   */
  protected $parserHelper;

  public function __construct(ParserHelper $parserHelper)
  {
    $this->parserHelper = $parserHelper;
  }
  
  /**
   * Процесс парсинга
   */
  public function parse(Request $request)
  {
    $request->validate([
      's' => [
        'required',
        'haveUrl',
        'haveKeyValue',
      ]
    ]);

    $_s   = $request->s;
    $_url = $this->parserHelper->getUrlFromString($_s);
    $_cssSelector = $this->parserHelper->getCssSelectorStringFromString($_s);
    $_content = $this->parserHelper->parse($_url, $_cssSelector);

    return [
      's' => implode(' ', [$_url, $_cssSelector]),
      'html' => $_content,
    ];
  }
}

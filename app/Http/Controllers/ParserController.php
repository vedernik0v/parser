<?php

namespace App\Http\Controllers;

use App\Helpers\ParserHelper;
use Illuminate\Http\Request;

class ParserController extends Controller
{
    protected $parserHelper;
    protected $viewData;

    public function __construct(ParserHelper $parserHelper)
    {
        $this->parserHelper = $parserHelper;
        $this->viewData = [];
    }

    public function parse(Request $request)
    {
        $_s   = $request->s;
        $_url = $this->parserHelper->getUrlFromString($_s);
        $_cssSelector = $this->parserHelper->getCssSelectorStringFromString($_s);
        $_content = $this->parserHelper->parse($_url, $_cssSelector);

        $this->viewData = [
            's'   => $_s,
            'url' => $_url,
            'cssSelector' => $_cssSelector,
            'content' => $_content,
        ];

        return view('parser', $this->viewData);
    }
}

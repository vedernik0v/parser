<?php

namespace App\Http\Controllers;

use App\Helpers\ParserHelper;
use App\Http\Requests;
use Illuminate\Http\Request;

class ParserController extends Controller
{
    /**
     * Экремпляр помощника парсера
     *
     * @var App\Helpers\ParserHelper
     */
    protected $parserHelper;

    /**
     * Список переменных представления
     *
     * @var Array
     */
    protected $viewData;

    /**
     * Инициализация контроллера
     */
    public function __construct(ParserHelper $parserHelper)
    {
        $this->parserHelper = $parserHelper;
        $this->viewData = [
            's' => '',
            'url' => '',
            'cssSelector' => '',
            'content' => '',
        ];
    }

    /**
     * Ввод
     *
     * @param Requests $request
     * @return Respose
     */
    public function index(Request $request)
    {
        $this->getViewDataFromFlash();
        return view('parser', $this->viewData);
    }

    /**
     * Процесс парсинга
     */
    public function parse(\App\Http\Requests\ParserParse $request)
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

        $this->flashViewData($request);

        return view('parser', $this->viewData);
    }

    /**
     * Сохраняет переменные представления для следующего запроса
     *
     * @param Illuminate\Http\Request $request
     */
    private function flashViewData($request)
    {
        foreach ($this->viewData as $key => $value) {
            $request->flash($key, $value);
        }
    }

    /**
     * Возвращает переменные представления из 
     *
     * @param Illuminate\Http\Request $request
     */
    private function getViewDataFromFlash()
    {
        foreach ($this->viewData as $key => $value) {
            $this->viewData[$key] = session($key, $value);
        }
    }
}

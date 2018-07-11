<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ParserHelper;

class ParserApiController extends Controller
{
  /**
   * Процесс парсинга
   */
  public function parse(Request $request)
  {
    $validatedData = $request->validate([
      's' => [
        'required',
        'haveUrl',
        'haveKeyValue',
      ]
    ]);

    dd($validatedData);
  }
}

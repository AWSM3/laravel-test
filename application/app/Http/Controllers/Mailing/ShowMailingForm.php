<?php
declare(strict_types=1);

/** @namespace */
namespace App\Http\Controllers\Mailing;

/** @uses */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class ShowMailingForm
 * @package App\Http\Controllers\Mailing
 */
class ShowMailingForm extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Request $request
     *
     * @return View
     */
    public function __invoke(Request $request): View
    {
        return view('mailing.form');
    }
}

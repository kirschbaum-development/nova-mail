<?php

namespace KirschbaumDevelopment\NovaMail\Http\Controllers;

use Illuminate\Routing\Controller;
use KirschbaumDevelopment\NovaMail\Models\MailTemplate;

class TemplatesController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'templates' => MailTemplate::all(),
        ]);
    }
}

<?php

namespace KirschbaumDevelopment\NovaMail\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use KirschbaumDevelopment\NovaMail\Models\NovaSentMail;

class SentMailController extends Controller
{
    public function __invoke(Request $request, NovaSentMail $mail)
    {
        return response()->json([
            'mail' => $mail,
        ]);
    }
}

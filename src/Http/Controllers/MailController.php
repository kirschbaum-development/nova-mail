<?php

namespace KirschbaumDevelopment\NovaMail\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use KirschbaumDevelopment\NovaMail\Models\Mail;

class MailController extends Controller
{
    public function __invoke(Request $request, Mail $mail)
    {
        return response()->json([
            'mail' => $mail,
        ]);
    }
}

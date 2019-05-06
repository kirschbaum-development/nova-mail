<?php

namespace KirschbaumDevelopment\NovaMail\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use KirschbaumDevelopment\NovaMail\Mail\SendMail;
use KirschbaumDevelopment\NovaMail\Models\MailTemplate;

class SendMailController extends Controller
{
    public function __invoke(Request $request, ?MailTemplate $mailTemplate)
    {
        $model = $request->model::findOrFail($request->resourceId);
        $mailable = new SendMail($model, $mailTemplate, $request->content, $request->from, $request->subject);
        $mailable->deliver();

        return response()->json([
            'success' => true,
        ]);
    }
}

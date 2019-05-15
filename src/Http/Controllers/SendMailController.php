<?php

namespace KirschbaumDevelopment\NovaMail\Http\Controllers;

use Illuminate\Routing\Controller;
use KirschbaumDevelopment\NovaMail\Mail\SendMail;
use KirschbaumDevelopment\NovaMail\Models\NovaMailTemplate;
use KirschbaumDevelopment\NovaMail\Http\Requests\SendMailRequest;

class SendMailController extends Controller
{
    public function __invoke(SendMailRequest $request, ?NovaMailTemplate $mailTemplate)
    {
        $model = $request->model::findOrFail($request->resourceId);
        $mailable = new SendMail($model, $mailTemplate, $request->content, $request->to, $request->from, $request->subject);
        $mailable->deliver();

        return response()->json([
            'success' => true,
        ]);
    }
}

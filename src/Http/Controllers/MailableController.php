<?php

namespace KirschbaumDevelopment\NovaMail\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MailableController extends Controller
{
    public function __invoke(Request $request)
    {
        $model = $request->mailableClass::find($request->mailableId);

        return response()->json([
            'model' => $model,
            'to' => $model->{$model->getEmailField()},
        ]);
    }
}

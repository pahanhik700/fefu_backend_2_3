<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Sanitizers\PhoneSanitize;
use Illuminate\Http\Request;
use function Symfony\Component\String\s;
use App\Http\Requests\AppealPostRequest;

class AppealController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('appeal');
    }
    public function save(AppealPostRequest $request)
    {
        $validated = $request->validate(
            AppealPostRequest::rules()
        );

        $appeal = new Appeal();
        $appeal->surname = $validated['surname'];
        $appeal->name = $validated['name'];
        $appeal->patronymic = $validated['patronymic'];
        $appeal->age = $validated['age'];
        $appeal->gender = $validated['gender'];
        $appeal->phone = PhoneSanitize::sanitize($validated['phone']);
        $appeal->email = $validated['email'];
        $appeal->message = $validated['message'];
        $appeal->save();

        return redirect()
            ->route('appeal')
            ->with('success', 'Appeal created');
    }
}

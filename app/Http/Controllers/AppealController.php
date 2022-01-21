<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use Illuminate\Http\Request;

class AppealController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $errors = [];
        $success = $request->session()->get('success', false);
        if ($request->input('name')) {
            $name = $request->input('name');
            $message = $request->input('message');
            $mail = $request->input('mail');
            $phone = $request->input('phone');
            if ($name === null)
                $errors['name'] = 'Name is empty';
            if ($message === null)
                $errors['message'] = 'Message is empty';
            if ($mail === null)
                $errors['mail'] = 'Mail is empty';
            if ($phone === null)
                $errors['phone'] = 'Phone is empty';
            if ($phone === null && $mail === null)
            {
                $errors['mail'] = 'E-mail and phone number is empty';
            }
            if (count($errors) > 0)
            {
                $request->flash();
            }
            else
            {
                $appeal = new Appeal();
                $appeal->name = $name;
                $appeal->message = $message;
                $appeal->save();

                $success = true;

                return redirect()
                    ->route('appeal')
                    ->with('success', $success);
            }
        }
        return view('appeal', ['errors' => $errors, 'success' => $success]);
    }
}

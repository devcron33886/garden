<?php

namespace App\Http\Controllers;

use App\Jobs\EmailSubscription;
use App\Mail\Subscribed;
use App\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{

    public function index()
    {
        $newsletters = Newsletter::all();
        return view('admins.newsletters', compact('newsletters'));
    }

    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'email' => 'required'
        ]);

        $model = Newsletter::query()->updateOrCreate([
            'email' => $request->input('email')
        ]);

        // send email for thanking them.
        $text = 'Thank you for subscribing with us, we will notify you for Any product we publish on our site';
        $email = \request('email');
        EmailSubscription::dispatch($email, $text);

        session()->put('success', 'Thank you for subscribing with us!');
        if ($request->wantsJson())
            return $model;
        return redirect()->back();
    }

    public function unsubscribe($email)
    {
        Newsletter::query()->where('email', '=', $email)->delete();
        session()->flash('message', 'Thank you! you can subscribe again anytime');
        return redirect()->route('home');
    }
}

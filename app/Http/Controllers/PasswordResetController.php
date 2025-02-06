<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use HTTP_Request2;
use HTTP_Request2_Exception;

class PasswordResetController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with(['status' => __($status)]);
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function sendResetLinkEmailWithInfobip(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            $this->sendEmailWithInfobip($request->email, $status);
            return back()->with(['status' => 'Password reset link sent!']);
        }

        return back()->withErrors(['email' => 'Unable to send reset link.']);
    }

    private function sendEmailWithInfobip($email, $token)
    {
        $resetLink = url('/reset-password?token=' . $token);

        $request = new HTTP_Request2();
        $request->setUrl('https://api.infobip.com/email/3/send');
        $request->setMethod(HTTP_Request2::METHOD_POST);
        $request->setConfig(array(
            'follow_redirects' => TRUE
        ));
        $request->setHeader(array(
            'Authorization' => 'App ' . env('INFOBIP_API_KEY'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ));
        $request->setBody(json_encode([
            'from' => 'sanangdarel17@gmail.com',
            'to' => $email,
            'subject' => 'Password Reset Request',
            'text' => 'Click the following link to reset your password: ' . $resetLink,
        ]));

        try {
            $response = $request->send();
            if ($response->getStatus() == 200) {
                Log::info('Password reset email sent successfully: ' . $response->getBody());
            } else {
                Log::error('Failed to send password reset email: ' . $response->getStatus() . ' ' . $response->getReasonPhrase());
            }
        } catch (HTTP_Request2_Exception $e) {
            Log::error('Error: ' . $e->getMessage());
        }
    }
}
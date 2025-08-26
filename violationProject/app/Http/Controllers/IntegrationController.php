<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('login'); // resources/views/login.blade.php
    }

    /**
     * Handle login request for students and faculty
     */
    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|in:student,faculty', // Role must be selected
        ]);

        $API_KEY = "pup_JwwWjDvb5PRYWcOEBBuNBJWltRAcu9VQ_1756134718"; 
        $baseURL = "https://pupt-registration.site";
        $URI = "/api/auth/login";

        $client = new Client(['base_uri' => $baseURL]);

        try {
            $response = $client->post($URI, [
                'json' => [
                    'email' => $request->email,
                    'password' => $request->password,
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-API-Key' => $API_KEY,
                ],
            ]);

            $body = json_decode($response->getBody()->getContents());

            if (!isset($body->token)) {
                return back()->withErrors(['email' => 'Login failed. Check your credentials.']);
            }

            // Store login info in session
            session([
                'user_email' => $request->email,
                'user_token' => $body->token,
                'user_name'  => $body->first_name ?? '',
                'user_role'  => $request->role,
            ]);

            // Redirect based on role
            if ($request->role === 'student') {
                return redirect()->route('student.violations.index');
            } elseif ($request->role === 'faculty') {
                return redirect()->route('faculty.violations.index');
            }

        } catch (ClientException $e) {
            return back()->withErrors(['email' => 'Invalid credentials or API error.']);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Something went wrong. Try again later.']);
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
}

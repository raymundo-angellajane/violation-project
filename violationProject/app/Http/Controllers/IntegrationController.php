<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class IntegrationController extends Controller
{
    private $baseURL = "https://pupt-registration.site";
    private $API_KEY = "pup_JwwWjDvb5PRYWcOEBBuNBJWltRAcu9VQ_1756134718";

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function loginUser(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $client = new Client(['base_uri' => $this->baseURL]);

        try {
            $response = $client->post('/api/auth/login', [
                'json' => [
                    'email'    => $request->email,
                    'password' => $request->password,
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-API-Key'    => $this->API_KEY,
                ]
            ]);

            $body = json_decode($response->getBody(), true);

            if (isset($body['success']) && $body['success'] === true) {
                $data = $body['data'];
                $user = $data['user'];

                // Save details to session
                session([
                    'user_id'    => $user['id'] ?? null,
                    'user_email' => $user['email'] ?? null,
                    'user_name'  => ($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''),
                    'user_role'  => strtolower($user['role'] ?? $request->role),
                    'api_token'  => $data['session_token'] ?? null,
                ]);

                // Redirect based on role
                if (strtolower($user['role']) === 'faculty') {
                    return redirect()->route('faculty.violations.index')
                                     ->with('success', 'Welcome Faculty ' . ($user['first_name'] ?? '') . '!');
                } else {
                    return redirect()->route('student.violations.index')
                                     ->with('success', 'Welcome Student ' . ($user['first_name'] ?? '') . '!');
                }
            }

            return back()->withErrors([
                'login' => 'Invalid credentials. Please try again.',
            ]);

        } catch (ClientException $e) {
            return back()->withErrors([
                'login' => 'Login failed. Please check your credentials.',
                'error_detail' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}

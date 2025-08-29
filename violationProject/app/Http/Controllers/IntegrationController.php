<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Models\Student;
use App\Models\Faculty;

class IntegrationController extends Controller
{
    private string $baseURL = "https://pupt-registration.site";
    private string $API_KEY = "pup_JwwWjDvb5PRYWcOEBBuNBJWltRAcu9VQ_1756134718";

    public function showLoginForm() // para magpakita naman to ng login form ni faculty/student
    {
        return view('auth.login');
    }

    public function loginUser(Request $request) // para maglogin naman to ng faculty/student
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $client = new Client(['base_uri' => $this->baseURL]); // si guzzle client, yan yung ginagamit para magrequest sa external API 

        try { // this is to ano kung may error sa pagrequest sa external API
            $response = $client->post('/api/auth/login', [
                'json' => [ // yung body ng request
                    'email'    => $request->email,
                    'password' => $request->password,
                ],
                'headers' => [
                    'Content-Type' => 'application/json', // type ng content na pinapadala
                    'X-API-Key'    => $this->API_KEY, // yung API key na binigay sa atin ng external API
                ]
            ]);

            $body = json_decode($response->getBody(), true); // para ma-decode yung response body na galing sa external API

            if (isset($body['success']) && $body['success'] === true) {
                $data = $body['data'];
                $user = $data['user'];

                $role = strtolower($user['role'] ?? ''); // to lowercase yung role para consistent
                if ($role === 'students') $role = 'student';
                if ($role === 'faculties') $role = 'faculty';

                $student = null; // initialize student and faculty variables into null
                $faculty = null;

                if ($role === 'student') { // para sa paghandle ng student
                    $student = Student::firstOrCreate(
                        ['email' => $user['email']],
                        [
                            'student_id' => 'STU-' . strtoupper(uniqid()),
                            'student_no' => $user['student_no'] ?? ('SN-' . strtoupper(uniqid())),
                            'first_name' => $user['first_name'] ?? '',
                            'last_name'  => $user['last_name'] ?? '',
                            'course_id'  => $user['course_id'] ?? null,
                            'year_level' => $user['year_level'] ?? null,
                            'contact_no' => $user['contact_no'] ?? null,
                        ]
                    );
                }

                if ($role === 'faculty') { // para mag generate ng faculty
                    $faculty = Faculty::firstOrCreate(
                        ['email' => $user['email']],
                        [
                            'faculty_id' => 'FAC-' . strtoupper(uniqid()),
                            'first_name' => $user['first_name'] ?? '',
                            'last_name'  => $user['last_name'] ?? '',
                        ]
                    );
                }

                session([ // para magstore ng session data
                    'user_id'    => $role === 'student' ? $student->student_id : ($faculty->faculty_id ?? null),
                    'user_email' => $user['email'] ?? null,
                    'user_name'  => trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')),
                    'user_role'  => $role,
                    'api_token'  => $data['session_token'] ?? null,

                    'student_no' => $student->student_no ?? null,
                    'course_id'  => $student->course_id ?? null,
                    'year_level' => $student->year_level ?? null,
                ]);

                // redirect sya sa appropriate dashboard based on role
                if ($role === 'faculty') {
                    return redirect()->route('faculty.violations.index')
                                     ->with('success', 'Welcome, Faculty ' . ($user['first_name'] ?? '') . '!');
                }

                if ($role === 'student') {
                    return redirect()->route('student.violations.index')
                                     ->with('success', 'Welcome, Student ' . ($user['first_name'] ?? '') . '!');
                }

                return redirect()->route('login')->withErrors([
                    'login' => 'Unknown role. Please contact administrator.',
                ]);
            }

            return back()->withErrors([
                'login' => 'Invalid credentials. Please try again.',
            ]);

        } catch (ClientException $e) { // yung catch naman e to is para maghandle ng mga error na galing sa external API
            return back()->withErrors([
                'login' => 'Login failed. Please check your credentials.',
                'error_detail' => $e->getMessage(),
            ]);
        }
    }

    // para maglogout naman to ng faculty/student
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}

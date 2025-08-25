<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class IntegrationController extends Controller
{
    public function createUser(){
        $API_KEY = "PUP_4yi7BJbxkE2AlfyugTJRyQ50azh7SODm_1755307733";
        $baseURL = "https://pupt-registration.site";

        $URI = "/api/students";

        $student = [
            'email' => 'ajb.sanluis@gmail.com',
            'first_name' => 'Angelo Joshua',
            'last_name' => 'San luis',
            'student_number' => '2025-00122-TG-0',
            'program' => 'BSIT',
            'year' => '4th Year',
            'section' => '1',
            'birthdate' => '1995-08-06',

        ];

        $client = new Client([
            'base_url' => $baseURL,

        ]);

        try{

            $response = $client->request('POST', $URI,[
                'json' => $student,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-API-Key' => $API_KEY
                ],
            ]);

            $body = $response->getBody();
        } catch (ClientException $exception){
            $response = $exception->getResponse();
            $body = $response->getBody()->getContents();
        }

        $arrBody = json_decode($body);

        return $arrBody;
    }

    public function loginUser(){
        $API_KEY = "PUP_4yi7BJbxkE2AlfyugTJRyQ50azh7SODm_1755307733";
        $baseURL = "https://pupt-registration.site";

        $URI = "/api/auth/login";

        $student = [
            'email' => 'ajb.sanluis@gmail.com',
            'password' => 'userpassword',
        ];

        $client = new Client([
            'base_uri' => $baseURL,
        ]);

         try{

            $response = $client->request('POST', $URI,[
                'json' => $student,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-API-Key' => $API_KEY
                ],
            ]);

            $body = $response->getBody();
        } catch (ClientException $exception){
            $response = $exception->getResponse();
            $body = $response->getBody()->getContents();
        }

        $arrBody = json_decode($body);

        return $arrBody;
    }
    
}
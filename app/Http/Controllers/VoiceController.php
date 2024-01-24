<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;
use Twilio\Rest\Client;
use OpenAI\Laravel\Facades\OpenAI;

class VoiceController extends Controller
{
    private $response;

    public function __construct()
    {
        $this->response = new VoiceResponse();
    } 
    public function voiceOutput(Request $request)
    {
        
        $gather = $this->response->gather(['input' => 'speech', 'action' => '/api/chat']);
        $gather->say('Hello, I am your personal assistant. How can I help you today?');

        return $this->response;
    }

    public function speechtoText(Request $request)
    {
        $result = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $request->SpeechResult],
            ],
        ]);

        $this->response->say($result->choices[0]->message->content);
        $this->response->gather(['input' => 'speech', 'action' => '/api/chat']);
        
        return $this->response; 
    }

    public function endCall(Request $request)
    {
        $this->response->say('Thank you for using our service. Goodbye!');
        $this->response->hangup();

        return $this->response;
    }

    public function makeCall(Request $request)
    {
        $response = new VoiceResponse();
        
        // Your Twilio account SID and auth token
        $accountSid = env('TWILIO_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        
        // Initialize the Twilio client
        $client = new Client($accountSid, $authToken);
        
        // Make a call
        $call = $client->calls->create(
            '+14314411592',
            '+16515386980',
            [
                'url' => 'https://probably-composed-goblin.ngrok-free.app/api/voice', // URL to fetch TwiML when the call is answered
                'method' => 'POST',
            ]
        );
        
        // Say a message to the caller
        $response->say('Calling ' . $request->input('to') . '. Please wait for the call to connect.');

        return $response;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class ArticleGeneratorController extends Controller
{
    public function create()
    {
        return view('write');
    }
    public function store(Request $request)
    {
        if (!$request->title) {
            return;
        }

        $title = $request->title;

        $client = OpenAI::client(config('services.openai_api_key'));

        $result = $client->completions()->create([
            "model"=>"text-davinci-003",
            "prompt"=>"The following is a conversation with an AI assistant. The assistant is helpful, creative, clever, and very friendly.\n\nHuman: Hello, who are you?\nAI: I am an AI created by OpenAI. How can I help you today?\nHuman: I'd like to cancel my subscription.\nAI:",
            "temperature"=>0.9,
            "max_tokens"=>150,
            "top_p"=>1,
            "frequency_penalty"=>0.0,
            "presence_penalty"=>0.6,
            "stop"=>[" Human:", " AI:"]
        ]);

        $content = trim($result['choices'][0]['text']);

        return view('write', compact('title', 'content'));
    }


}

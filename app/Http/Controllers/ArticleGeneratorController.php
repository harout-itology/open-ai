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
        if (!($title = $request->title)) {
            return redirect()->back();
        }

        $client = OpenAI::client(config('services.openai_api_key'));

        $result = $client->completions()->create([
            "model" => "text-davinci-003",
            "temperature" => 0.7,
            "top_p" => 1,
            "frequency_penalty" => 0,
            "presence_penalty" => 0,
            'max_tokens' => 600,
            'prompt' => sprintf('Write article about: %s', $title),
        ]);

        $content = trim($result['choices'][0]['text']);

        return view('write', compact('title', 'content'));
    }


}

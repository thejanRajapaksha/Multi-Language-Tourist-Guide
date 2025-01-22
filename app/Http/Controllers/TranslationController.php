<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TranslationController extends Controller
{
    public function showForm()
    {
        return view('language-translator');
    }

    public function translate(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'language' => 'required|string',
        ]);
    
        $text = $request->input('text');
        $targetLanguage = $request->input('language');
    
        $apiKey = env('GOOGLE_TRANSLATE_API_KEY');
    
        $url = 'https://translation.googleapis.com/language/translate/v2';
    
        $response = Http::get($url, [
            'key' => $apiKey,
            'q' => $text,
            'target' => $targetLanguage,
            'format' => 'text',
        ]);
    
        \Log::info('Translation API response', $response->json());
    
        if ($response->successful()) {
            $translatedText = $response->json('data.translations.0.translatedText');
        } else {
            $error = $response->json('error.message', 'Unknown error');
            \Log::error('Translation API error', ['error' => $error]);
            $translatedText = "Error: $error";
        }
    
        return view('language-translator', ['translatedText' => $translatedText]);
    }
    

}


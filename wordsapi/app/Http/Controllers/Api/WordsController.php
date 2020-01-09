<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SearchWords;

class WordsController extends Controller
{
    public function getRecentWords()
    {
        $words = SearchWords::all()->pluck('word');
        return ['status' => 'success', 'data' => $words];
    }

    public function searchWords(Request $request)
    {
        $word = $request->word;
        $type = 'definitions';
        /*
        $curl = curl_init();
        $curl_url = env('WORDSAPI_URL') . $word . '/' . $type;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $curl_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "x-rapidapi-host: " . env('WORDSAPI_HOST'),
                "x-rapidapi-key: " . env('WORDSAPI_KEY')
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return ['status' => 'failed', 'message' => $err];
        } else {
            SearchWords::create(['word' => $word]);
            return ['status' => 'success', 'data' => ['body' => $response, 'url' => $curl_url]];
        }*/

        $url = env('WORDSAPI_URL') . $word . '/' . $type;
        $client = new \GuzzleHttp\Client([
            'headers' => [
                "x-rapidapi-host" => env('WORDSAPI_HOST'),
                "x-rapidapi-key" => env('WORDSAPI_KEY')
            ]
        ]);
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();

        SearchWords::create(['word' => $word]);
        return ['status' => 'success', 'data' => ['body' => $content, 'url' => $url]];
    }
}

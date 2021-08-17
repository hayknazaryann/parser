<?php

namespace App\Http\Controllers;

use App\Helpers\ParseHelper;
use App\Models\Post;
use App\Models\RequestLog;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(5);
        return view('posts.index',compact('posts'));
    }
    public function logs()
    {
        $logs = RequestLog::paginate(5);
        return view('posts.logs',compact('logs'));
    }

    public function parse(){
        $url = 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss';
        $method = 'GET';
        $client = new Client();
        $response = $client->request($method,$url, [
            'headers' => [
                'Accept' => 'application/xml'
            ]
        ]);
        $body = $response->getBody()->getContents();
        $date = $response->getHeader('Date')[0];
        $status_code = $response->getStatusCode();
        ParseHelper::create_logs($method,$url,$status_code,$body, $date);
        if ($response->getReasonPhrase() == 'OK' && $response->getStatusCode() == 200){
            ParseHelper::parse_news($body);
            return back()->with('success','Posts parsed successfully!');
        }

        return back()->with('error','Posts parse error!');
    }
}

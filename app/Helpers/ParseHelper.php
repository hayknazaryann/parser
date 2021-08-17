<?php
/**
 * Created by PhpStorm.
 * User: BrainFors
 * Date: 17.08.2021
 * Time: 12:44
 */

namespace App\Helpers;


use App\Models\Post;
use App\Models\RequestLog;

class ParseHelper
{
    public static function parse_news($body){
        $doc = new \DOMDocument();
        $doc->loadXML($body);
        $items = $doc->getElementsByTagName('item');
        foreach ($items as $item){
            $guid = $item->getElementsByTagName('guid')->item(0)->textContent;
            $exist = Post::where(['guid' => $guid])->count();
            if ($exist < 1){
                $post = new Post();
                $post->title = $item->getElementsByTagName('title')->item(0)->textContent;
                $post->link = $item->getElementsByTagName('link')->item(0)->textContent;
                $post->description = $item->getElementsByTagName('description')->item(0)->textContent;
                $post->author = $item->getElementsByTagName('author')->length ? $item->getElementsByTagName('author')->item(0)->textContent : null;
                $post->guid = $item->getElementsByTagName('guid')->item(0)->textContent;
                $post->pubDate = date('Y-m-d H:i:s',strtotime($item->getElementsByTagName('pubDate')->item(0)->textContent));
                $post->save();

                if ($item->getElementsByTagName('enclosure')->length){
                    foreach ($item->getElementsByTagName('enclosure') as $img){
                        $post->files()->create(['file_link' => $img->getAttribute('url')]);
                    }
                }
            }
        }
    }

    public static function create_logs($method,$url,$response_code,$body,$date){
        $log = new RequestLog();
        $log->method = $method;
        $log->url = $url;
        $log->response_code = $response_code;
        $log->response_body = $body;
        $log->request_date = date('Y-m-d H:i:s',strtotime($date));
        $log->save();
    }
}
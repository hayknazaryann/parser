<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ParseNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:news';
    protected $client;
    protected $url = 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = $this->client->get($this->url, [
            'headers' => [
                'Accept' => 'application/xml'
            ]
        ]);
        $body = $response->getBody()->getContents();

        $doc = new \DOMDocument();

        $doc->loadXML($body);
        $items = $doc->getElementsByTagName('item');
        $data = [];
        foreach ($items as $item){
            $post = new \stdClass();
            $post->title = $item->getElementsByTagName('title')->item(0)->textContent;
            $post->link = $item->getElementsByTagName('link')->item(0)->textContent;
            $post->description = $item->getElementsByTagName('description')->item(0)->textContent;
            $post->author = $item->getElementsByTagName('author')->length ? $item->getElementsByTagName('author')->item(0)->textContent : null;
            $post->guid = $item->getElementsByTagName('guid')->item(0)->textContent;
            $post->pubDate = date('Y-m-d H:i:s',strtotime($item->getElementsByTagName('pubDate')->item(0)->textContent));
            if ($item->getElementsByTagName('enclosure')->length){
                foreach ($item->getElementsByTagName('enclosure') as $img){
                    $post->files[] = $img->getAttribute('url');
                }
            }
            $data[] = $post;
        }
        Storage::put('/public/news/news.json',json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));


        return 0;
    }
}

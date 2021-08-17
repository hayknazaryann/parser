<?php

namespace App\Console\Commands;

use App\Helpers\ParseHelper;
use App\Models\Post;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

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
    protected $method = 'GET';

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
        $response = $this->client->request($this->method,$this->url, [
            'headers' => [
                'Accept' => 'application/xml'
            ]
        ]);
        $body = $response->getBody()->getContents();

        ParseHelper::create_logs('GET',$this->url,$response);
        if ($response->getReasonPhrase() == 'OK' && $response->getStatusCode() == 200){
            ParseHelper::parse_news($body);
        }

    }
}

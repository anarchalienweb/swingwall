<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Abraham\TwitterOAuth\TwitterOAuth;
use App\Tweet;

class TweetController extends Controller
{
    private $defaultSearch = 'electro swing';
    private $searchTerm = false;
    private $twitterConnection = false;
    private $consumerKey =  false;
    private $consumerSecret = false;
    private $accessToken = false;
    private $accessTokenSecret = false;
    private $minutes = 60 * 60 * 72;


    public function __construct() {
        $this->consumerKey = Config::get('twitter.consumerKey');
        $this->consumerSecret = Config::get('twitter.consumerSecret');
        $this->accessToken = Config::get('twitter.accessToken');
        $this->accessTokenSecret = Config::get('twitter.accessTokenSecret');
        $this->searchTerm = $this->defaultSearch;
        $this->twitterConnection = new TwitterOAuth($this->consumerKey,$this->consumerSecret,$this->accessToken,$this->accessTokenSecret);
    }
    
    public function index($searchTerm=false){
        if(false!==$searchTerm){
            $this->searchTerm = $searchTerm;
        }
        
        $minutes = $this->minutes;
        
        $statuses = Cache::remember('users', $minutes, function () {
            return $this->twitterConnection->get("search/tweets", ["q" => $this->searchTerm]);
        });
        
        foreach($statuses->statuses as $status){
           
            $exists = Tweet::where('twitterId',$status->id_str)->first();
            if(false==$exists){
                $tweet = new Tweet();
                $tweet->twitterId = $status->id_str;
                $tweet->raw = json_encode($status);
                $tweet->displayText = $status->text;
                $tweet->save();
            }
        }

        return response()->json($statuses);
    }
}

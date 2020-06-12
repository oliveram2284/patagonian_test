<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

use SpotifyWebAPI;
use Exception;

use Illuminate\Http\Request;
use App\Song;
class MainController extends Controller
{   

    private $spotifyApi;
    private $spotifyClient;

    public function __construct(){
    }

    public function index(Request $request){
        return response()->json(["Lumen Api Test"]);
    }
    public function songs(Request $request){
        try{
            if(!isset($request->header()['artistname'])){
                return response()->json(['status' => 400, 'error' => "artistName is required"]);
            }else{
                if(strlen($request->header()['artistname'])<3){
                    return response()->json(['status' => 400, 'error' => "artistName require 3 characters minimum"]);
                }
            }
            
            $artists = \App\Artist::where('name', 'like', '%' . $request->header()['artistname'][0] . '%')->get();
            if(empty($artists)){
                return response()->json(['status' => 400, 'error' => "Artist was not found"]);
            }

            $songs = [];

            foreach($artists as $art){

                foreach($art->songs as $song){
                    $songs[] = [
                        'songId' => $song->songId,
                        'songTitle' => $song->songTitle
                    ];
                }
                
            }
            return response()->json(['songs'=>$songs]);
        }catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); 
        } 
    }

    public function getSong($songId){
        try{
            if(!isset($songId)){
                return response()->json(['status' => 400, 'error' => "songId is required"]);
            }
            $song = \App\Song::find($songId);
            return response()->json(['song'=>$song]);
        }catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); 
        } 
    }


}

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
        return response()->json(["Technical Review - Backend Developer"]);
    }

    public function songs(Request $request){

        try{
            
            if(!isset($request->header()['artistname'][0])){
                return response()->json(['status' => 400, 'error' => "artistName is required"]);
            }else{
                if(strlen($request->header()['artistname'][0])<3){
                    return response()->json(['status' => 400, 'error' => "artistName require 3 characters minimum"]);
                }
            }
            
            $artist = \App\Artist::where('name', 'like', '%' . $request->header()['artistname'][0] . '%')->first();
            if(empty($artist)){
                return response()->json(['status' => 400, 'error' => "Artist was not found"]);
            }
           
            if($artist->songs->count()>0){
                $songs = $artist->songs()->select(['id as songId','songTitle'])->paginate(20);
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

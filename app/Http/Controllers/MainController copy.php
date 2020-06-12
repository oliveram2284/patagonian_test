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
    }


    public function getTracksByArtist(Request $request){    
       
        dd($request->header()['artistname'][0]);    
        try{

            if(strlen($request->artistName)<3){
                return response()->json(['status' => 400, 'error' => "artistName require 3 characters minimum"]);
            }
            
            $artist = \App\Artist::where('name', 'like', '%' . $request->artistName . '%')->get();
            
            if(empty($artist)){
                //Obtiene Artistas
                $spotify_artist = $this->spotifyApi->search($request->artistName,'artist');
               
                if($spotify_artist->artists->total === 0){
                    return response()->json(['status' => 400, 'error' => "Artist was not found"]);
                }

                
                $songs = [];
                
                foreach($spotify_artist->artists->items as $spotify_artist){

                    $artist = new \App\Artist();
                    $artist['spotify_id'] = $spotify_artist->id;
                    $artist['name'] = $spotify_artist->name;
                    $artist->save();
                    $spotify_albums = $this->spotifyApi->getArtistAlbums($spotify_artist->id,['album_type'=>'album','limit'=>50]);

                    
                    foreach($spotify_albums->items as $album){

                        
                        $spofity_tracks = $this->spotifyApi->getAlbumTracks($album->id,['limit'=>50]);                        

                        if($spofity_tracks->total>0){
                            foreach($spofity_tracks->items as $track){
                                
                                $song = Song::where('songId',$track->id)->first();
                               
                                if($song === null){                                   
                                    $artist->songs()->create([
                                        'songId' => $track->id,
                                        'songTitle' => $track->name
                                    ]);
                                }
                                $songs[] =[
                                    'songId' => $track->id,
                                    'songTitle' => $track->name
                                ];

                            }
                        }

                    }
                }
            }else{
                $songs = [];
                foreach($artist as $art){
                    foreach($art->songs as $song){
                        dump($song->songId);
                    }
                }
            }
            return response()->json(['songs'=>$songs]);
        }catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400); 
        } 
        

        
    }

    public function getTrackById($songId){
        
        $track_data =$this->spotifyApi->getTrack($songId);
        dd($track_data);
    }


}

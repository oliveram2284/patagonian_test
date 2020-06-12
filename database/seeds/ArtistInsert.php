<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Seeder;

class ArtistInsert extends Seeder{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
            App\Artist::truncate();
            if(!Cache::has('accessToken')){
                $this->spotifyClient = new SpotifyWebAPI\Session(
                    env('SPOTIFY_CLIENT_ID', false),
                    env('SPOTIFY_CLIENT_SECRET', false)
                );
    
                if($this->spotifyClient->requestCredentialsToken()){
                    $tokenExpiryMinutes = floor(($this->spotifyClient->getTokenExpiration() - time()) / 60);
                    Cache::put(
                        'accessToken',
                        $this->spotifyClient->getAccessToken(),
                        $tokenExpiryMinutes
                    );
                }
            }
    
            $this->spotifyApi = new SpotifyWebAPI\SpotifyWebAPI();
            $this->spotifyApi->setAccessToken(Cache::get('accessToken'));
           

            $file = new \SplFileObject('public/artist_list.csv');   
           
            while (!$file->eof()) {
                $line = $file->fgets();  
                $artist_line =explode(',',trim($line));
               
                $spotify_artist = $this->spotifyApi->getArtist($artist_line[0]); 
                echo "\n====>\t Processing Artist:  ".$spotify_artist->name."          \n\n";
                
                $artist = App\Artist::create([
                    'spotify_id' => $spotify_artist->id,
                    'name' => $spotify_artist->name,
                ]);
                
                $spotify_albums = $this->spotifyApi->getArtistAlbums($spotify_artist->id,['album_type'=>'album','limit'=>50]);
                foreach($spotify_albums->items as $album){
                    echo "=========>\t Processing Album:  ".$album->name." \n";

                    $spofity_tracks = $this->spotifyApi->getAlbumTracks($album->id,['limit'=>50]);
                    
                    if($spofity_tracks->total>0){
                        foreach($spofity_tracks->items as $track){
                            $artist->songs()->create([
                                'songId' => $track->id,
                                'songTitle' => $track->name
                            ]);
                        }
                    }
                }

            }

        }catch(Exception $e) {
            echo $e->getMessage();
        }    
    }
}

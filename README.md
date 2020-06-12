# patagonian_test
Technical Review - Backend Developer

Instalacion:

1- Editar archivo .env en:
   - Datos de conexion DB:
      DB_DATABASE= **DATABASE NAME**     
      DB_USERNAME= **DATABASE USERNAME**
      DB_PASSWORD= **DATABASE PASSWORD**
     
   - DATOS API SPOTIFY: 
   SPOTIFY_CLIENT_ID=** XXXXXXXXXXXXX **
   SPOTIFY_CLIENT_SECRET=** XXXXXXXXXXXXX **
   SPOTIFY_CALLBACK_URL=** XXXXXXXXXXXXX **
   
2- Desde la consola de comando posicionado en el root del proyecto ejecutar los siguientes comandos:
   - **composer update**
   - **npm install**
   - **php artisan migrate**  //Crea las tablas en la db
   - **php artisan db:seed --class=ArtistInsert** //Script que procesa un ** public/artist_list.csv ** que inserta en la db
   - **php artisan serve**

3- Endpoints:
   - **/songs** :
     + method: GET
     + params: 
        - artistName: required(string - minLength: 3)
     + result: {
         "songs": [
            {
               "songId": "2TpxZ7JUBn3udsd6aR7qg68",
               "songTitle": "Californication"
            },
            {
               "songId": "1TuxZ7JU323uw46aR7qd6V",
               "songTitle": "Otherside"
            }
         ]
   - **/songs/{songId}:
     - songId: required(string)
     - response: {
         "artists": [
            {
               "external_urls": {
               "spotify": "https://open.spotify.com/artist/08td7MxkoHQkXnWAYD8d6Q"
               },
               "href": "https://api.spotify.com/v1/artists/08td7MxkoHQkXnWAYD8d6Q",
               "id": "08td7MxkoHQkXnWAYD8d6Q",
               "name": "Tania Bowra",
               "type": "artist",
               "uri": "spotify:artist:08td7MxkoHQkXnWAYD8d6Q"
            }
         ],
         "disc_number": 1,
         "duration_ms": 276773,
         "explicit": false,
         "external_urls": {
            "spotify": "https://open.spotify.com/track/2TpxZ7JUBn3uw46aR7qd6V"
         },
         "href": "https://api.spotify.com/v1/tracks/2TpxZ7JUBn3uw46aR7qd6V",
         "id": "2TpxZ7JUBn3uw46aR7qd6V",
         "is_local": false,
         "is_playable": true,
         "name": "All I Want",
         "preview_url": "https://p.scdn.co/mp3-preview/12b8cee72118f995f5494e1b34251e4ac997445e?cid=774b29d4f13844c495f206cafdad9c86",
         "track_number": 1,
         "type": "track",
         "uri": "spotify:track:2TpxZ7JUBn3uw46aR7qd6V"
         }
}
   
   

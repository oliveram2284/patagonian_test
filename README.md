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
   - **composer install**
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
}
   
   

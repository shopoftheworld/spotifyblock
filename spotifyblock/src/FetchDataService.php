<?php

/**
  * @file
  * Contains  \Drupal\spotifyblock
  */
namespace Drupal\spotifyblock;

/**
 * Defines a service for fetching data
 */
class FetchDataService {
    
  protected $client;  

  /**
  * Constructor
  */
  public function __construct()  {
        $this->client = \Drupal::httpClient();
  }

  /** 
  * calls the data url 
  */
  public function get() {

    try {
          $authorization = $this->client->request('POST', 'https://accounts.spotify.com/api/token', [
              'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => '9e237386aef04c02b4214346150191db',
                'client_secret' => '78fd7ac390974444a52b08f6b8196d4d'
              ]
            ]);

          $response = json_decode($authorization->getBody());

          } catch (GuzzleException $e) {
              return \Drupal::logger('spotifyblock')->error($e);
        }

      try {
          
          $artists = \Drupal::httpClient()->request('GET', "https://api.spotify.com/v1/artists/4UXJsSlnKd7ltsrHebV79Q/related-artists?access_token=" . $response->access_token ); 
        } catch (GuzzleException $e) {
            return \Drupal::logger('spotifyblock')->error($e);
        }
    return $artists;
  }

  /** 
  * calls the data url for individual artist
  */
  public function get_artist($artistid) {

    try {
          $authorization = $this->client->request('POST', 'https://accounts.spotify.com/api/token', [
              'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => '9e237386aef04c02b4214346150191db',
                'client_secret' => '78fd7ac390974444a52b08f6b8196d4d'
              ]
            ]);

          $response = json_decode($authorization->getBody());

          } catch (GuzzleException $e) {
              return \Drupal::logger('spotifyblock')->error($e);
        }

      try {
          
          $artist = \Drupal::httpClient()->request('GET', "https://api.spotify.com/v1/artists/$artistid?access_token=" . $response->access_token ); 
        } catch (GuzzleException $e) {
            return \Drupal::logger('spotifyblock')->error($e);
        }
    return $artist;
  }
}
  
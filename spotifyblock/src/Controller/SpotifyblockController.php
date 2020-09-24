<?php 
/**
	* @file
  * Contains \Drupal\spotifyblock\Controller
  */

namespace Drupal\spotifyblock\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

/**
  * Controller for spotify list artist display
*/

class SpotifyblockController extends ControllerBase {
  /**
   * @return array
   */
  public function showArtist($artistid) {
    $build = [
      '#cache' => [
        'max-age' => 60,
        'contexts' => ['url']
      ]
    ];

    try {
      $fetchdata = \Drupal::service('spotifyblock.fetchdata');
      $response = $fetchdata->get_artist($artistid);
      $data = $response->getBody()->getContents();
      $decoded = json_decode($data);
      \Drupal::logger('spotifyblock')->warning('<pre><code>' . print_r($decoded, TRUE) . '</code></pre>');

      if (!$decoded) {
        throw new \Exception('Invalid data returned from API');
      }
      } catch (\Exception $e) {
      return $build;
      }

      $markup = '<br/>Artist name: ' . $decoded->name;
      $markup .= '<br/>Popularity: ' . $decoded->popularity;
      $markup .= '<br/>Artist ID: ' . $decoded->id;
      $markup .= '<br/><img src="' . $decoded->images[0]->url . '">';
       
      $build[] = [
        '#markup' => $markup,
      ];

     return $build;
  }
}

<?php
/**
 * @file
 * Contains \Drupal\spotifyblock\Plugin\Block\SpotifyblockBlock
 */
 namespace Drupal\spotifyblock\Plugin\Block;
 
 use Drupal\Core\Block\BlockBase;
 use Drupal\Core\Session\AccountInterface;
 use Drupal\Core\Access\AccessResult;

 /**
 * Provides a 'Spotify Artist' List Block
 *
 * @Block(
 *   id = "spotifyblock_block",
 *   admin_label = @Translation("Spotify Artists Block"),
 *   category = @Translation("Blocks")
 * )
 */
class SpotifyblockBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
      $build = [
      '#cache' => [
        'max-age' => 60,
        'contexts' => ['url']
      ]
    ];

    try {
      $fetchdata = \Drupal::service('spotifyblock.fetchdata');
      $response = $fetchdata->get();
      $data = $response->getBody()->getContents();
      $decoded = json_decode($data);

      // \Drupal::logger('spotifyblock')->warning('<pre><code>' . print_r($decoded, TRUE) . '</code></pre>');
      
      if (!$decoded) {
        throw new \Exception('Invalid data returned from API');
      }
    }
      catch (\Exception $e) {
      return $build;
      }

    // fix a ceiling for max number of records to display
    $config = \Drupal::config('spotifyblock.settings');
    $max = $config->get('spotifyblock_artists');
    $i = 0;

    foreach ($decoded as $item) {
      foreach ($item as $value) {
        if ($i > $max) {
            break; 
          }
      $build[] = [
        '#markup' => '<br><a href="/artist/' . $value->id . '">' . $value->name . '</a>' ,
      ];
      $i++;
    }
  }
    return $build;
  }
}

         
<?php
/**
 * @file
 * Contains \Drupal\spotifyblock\Form\SpotifyblockSettingsForm
 */

namespace Drupal\spotifyblock\Form;

use Drupal\Core\Form\ConfigFormBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form to configure Spotify Block module settings
 */
class SpotifyblockSettingsForm extends ConfigFormBase {
  
  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'spotifyblock_artists';
  }

   /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
    'spotifyblock.settings'
    ];
  }
  
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $config = $this->config('spotifyblock.settings');
    $form['spotifyblock_artists'] = array(
      '#type' => 'select',
      '#title' => $this->t('The number of Spotify Artists to return'),
      '#default_value' => $config->get('spotifyblock_artists'),
      '#options' =>array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20'),
      '#description' => t('How many Spotify Artists should be returned (Max: 20)'),
       );
    return parent::buildForm($form,$form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('spotifyblock.settings')
      ->set('spotifyblock_artists', $form_state->getValue('spotifyblock_artists'))
      ->save();
    parent::submitForm($form, $form_state);
  }
}




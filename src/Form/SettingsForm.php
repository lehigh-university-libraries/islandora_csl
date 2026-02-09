<?php

namespace Drupal\islandora_csl\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configuration form for Islandora CSL settings.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['islandora_csl.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'islandora_csl_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('islandora_csl.settings');

    $form['render_mode'] = [
      '#type' => 'radios',
      '#title' => $this->t('Rendering mode'),
      '#description' => $this->t('Choose how citations should be rendered.'),
      '#options' => [
        'server' => $this->t('Server-side (PHP CiteProc)'),
        'client' => $this->t('Client-side (citation-js)'),
      ],
      '#default_value' => $config->get('render_mode') ?? 'server',
    ];

    $form['csl_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Citation style (client-side)'),
      '#description' => $this->t('Select the citation style to use for client-side rendering. This uses citation-js built-in styles.'),
      '#options' => [
        'citation-apa' => $this->t('APA (American Psychological Association)'),
        'citation-vancouver' => $this->t('Vancouver'),
        'citation-harvard1' => $this->t('Harvard'),
      ],
      '#default_value' => $config->get('csl_style') ?? 'citation-apa',
      '#states' => [
        'visible' => [
          ':input[name="render_mode"]' => ['value' => 'client'],
        ],
      ],
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('islandora_csl.settings')
      ->set('render_mode', $form_state->getValue('render_mode'))
      ->set('csl_style', $form_state->getValue('csl_style'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}

<?php

namespace Drupal\flisol_2020\Form;

use Drupal\Component\Utility\EmailValidatorInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ConfigForm.
 */
class ConfigForm extends ConfigFormBase {

  /**
   * The email validator service.
   *
   * @var \Drupal\Component\Utility\EmailValidatorInterface
   */
  protected $emailValidator;

  /**
   * Constructs a ConfigForm object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   * @param \Drupal\Component\Utility\EmailValidatorInterface $email_validator
   *   The email validator service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, EmailValidatorInterface $email_validator) {
    parent::__construct($config_factory);

    $this->emailValidator = $email_validator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('email.validator')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'flisol_2020_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'flisol_2020.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    $config = $this->config('flisol_2020.settings');

    $form['flisol_2020'] = [
      '#type' => 'vertical_tabs',
      '#title' => $this->t('FLISoL 2020 information'),
    ];

    $form['speaker'] = [
      '#type' => 'details',
      '#title' => $this->t('Speaker information'),
      '#group' => 'flisol_2020',
    ];
    $form['speaker']['speaker_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#default_value' => $config->get('speaker.name'),
      '#required' => TRUE,
      '#maxlength' => 255,
      '#size' => 60,
    ];
    $form['speaker']['speaker_email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#default_value' => $config->get('speaker.email'),
      '#required' => TRUE,
      '#maxlength' => 255,
      '#size' => 60,
    ];
    $form['speaker']['speaker_github_url'] = [
      '#type' => 'url',
      '#title' => $this->t('GitHub profile'),
      '#default_value' => $config->get('speaker.github_url'),
      '#required' => TRUE,
      '#maxlength' => 255,
      '#size' => 60,
    ];
    $form['speaker']['speaker_drupal_url'] = [
      '#type' => 'url',
      '#title' => $this->t('Drupal profile'),
      '#default_value' => $config->get('speaker.drupal_url'),
      '#required' => TRUE,
      '#maxlength' => 255,
      '#size' => 60,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!$this->emailValidator->isValid($form_state->getValue('speaker_email'))) {
      $form_state->setErrorByName('speaker_email', $this->t('The value is not a valid email address.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('flisol_2020.settings')
      ->set('speaker.name', $form_state->getValue('speaker_name'))
      ->set('speaker.email', $form_state->getValue('speaker_email'))
      ->set('speaker.github_url', $form_state->getValue('speaker_github_url'))
      ->set('speaker.drupal_url', $form_state->getValue('speaker_drupal_url'))
      ->save();
  }

}

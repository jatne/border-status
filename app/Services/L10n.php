<?php

namespace BorderStatus\Services;

class L10n
{
  /**
   * Enable translations
   */
  public function __construct()
  {
    add_action('plugins_loaded', [$this, 'load']);
  }

  /**
   * Load the translation file
   */
  public function load()
  {
    load_plugin_textdomain(PROJECT_ID, false, basename(dirname(DIR)) . '/l10n/');
  }
}

<?php

namespace BorderStatus\Services;

class Assets
{
  /**
   * @var int|string Depends on DE_MODE
   */
  private $version;

  /**
   * Add assets
   */
  public function __construct()
  {
    $this->version = DEV_MODE ? time() : VERSION;

    add_action('wp_enqueue_scripts', [$this, 'init']);
  }

  /**
   * Initialize on WP hook
   */
  public function init()
  {
    $this->frontend();
    $this->dashboard();
  }


  /**
   * frontend.js/css included only on frontend
   */
  private function frontend()
  {
    if (!is_admin()) {
      wp_enqueue_script(PROJECT_ID . '.frontend', ASSETS . 'scripts/frontend.js', [], $this->version, true);
      wp_enqueue_style(PROJECT_ID . '.frontend', ASSETS . 'styles/frontend.css', [], $this->version);
    }
  }

  /**
   * dashboard.js/css included only on WP Dashboard
   */
  private function dashboard()
  {
    if (is_admin()) {
      wp_enqueue_script(PROJECT_ID . '.dashboard', ASSETS . 'scripts/dashboard.js', [], $this->version, true);
      wp_enqueue_style(PROJECT_ID . '.dashboard', ASSETS . 'styles/dashboard.css', [], $this->version);
    }
  }
}

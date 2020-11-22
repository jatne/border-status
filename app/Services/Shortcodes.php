<?php

namespace BorderStatus\Services;

class Shortcodes
{
  public function __construct()
  {
    \add_shortcode('wpk_border_status', [$this, 'borderStatusShortcode']);
  }

  public function borderStatusShortcode() {
    $borderPoints = \get_option(BORDER_POINTS_OPTION);

    if (!$borderPoints) {
      return;
    }

    \ob_start();

    include DIR . '/template/border-status.php';

    return \ob_get_clean();
  }
}

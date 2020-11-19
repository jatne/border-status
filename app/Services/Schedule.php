<?php

namespace border_status\Services;

use border_status\Services\BorderPoints;

class Schedule {
  private const SCHEDULE_INTERVAL_KEY = 'every_30_mins';
  private const SCHEDULE_INTERVAL_VALUE = 1800;
  private const SCHEDULE_INTERVAL_NAME = 'every 30 minutes';

  public function __construct() {
    \add_filter('cron_schedules', [$this, 'customCronInterval']);
    \add_action('admin_init', [$this, 'initSchedule']);
    \add_action('wpk_cron_hook', [$this, 'saveData']);
  }

  public function customCronInterval($schedules) {
    $schedules[self::SCHEDULE_INTERVAL_KEY] = [
      'interval' => self::SCHEDULE_INTERVAL_VALUE,
      'display' => self::SCHEDULE_INTERVAL_NAME,
    ];

    return $schedules;
  }

  public function initSchedule() {
    if ( !\wp_next_scheduled('wpk_cron_hook') ) {
      \wp_schedule_event(\time(), self::SCHEDULE_INTERVAL_KEY, 'wpk_cron_hook');
    }
  }

  public function saveData() {
    $borderPoints = new BorderPoints;
    $borderPoints->setChoosenPoints();

    $val = \json_encode($borderPoints->getChoosenPointsInfo());
    \update_option(BORDER_POINTS_OPTION, $val);
  }
}
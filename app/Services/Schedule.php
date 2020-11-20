<?php

namespace BorderStatus\Services;


class Schedule
{
  private const SCHEDULE_INTERVAL_KEY = 'every_30_mins';
  private const SCHEDULE_INTERVAL_VALUE = 1800;
  private const SCHEDULE_INTERVAL_NAME = 'every 30 minutes';

  /**
   * Setting up custom CRON
   * @return void
   */
  public function __construct()
  {
    /**
     * Creating custom CRON interval
     */
    \add_filter('cron_schedules', [$this, 'customCronInterval']);
    \add_action('admin_init', [$this, 'initSchedule']);

    /**
     * Hooking action for CRON
     */
  }

  /**
   * Setting up custom interval
   *
   * @param array $schedules
   * @return array
   */
  public function customCronInterval(array $schedules): array
  {
    $schedules[self::SCHEDULE_INTERVAL_KEY] = [
      'interval' => self::SCHEDULE_INTERVAL_VALUE,
      'display' => self::SCHEDULE_INTERVAL_NAME,
    ];

    return $schedules;
  }

  /**
   * Initializing schedule
   *
   * @return void
   */
  public function initSchedule()
  {
    if (!\wp_next_scheduled('wpk_cron_hook')) {
      \wp_schedule_event(\time(), self::SCHEDULE_INTERVAL_KEY, 'wpk_cron_hook');
    }
  }

  /**
   * Updating border status
   *
   * @return void
   */
  {
    $acf = new ACF();
    $acf->updateBorderStatus();
  }
}
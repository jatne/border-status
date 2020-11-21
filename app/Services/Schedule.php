<?php

namespace BorderStatus\Services;

class Schedule
{
  private const SCHEDULE_INTERVAL_KEY = 'every_30_mins';
  private const SCHEDULE_INTERVAL_VALUE = 1800;
  private const SCHEDULE_INTERVAL_NAME = 'every 30 minutes';
  private const SCHEDULE_EVENT = 'wpk_update_border_status';

  /**
   * Setting up custom CRON
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
    \add_action(self::SCHEDULE_EVENT, [$this, 'saveData']);
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
   */
  public function initSchedule()
  {
    \register_deactivation_hook(__FILE__, [$this, 'deactivateSchedule']);

    if (!\wp_next_scheduled(self::SCHEDULE_EVENT)) {
      \wp_schedule_event(\time(), self::SCHEDULE_INTERVAL_KEY, self::SCHEDULE_EVENT);
    }
  }

  /**
   * Clean the scheduler on deactivation
   */
  public function deactivateSchedule() {
    \wp_clear_scheduled_hook(self::SCHEDULE_EVENT);
  }

  /**
   * Updating border status
   */
  public function saveData(): void
  {
    $acf = new ACF();
    $acf->updateBorderStatus();
  }
}

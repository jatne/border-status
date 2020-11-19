<?php

namespace border_status\Services;

class ACF
{

  public function __construct()
  {
    \add_action('acf/init', [$this, 'initPlugin'], 15);
    \add_filter('acf/settings/url', [$this, 'registerUrl'], 15);
    \add_filter('acf/settings/show_admin', [$this, 'showAdminInDashboard'], 15);
    \add_filter('acf/load_field/name=wpk_border_ports', [$this, 'populateBorderPointsChoices']);
    \add_filter('acf/save_post', [$this, 'updateBorderStatus'], 15);
  }

  public function initPlugin(): void
  {
    if (\function_exists('acf_add_local_field_group')) {
      if (\file_exists(DIR . 'data/acf-fields.php')) {
        require_once DIR . 'data/acf-fields.php';
      }
    }
  }

  public function registerUrl(): string
  {
    return WPK_ACF_URL;
  }

  public function showAdminInDashboard(): bool
  {
    return false;
  }

  public function populateBorderPointsChoices($field): array
  {
    $field['choices'] = [];
    $borderPoints = [];

    $borderPointsName = $borderPointsCls->getPortsData('port_name');
    $borderPointsExtraName = $borderPointsCls->getPortsData('crossing_name');

    foreach ( $borderPointsName as $borderPointId => $borderPointName ) {
      $borderPoints[$borderPointId] = $borderPointName;

      if ( $borderPointsExtraName[$borderPointId] ) {
        $borderPoints[$borderPointId] .= ' - ' . $borderPointsExtraName[$borderPointId];
      }
    }

    if (!$borderPoints) {
      return $field;
    }

    $field['choices'] = $borderPoints;

    return $field;
  }

  public function updateBorderStatus()
  {

    $schedule->saveData();
  }
}
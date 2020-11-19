<?php
namespace border_status\Services;

class BorderPoints {
  private const BORDER_POINTS_SOURCE = 'https://bwt.cbp.gov/xml/bwt.xml';

  private $borderPoints;
  private $choosenPoints = [];

  public function __construct() {
    $this->setBorderPoints();
  }

  public function getBorderPoints() {
    return $this->borderPoints;
  }

  public function setBorderPoints(): void {
    $xml = \simplexml_load_file(self::BORDER_POINTS_SOURCE);

    $this->borderPoints = $xml;
  }

  /**
   *
   * @param mixed $attribute
   * @param string $border
   * @return null|array
   */
  public function getPortsData($attribute, $id = '', $toString = true, $border = 'Mexican Border') {
    $xml = $this->borderPoints;
    $ports = '';

    if ( !$xml ) {
      return null;
    }

    $ports = $xml->xpath("//port[border='$border']");

    if ( !$ports ) {
      return null;
    }

    if (!$ports[0]->xpath($attribute)) {
      return null;
    }

    $portsData = [];

    foreach ( $ports as $port ) {
      $portsData[$port->xpath('port_number')[0]->__toString()] = $toString ? $port->xpath($attribute)[0]->__toString() : $port->xpath($attribute)[0];
    }

    if ( $id ) {
      return $portsData[$id];
    }

    return $portsData;
  }

  public function setChoosenPoints() {
    $ports = \get_field('wpk_border_ports', 'option') ? \get_field('wpk_border_ports', 'option') : [];

    $this->choosenPoints = $ports;
  }

  public function getChoosenPoints() {
    return $this->choosenPoints;
  }

  public function getChoosenPointsInfo() {
    $ports = $this->getChoosenPoints();

    if ( !count($ports) ) {
      throw new \Exception('Empty ports');
    }

    $pointData = [
      'saving_time' => time(),
      'update' => [
        'date' => reset($this->getPortsData('../last_updated_date')),
        'time' => reset($this->getPortsData('../last_updated_time')),
      ],
    ];

    foreach ( $ports as $key => $port ) {
      $borderPointsName = $this->getPortsData('port_name', $port);

      if ( $this->getPortsData('crossing_name', $port) ) {
        $borderPointsName .= sprintf(' - %s', $this->getPortsData('crossing_name', $port));
      }

      $pointData['ports'][$key] = [
        'id'          => $port,
        'name'        => $borderPointsName,
        'port_status' => $this->getPortsData('port_status', $port),
        'gates'       => [
          'passenger_vehicle' => [
            'standard' => $this->getPortsData('passenger_vehicle_lanes/standard_lanes/delay_minutes', $port),
            'sentri'   => $this->getPortsData('passenger_vehicle_lanes/NEXUS_SENTRI_lanes/delay_minutes', $port),
            'ready'    => $this->getPortsData('passenger_vehicle_lanes/ready_lanes/delay_minutes', $port),
          ],
          'pedestrain' => [
            'standard' => $this->getPortsData('pedestrian_lanes/standard_lanes/delay_minutes', $port),
            'ready'    => $this->getPortsData('pedestrian_lanes/ready_lanes/delay_minutes', $port),
          ],
        ]
      ];
    }

    return $pointData;
  }
}
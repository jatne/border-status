<?php

namespace BorderStatus\Services;

use SimpleXMLElement;

class BorderPoints {
  /**
   * XML Source
   * @link https://bwt.cbp.gov/
   */
  private const BORDER_POINTS_SOURCE = 'https://bwt.cbp.gov/xml/bwt.xml';

  private $borderPoints;
  private $choosenPoints = [];

  /**
   * Initializing all border points
   */
  public function __construct()
  {
    $this->setBorderPoints();
  }

  /**
   *
   * @return SimpleXMLElement
   */
  public function getBorderPoints(): SimpleXMLElement
  {
    return $this->borderPoints;
  }

  /**
   * Setting up border points
   */
  public function setBorderPoints(): void
  {
    $xml = \simplexml_load_file(self::BORDER_POINTS_SOURCE);

    $this->borderPoints = $xml;
  }

  /**
   *
   * @param string $attribute
   * @param null|string $id
   * @param string $border
   * @param bool $toString
   * @return null|array
   */
  public function getPortsData(string $attribute, ?string $id = null, string $border = 'Mexican Border', bool $toString = true)
  {
    $xml = $this->getBorderPoints();
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

  /**
   * Setting up choosen points
   */
  public function setChoosenPoints(): void
  {
    $ports = \get_field('wpk_border_ports', 'option') ? \get_field('wpk_border_ports', 'option') : [];

    $this->choosenPoints = $ports;
  }

  /**
   *
   * @return mixed
   */
  public function getChoosenPoints()
  {
    return $this->choosenPoints;
  }

/**
 *
 * @return null|array
 */
  public function getChoosenPointsInfo(): ?array
  {
    $ports = $this->getChoosenPoints();

    if ( !count($ports) ) {
      return null;
    }

    $lastUpdatedTime = $this->getPortsData('../last_updated_time');
    $lastUpdatedDate = $this->getPortsData('../last_updated_date');

    $pointData = [
      'saving_time' => time(),
      'update' => [
        'date' => reset($lastUpdatedDate),
        'time' => reset($lastUpdatedTime),
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
        ],
      ];
    }

    return $pointData;
  }
}

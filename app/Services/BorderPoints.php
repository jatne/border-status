<?php

namespace BorderStatus\Services;

use SimpleXMLElement;

/**
 *
 * @package BorderStatus\Services
 */
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
   *
   * @return void
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
   *
   * @return void
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
   * @param bool $toString
   * @param string $border
   * @return null|array
   */
  public function getPortsData(string $attribute, ?string $id = null, bool $toString = true, string $border = 'Mexican Border')
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
   *
   * @return void
   */
  public function setChoosenPoints(): void
  {
    $ports = \get_field('wpk_border_ports', 'option') ? \get_field('wpk_border_ports', 'option') : [];

    $this->choosenPoints = $ports;
  }

  /**
   *
   * @return mixed.|array
   */
  public function getChoosenPoints()
  {
    return $this->choosenPoints;
  }

/**
 *
 * @return null|(int|array)[]
 */
  public function getChoosenPointsInfo()
  {
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
<?php

namespace Jplarar\EnviaBundle\Services;
use Exception;
/**
 * Reference: https://api.envia.com/doc.php#reference
 * Class EnviaClient
 * @package Jplarar\EnviapaqueteriaBundle\Services
 */
class EnviaClient
{

    const ENDPOINT = "https://api.envia.com";
    const ENDPOINT_DEV = "https://api-test.envia.com";

    const RATE_PATH = "/ship/rate/";
    const GENERATE_PATH = "/ship/generate/";
    const PICK_UP_PATH = "/ship/pickup/";

    protected $token;
    protected $url;

    /**
     * EnviaClient constructor.
     * @param $envia_token
     * @param string $environment
     */
    public function __construct($envia_token, $environment = "prod")
    {
        $this->token = $envia_token;
        if ($environment == "prod") {
            $this->url = self::ENDPOINT;
        } else {
            $this->url = self::ENDPOINT_DEV;
        }
    }

    /**
     * https://api.envia.com/doc.php#rate
     * @param $origin
     * @param $destination
     * @param $package
     * @param $shipment
     * @return bool|string
     */
    public function quote($origin, $destination, $package, $shipment)
    {
        $url = $this->url.self::RATE_PATH;

        try {
            $data = [
                "origin" => array(
                    "name"          => $origin["name"],
                    "company"       => $origin["company"],
                    "email"         => $origin["email"],
                    "phone"         => $origin["phone"],
                    "street"        => $origin["street"],
                    "number"        => $origin["number"],
                    "district"      => $origin["district"],
                    "city"          => $origin["city"],
                    "state"         => $origin["state"],
                    "country"       => $origin["country"],
                    "postalCode"    => $origin["postalCode"],
                    "reference"     => ""
                ),
                "destination" => array(
                    "name"          => $destination["name"],
                    "company"       => $destination["company"],
                    "email"         => $destination["email"],
                    "phone"         => $destination["phone"],
                    "street"        => $destination["street"],
                    "number"        => $destination["number"],
                    "district"      => $destination["district"],
                    "city"          => $destination["city"],
                    "state"         => $destination["state"],
                    "country"       => $destination["country"],
                    "postalCode"    => $destination["postalCode"],
                    "reference"     => ""
                ),
                "packages" => [
                    [
                    "content"   => $package["content"],
                    "amount"    => $package["amount"],
                    "type"      => $package["type"],
                    "dimensions" => [
                        "length" => $package["dimensions_length"],
                        "width"  => $package["dimensions_width"],
                        "height" => $package["dimensions_height"]
                    ],
                    "weight" => $package["weight"],
                    "insurance" => $package["insurance"],
                    "declaredValue" => $package["declaredValue"],
                    "weightUnit" => "KG",
                    "lengthUnit"=> "CM"
                    ]
                ],
                "shipment" => array(
                    "carrier" => $shipment["carrier"],
                    "type" => 1
                )
            ];

            $options = array(
                'http' => array(
                    'header' => [
                        "Content-Type: application/json",
                        "Authorization: Bearer ".$this->token
                    ],
                    'method' => "POST",
                    'content' => json_encode($data)
                ),
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                )
            );
            $context  = stream_context_create($options);
            $json = file_get_contents($url, false, $context);
            return json_decode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * https://api.envia.com/doc.php#generate
     * @param $origin
     * @param $destination
     * @param $package
     * @param $shipment
     * @return bool|string
     */
    public function create($origin, $destination, $package, $shipment)
    {
        $url = $this->url.self::GENERATE_PATH;

        try {
            $data = [
                "origin" => array(
                    "name"          => $origin["name"],
                    "company"       => $origin["company"],
                    "email"         => $origin["email"],
                    "phone"         => $origin["phone"],
                    "street"        => $origin["street"],
                    "number"        => $origin["number"],
                    "district"      => $origin["district"],
                    "city"          => $origin["city"],
                    "state"         => $origin["state"],
                    "country"       => $origin["country"],
                    "postalCode"    => $origin["postalCode"],
                    "reference"     => ""
                ),
                "destination" => array(
                    "name"          => $destination["name"],
                    "company"       => $destination["company"],
                    "email"         => $destination["email"],
                    "phone"         => $destination["phone"],
                    "street"        => $destination["street"],
                    "number"        => $destination["number"],
                    "district"      => $destination["district"],
                    "city"          => $destination["city"],
                    "state"         => $destination["state"],
                    "country"       => $destination["country"],
                    "postalCode"    => $destination["postalCode"],
                    "reference"     => ""
                ),
                "packages" => [
                    [
                        "content"   => $package["content"],
                        "amount"    => $package["amount"],
                        "type"      => $package["type"],
                        "dimensions" => [
                            "length" => $package["dimensions_length"],
                            "width"  => $package["dimensions_width"],
                            "height" => $package["dimensions_height"]
                        ],
                        "weight" => $package["weight"],
                        "insurance" => $package["insurance"],
                        "declaredValue" => $package["declaredValue"],
                        "weightUnit" => "KG",
                        "lengthUnit"=> "CM"
                    ]
                ],
                "shipment" => array(
                    "carrier"   => $shipment["carrier"],
                    "service"   => $shipment["service"],
                    "type"      => 1
                ),
                "settings"=> array(
                    "printFormat"=> "PDF",
                    "printSize"=> "STOCK_4X6",
                    "comments" => ""
                )
            ];

            $options = array(
                'http' => array(
                    'header' => [
                        "Content-Type: application/json",
                        "Authorization: Basic ".$this->token
                    ],
                    'method' => "POST",
                    'content' => json_encode($data)
                ),
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                )
            );
            $context  = stream_context_create($options);
            $json = file_get_contents($url, false, $context);
            return json_decode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * https://api.envia.com/doc.php#pickup
     * @param $origin
     * @param $package
     * @param $shipment
     * @return bool|string
     */
    public function pickUp($origin, $package, $shipment)
    {
        $url = $this->url.self::PICK_UP_PATH;

        try {
            $data = [
                "origin" => array(
                    "name"          => $origin["name"],
                    "company"       => $origin["company"],
                    "email"         => $origin["email"],
                    "phone"         => $origin["phone"],
                    "street"        => $origin["street"],
                    "number"        => $origin["number"],
                    "district"      => $origin["district"],
                    "city"          => $origin["city"],
                    "state"         => $origin["state"],
                    "country"       => $origin["country"],
                    "postalCode"    => $origin["postalCode"]
                ),
                "shipment" => [
                    "carrier" => $shipment["carrier"],
                    "type"    => 1,
                    "pickup" => [
                        "timeFrom"  => $shipment["timeFrom"],
                        "timeTo"    => $shipment["timeTo"],
                        "date"      => $shipment["date"],
                        "instructions"  => "N/A",
                        "totalPackages" => 1,
                        "totalWeight"   => $package["weight"]
                    ],
                    "settings" =>[
                            "currency"    => "MXN",
                            "labelFormat" => "pdf"
                    ]
                ]
            ];

            $options = array(
                'http' => array(
                    'header' => [
                        "Content-Type: application/json",
                        "Authorization: Basic ".$this->token
                    ],
                    'method' => "POST",
                    'content' => json_encode($data)
                ),
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                )
            );
            $context  = stream_context_create($options);
            $json = file_get_contents($url, false, $context);
            return json_decode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
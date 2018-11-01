<?php

namespace Jplarar\EnviapaqueteriaBundle\Services;

/**
 * Reference: https://api.envia.com/doc.php#reference
 * Class EnviapaqueteriaClient
 * @package Jplarar\EnviapaqueteriaBundle\Services
 */
class EnviapaqueteriaClient
{

    const ENDPOINT = "https://api.envia.com";
    const ENDPOINT_DEV = "https://api-test.envia.com";

    const RATE_PATH = "/ship/rate/";
    const GENERATE_PATH = "/ship/generate/";
    const PICK_UP_PATH = "/ship/pickup/";

    // NOT ON USER
    const CANCEL_PATH = "/ship/cancel/";
    const TRACK_PATH = "/ship/generaltrack/";

    protected $user;
    protected $password;
    protected $url;

    /**
     * AmazonSESClient constructor.
     * @param $enviapaqueteria_user
     * @param $enviapaqueteria_password
     * @param $environment
     */
    public function __construct($enviapaqueteria_user, $enviapaqueteria_password, $environment = "prod")
    {
        $this->user = $enviapaqueteria_user;
        $this->password = $enviapaqueteria_password;
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
        $username = $this->user;
        $password = $this->password;

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
                    "postalCode"    => $origin["zip"]
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
                    "postalCode"    => $destination["postalCode"]
                ),
                "package" => array(
                    "content"   => $package["content"],
                    "amount"    => $package["amount"],
                    "type"      => $package["type"],
                    "dimensions" => array(
                        "length" => $package["dimensions_length"],
                        "width"  => $package["dimensions_width"],
                        "height" => $package["dimensions_height"]
                    ),
                    "weight" => $package["weight"],
                    "insurance" => $package["insurance"],
                    "declaredValue" => $package["declaredValue"]
                ),
                "shipment" => array(
                    "carrier" => $shipment["carrier"]
                )
            ];

            $options = array(
                'http' => array(
                    'header' => [
                        "Content-Type: application/json",
                        "Authorization: Basic ".base64_encode("$username:$password")
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
            $response = json_decode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            // Error response
            if ($response["meta"] != "rate") {
                return false;
            }

            return $response["data"];

        } catch (\Exception $e) {
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
        $username = $this->user;
        $password = $this->password;

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
                    "postalCode"    => $origin["zip"]
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
                    "postalCode"    => $destination["postalCode"]
                ),
                "package" => array(
                    "content"   => $package["content"],
                    "amount"    => $package["amount"],
                    "type"      => $package["type"],
                    "dimensions" => array(
                        "length" => $package["length"],
                        "width"  => $package["width"],
                        "height" => $package["height"]
                    ),
                    "weight"        => $package["weight"],
                    "insurance"     => $package["insurance"],
                    "declaredValue" => $package["declaredValue"]
                ),
                "shipment" => array(
                    "carrier"   => $shipment["carrier"],
                    "service"   => $shipment["service"]
                ),
                "settings"=> array(
                    "currency"=> "MXN",
                    "labelFormat"=> "PDF",
                    "labelSize"=> "PAPER_7X4.75"
                )
            ];

            $options = array(
                'http' => array(
                    'header' => [
                        "Content-Type: application/json",
                        "Authorization: Basic ".base64_encode("$username:$password")
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
            $response = json_decode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            // Error response
            if ($response["meta"] != "generate") {
                return false;
            }

            return $response["data"];

        } catch (\Exception $e) {
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
        $username = $this->user;
        $password = $this->password;

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
                    "postalCode"    => $origin["zip"]
                ),
                "package" => array(
                    "content"   => $package["content"],
                    "amount"    => 1,
                    "type"      => "box",
                    "dimensions" => array(
                        "length" => $package["dimensions_length"],
                        "width"  => $package["dimensions_width"],
                        "height" => $package["dimensions_height"]
                    ),
                    "weight" => $package["weight"],
                    "insurance" => $package["insurance"],
                    "declaredValue" => $package["declaredValue"]
                ),
                "shipment" => [
                    "carrier" => $shipment["carrier"],
                    "service" => $shipment["service"],
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
                        "Authorization: Basic ".base64_encode("$username:$password")
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
            $response = json_decode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            // Error response
            if ($response["meta"] != "pickup") {
                return false;
            }

            return $response["data"];

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
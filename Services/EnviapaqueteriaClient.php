<?php

namespace Jplarar\EnviapaqueteriaBundle\Services;

/**
 * Reference: https://www.enviapaqueteria.com/documentacion-api#documenter-1
 * Class EnviapaqueteriaClient
 * @package Jplarar\EnviapaqueteriaBundle\Services
 */
class EnviapaqueteriaClient
{

    const ENDPOINT = "https://www.enviapaqueteria.com";
    const ENDPOINT_DEV = "https://enviapaqueteria-staging.herokuapp.com";

    const QUOTE_PATH = "/ws-enviapaqueteria/cotizar";
    const CREATE_PATH = "/ws-enviapaqueteria/generar";

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
     * https://www.enviapaqueteria.com/documentacion-api#documenter-3-2
     * @param $origin
     * @param $destination
     * @param $options
     * @return mixed|string
     */
    public function quote($provider, $origin, $destination, $options)
    {

        try {
            $data = [
                "data" => 
                    array(
                        "info_paqueteria" => array(
                            "paqueteria" => $provider["name"],
                            "tipo_servicio" => $provider["service"]
                        ),
                        "origen_representante" => $origin["representative"],
                        "origen_empresa" => $origin["company"],
                        "origen_email" => $origin["email"],
                        "origen_tel" => $origin["phone"],
                        "origen_pais" => $origin["country"],
                        "origen_direccion" => $origin["address1"],
                        "origen_direccion2" => $origin["address2"],
                        "origen_extra" => $origin["addressExtra"],
                        "origen_cp" => $origin["zipCode"],
                        "destino_representante" => $destination["representative"],
                        "destino_empresa" => $destination["company"],
                        "destino_email" => $destination["email"],
                        "destino_tel" => $destination["phone"],
                        "destino_pais" => $destination["country"],
                        "destino_direccion" => $destination["address1"],
                        "destino_direccion2" => $destination["address2"],
                        "destino_extra" => $destination["addressExtra"],
                        "destino_cp" => $destination["zipCode"],
                        "contenido" => $options["content"],
                        "seguro" => $options["insurance"],
                        "valor_declarado" => $options["value"],
                        "alto" => $options["height"],
                        "ancho" => $options["width"],
                        "largo" => $options["length"],
                        "peso" => $options["weight"],
                        "num_guias" => $options["amount"],
                        "agendar_recoleccion" => $options["collection"],
                        "hora_recoleccion" => $options["collection_time"],
                        "hora_limite" => $options["collection_time_limit"],
                        "fecha_recoleccion" => $options["collection_date"]
                    )
            ];

            $options = array(
                'http' => array(
                    'header' => ["Content-Type: application/json", "Authorization: Basic " . base64_encode("$this->user:$this->password")],
                    'method' => "POST",
                    'content' => json_encode($data)
                ),
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                )
            );

            $context = stream_context_create($options);
            $response = file_get_contents($this->url.self::QUOTE_PATH, false, $context);
            $response = json_decode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            //return file_get_contents($this->url.self::QUOTE_PATH, false, $context);
            //return $response;

            if ($response[0]["status"] != "success") {
                return false;
            }

            $data = $response[0]["data"];
            return $data;

        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }


    public function create($provider, $origin, $destination, $options)
    {

        try {
            $data = [
                "data" =>
                    array(
                        "info_paqueteria" => array(
                            "paqueteria" => $provider["name"],
                            "tipo_servicio" => $provider["service"]
                        ),
                        "origen_representante" => $origin["representative"],
                        "origen_empresa" => $origin["company"],
                        "origen_email" => $origin["email"],
                        "origen_tel" => $origin["phone"],
                        "origen_pais" => $origin["country"],
                        "origen_direccion" => $origin["address1"],
                        "origen_direccion2" => $origin["address2"],
                        "origen_extra" => $origin["addressExtra"],
                        "origen_cp" => $origin["zipCode"],
                        "destino_representante" => $destination["representative"],
                        "destino_empresa" => $destination["company"],
                        "destino_email" => $destination["email"],
                        "destino_tel" => $destination["phone"],
                        "destino_pais" => $destination["country"],
                        "destino_direccion" => $destination["address1"],
                        "destino_direccion2" => $destination["address2"],
                        "destino_extra" => $destination["addressExtra"],
                        "destino_cp" => $destination["zipCode"],
                        "contenido" => $options["content"],
                        "seguro" => $options["insurance"],
                        "valor_declarado" => $options["value"],
                        "alto" => $options["height"],
                        "ancho" => $options["width"],
                        "largo" => $options["length"],
                        "peso" => $options["weight"],
                        "num_guias" => $options["amount"],
                        "agendar_recoleccion" => $options["collection"],
                        "hora_recoleccion" => $options["collection_time"],
                        "hora_limite" => $options["collection_time_limit"],
                        "fecha_recoleccion" => $options["collection_date"],
                        "tipo_impresion" => $options["file"],
                        "tipo_papel" => $options["paper"],
                        "num_paq_recoleccion" => $options["number_of_packages"],
						"peso_total_paq_recoleccion" => $options["total_weight"]
                    )
            ];

            $options = array(
                'http' => array(
                    'header' => ["Content-Type: application/json", "Authorization: Basic " . base64_encode("$this->user:$this->password")],
                    'method' => "POST",
                    'content' => json_encode($data)
                ),
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                )
            );

            $context = stream_context_create($options);
            $response = file_get_contents($this->url.self::CREATE_PATH, false, $context);
            $response = json_decode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            return $response;
            // if ($response[0]["status"] != "success") {
            //     return $response;
            // }

            // $data = $response[0]["data"];
            // return $data;

        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }
}
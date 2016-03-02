<?php
/*
* Plugin Name: Sermepa plugin
* Description: Plugin para crear con un short code un botón de pago de la plataforma sermepa. Ejemplo de uso: [tpv_s importe="11,30" boton="Pagar Ahora" descripcion="producto de prueba 1"]
* Version: 1.0
* Author: Manuel Angel Fernández
* Author URI: http://rastreador.com.es
*/

define( 'SERMEPA__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'SERMEPA__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( SERMEPA__PLUGIN_DIR . 'Tpv.php' );

function tpv_sermepa($atts) {
//include_once('Tpv.php');

          extract(shortcode_atts(array(
                'descripcion' => '',
                'importe' => '1,00',
                'boton' => 'Pagar',
          ), $atts));

try{
    //Key de ejemplo
    $key = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';
    $url_tienda = 'http://pruebas.zentinet.com';
    $nombre_comercio = 'Montañas del Norte';

    $redsys = new Sermepa\Tpv\Tpv();
    $redsys->setAmount($importe);
    $redsys->setOrder(time());
    $redsys->setMerchantcode('999008881'); //Reemplazar por el código que proporciona el banco
    $redsys->setCurrency('978');
    $redsys->setTransactiontype('0');
    $redsys->setTerminal('1');
    $redsys->setNotification(SERMEPA__PLUGIN_URL.'notificacion.php'); //Url de notificacion
    $redsys->setUrlOk($url_tienda.'/ok.php'); //Url OK
    $redsys->setUrlKo($url_tienda.'/ko.php'); //Url KO
    $redsys->setVersion('HMAC_SHA256_V1');
    $redsys->setTradeName($nombre_comercio);
//    $redsys->setTitular('Pedro Risco');
    $redsys->setProductDescription($descripcion);
    $redsys->setEnviroment('test'); //Entorno test

    $redsys->setAttributesSubmit('btn_submit', 'btn_submit',$boton);

    $signature = $redsys->generateMerchantSignature($key);
    $redsys->setMerchantSignature($signature);

    $form = $redsys->createForm();
}
catch(Exception $e){
    echo $e->getMessage();
}
return $form;

}
add_shortcode('tpv_s', 'tpv_sermepa');



?>

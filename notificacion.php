try{
    $redsys = new Sermepa\Tpv\Tpv();
    $key = 'sq7HjrUOBfKmC576ILgskD5srU870gJ7';

    $parameters = $redsys->getMerchantParameters($_POST["Ds_MerchantParameters"]);
    $DsResponse = $parameters["Ds_Response"];
    $DsResponse += 0;
    if ($redsys->check($key, $_POST) && $DsResponse <= 99) {
        //acciones a realizar si es correcto, por ejemplo validar una reserva, mandar un mail de OK, guardar en bbdd o contactar con mensajería para preparar un pedido
	echo "Todo correcto";
	$fichero = 'notificacion.txt';
	file_put_contents($fichero, $,arameters FILE_APPEND | LOCK_EX);

    } else {
        //acciones a realizar si ha sido erroneo
	echo "mal";
    }
}
catch(Exception $e){
    echo $e->getMessage();
}

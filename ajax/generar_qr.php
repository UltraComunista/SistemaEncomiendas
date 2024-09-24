<?php
$secret_key = "153fe106-7ce4-4933-b206-f587f2586bd2";
$username = "Gestiondeenviosdeencomiendas";
$password = "zK*LRT?*0i";

// Tomamos el monto enviado por AJAX
$monto = $_POST['monto'];

// Datos para generar el QR
$data = array(
    "secret_key" => $secret_key,
    "monto" => $monto,
    "data" => [],
    "vigencia" => "120/23:30",
    "uso_unico" => true,
    "detalle" => "Pago de encomienda"
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://veripagos.com/api/bcp/generar-qr");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'
));
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);

// Enviamos la respuesta de vuelta al AJAX
echo $response;
?>

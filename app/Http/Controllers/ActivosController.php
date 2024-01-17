<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use PDOException;

class ActivosController extends Controller
{
    public static function authos($request)
    {

        // $json = ['vehicle'=>
        // ['appraisalValue' => "73",'brand'=> "DAYTONA",'carRegistration'=> "IR366E",'city'=> "PAUTE",'cylinderCapacity'=> "125",'dateOfLastCarRegistration'=>"",'model'=> "DY125V-B",'subClassName'
        //     => "",'vehicleType'=> "MOTOCICLETA",'year'=>"2009",'yearofPayment'=> "2019",'image'=> 'media/vehicle/moto.png']];

        // return $json;

        $tablas = [
            'vehicle',
            'ant'
        ];
        try {
            $sql = "exec sp_consulta_informacion_adicional ?";
            $pdo = DB::connection('sqlsrv_diver')->getPdo();
            $sentencia = $pdo->prepare($sql);
            $sentencia->execute([$request->nombre]);

            $data = [];
            $i = 0;
            do {
                $conjunto_filas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                

                if(count($conjunto_filas) > 0){
                    
                    $data[$tablas[$i]] = $conjunto_filas;
                    //$data[$tablas[$i]]=$conjunto_filas;
                    $i++;
                }
                

                //$data[]=$conjunto_filas;
            } while ($sentencia->nextRowset());
        } catch (PDOException $e) {
            dd($e);
        }

        if(count($data)){
            if (isset($data['vehicle']) > 0) {
                foreach ($data['vehicle'] as $key => $value) {
                    $data['vehicle'][$key]['image'] = SELF::getImageVehiculo($value['vehicleType']); 
                }
            }
            if (isset($data['ant'])) {
                foreach ($data['ant'] as $key => $value) {
                    $data['ant'][$key]['image'] = SELF::getImageVehiculo($value['vehicleType']); 
                }
            }
        }
        // dd($data);

        
        // dd($data);
        // if (count($data['vehicle']) == 0) {
        //     return $this->errorResponse404();
        // }
        
        return $data;
    }

    public static function property($request)
    {

        // $json = [
        //     ['additionalRatings'=> "0",'constructionArea'=> "128,71",'constructionValuation'=> "44019,14",'dni'=> "1723199186",'economicDestination'=> "HABITACIONAL",'estateNumber'=> 
        //     "1266841",'front'=> "2,99",'landArea'=> "61,68",'landValuation'=> "7402,57",'latitude'=> "",'mainStreet'=> "LUIS ESPINOSA TAMAYO",'name'=> "HERRERA MEDEL HERIBERTO ALEJANDRO",'neighborhoodSector'
        //     => "PINAR ALTO",'number'=> "",'ownerType'=> "NATURAL",'parish'=> "COCHAPAMBA",'percentageOfShares'=> "100",'phone'=> "",'primaryUse'=> "CASA",'property'=> "HOR",'streetCode'
        //     => "",'totalRating'=> "51504,07",'whoElse'=> "",'zone'=> "4 NORTE O EUGENIO ESPEJO",'zoneType'=> "URBANO"]
        // ];

        // return $json;

        // $sql = "SELECT 
		// NUMERO_PREDIO as estateNumber,
		// CEDULA_RUC as dni ,
		// NOMBRE as name ,
		// PORCENTAJE_ACCIONES as percentageOfShares ,
		// QUIEN_MAS as whoElse,
		// TELEFONOS as phone,
		// TIPO_PROPIETARIO as ownerType ,
		// ZONA as zone ,
		// PARROQUIA as parish,
		// TIPO_ZONA as  zoneType,
		// Latitud as latitude,
		// CODIGO_CALLE as streetCode ,
		// CALLE_PRINCIPAL as mainStreet ,
		// NUMERO as number,
		// BARRIO_SECTOR as neighborhoodSector,
		// DESTINO_ECONOMICO as economicDestination,
		// FRENTE as front ,
		// AREA_TERRENO as landArea,
		// AREA_CONSTRUCCION as constructionArea ,
		// VALORACION_CONSTRUCCION as constructionValuation ,
		// VALORACION_TERRENO as landValuation ,
		// VALORACION_ADICIONALES as additionalRatings ,
		// VALORACION_TOTAL as totalRating,
		// USO_PRINCIPAL as primaryUse,
		// PROPIEDAD as property
		// FROM
		// CATASTRO_UIO_NEW
		// WHERE
		// CEDULA_RUC=?";

        $sql = "exec sp_consulta_propiedades ?";
        $pdo = DB::connection('sqlsrv_diver')->getPdo();
        $sentencia = $pdo->prepare($sql);
        $sentencia->execute([$request->nombre]);

        $conjunto_filas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        if (count($conjunto_filas) == 0) {
            $conjunto_filas = SELF::searchPropiedad($request->nombre);
        }


        return $conjunto_filas;
    }

    public static function getImageVehiculo($tipo)
    {
        $img_profile = 'media/vehicle/car.png';
        
        if ($tipo == 'MOTOCICLETA') {
            $img_profile = 'media/vehicle/moto.png';
        }

        if ($tipo == 'CAMIONETA') {
            $img_profile = 'media/vehicle/camioneta.png';
        }
        
        if ($tipo == 'AUTOMOVIL') {
            $img_profile = 'media/vehicle/car.png';
        }

        if ($tipo == 'VEHICULO ESPECIAL') {
            $img_profile = 'media/vehicle/vehicle-special.png';
        }

        if ($tipo == 'VEHICULO UTILITARIO') {
            $img_profile = 'media/vehicle/vehicle-special.png';
        }
        if ($tipo == 'JEEP') {
            $img_profile = 'media/vehicle/jeep.png';
        }
        if ($tipo == 'CAMION') {
            $img_profile = 'media/vehicle/truck.png';
        }
        if ($tipo == 'OMNIBUS') {
            $img_profile = 'media/vehicle/bus.png';
        }
        if ($tipo == 'TANQUERO') {
            $img_profile = 'media/vehicle/truck.png';
        }
        if ($tipo == 'TRAILER') {
            $img_profile = 'media/vehicle/trailer.png';
        }
        if ($tipo == 'VOLQUETA') {
            $img_profile = 'media/vehicle/volquete.png';
        }

        return $img_profile;
    }

    public static function searchPropiedad($cedula)
    {

        $apiURL = "https://enlinea.cuenca.gob.ec/BackendConsultas/api/contribuyentes/$cedula/predios";
        // 'pagina=1&nitems=30&filtro=-1&filtro2=-1'
        $postInput = [
            'pagina' => '1',
            'nitems' => '30',
            'filtro' => '-1',
            'filtro2' => '-1'
        ];

        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->request('GET', $apiURL, ['query' => $postInput]);    
        }
        catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
        }

        if($response->getStatusCode() == 404){
            return [];
        }
        // $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        $body = $responseBody[0];

        try{
            $sql = "INSERT INTO CATASTRO_CUE
                (CLAVE_CATASTRAL, CEDULA, NOMBRES, CALLE, NUMERO, AREA_TERRENO, AREA_CONSTRUCCION, AVALUO_TERRENO, AVALUOS_CONSTRUCCION, CLAVE_ANTERIOR, PARROQUIA, PRE_NUMERO_INSCRIPCION, RNUM)
                VALUES(:CLAVE_CATASTRAL, :CEDULA, :NOMBRES, :CALLE, :NUMERO, :AREA_TERRENO, :AREA_CONSTRUCCION, :AVALUO_TERRENO, :AVALUOS_CONSTRUCCION, :CLAVE_ANTERIOR, :PARROQUIA, :PRE_NUMERO_INSCRIPCION, :RNUM)";
            $pdo = DB::connection('sqlsrv_diver')->getPdo();
            $sentencia = $pdo->prepare($sql);
            $sentencia->execute($body);
        } catch (\PDOException $e) {
            return "Error: " . $e->getMessage();
        }

        $data = [
            'CEDULA' => $body['CEDULA'],
            'PREDIO' => $body['CLAVE_CATASTRAL'],
            'PARROQUIA' => $body['PARROQUIA'],
            'AREA_TERRENO' => $body['AREA_TERRENO'],
            'AREA_CONSTRUCCION' => $body['AREA_CONSTRUCCION'],
            'CALLE' => $body['CALLE'],
            'NUMERO' => $body['NUMERO'],
        ];

        return $data;
    }
}

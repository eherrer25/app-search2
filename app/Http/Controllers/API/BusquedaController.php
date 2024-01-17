<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ActivosController;
use App\Http\Controllers\BusquedaController as ControllersBusquedaController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LaboralController;
use App\Models\ApiReport;
use App\Models\Contacto;
use App\Models\QueryReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class BusquedaController extends BaseController
{
    
    public function index(Request $request)
    {
        $user = Auth::user();
        $cont =  ApiReport::where('user_id',Auth::user()->id)->whereYear('created_at',date('Y'))->whereMonth('created_at',date('m'))->count();
        $fechaActual = Carbon::createFromFormat('d-m-Y',date('d-m-Y'));
        $fecha = Carbon::createFromFormat('Y-m-d',$user->fecha_cont)->addMonth();
        $compare = $fechaActual->lte($fecha) ? true : false;


        if($cont <= $user->cont && $compare){
            //  $json = ["placeOfBirth" => "CHILE",
            //             "fullname" => "HERRERA DALDO ERICK DANIEL",
            //             "dni" => "0150631828",
            //             "gender" => "MASCULINO",
            //             "civilStatus" => "SOLTERO",
            //             "marriageDate" => " ",
            //             "dateOfBirth" => "25/3/1992",
            //             "dateOfDeath" => "",
            //             "citizenship" => "CHILENA",
            //             "age" => 30,
            //             "studyLevel" => null,
            //             "address" => "PANAMERICANA NORTE FRENTE AL MKM 14",
            //             "profession" => null,
            //             "familyName" => ["spouse" => " ",
            //                 "dad" => "HERRERA MEDEL HERIBERTO ALEJANDRO",
            //                 "mom" => "DALDO CORTES EDITH TERESA"],
            //             "family" => [],
            //             "salary" => "0",
            //             "credits" => [
            //                 ['banck'=> "ASOCIACION MUTUALISTA DE AHORRO Y CREDITO PARA LA VIVIENDA PICHINCHA", 'type' =>"CDC", 'cedit' =>"NO DEFINIDO", 'score' => "NO DEFINIDO", 'CALIFICACI' => "NO DEFINIDO"],
            //                 ['banck' => "AUSTRO", 'type' => "Tarjeta", 'cedit' => "Consumo", 'score' => "99%", 'CALIFICACI' => "A1"],
            //                 ['banck' => "BANCO DE GUAYAQUIL", 'type' => "G", 'cedit' => "Comercial", 'score' => "99%", 'CALIFICACI' => "A1"]
            //             ],
            //             "assessment" => 10,
            //             "qualification" => null
            //         ];
                $con = new ControllersBusquedaController;
                $infoPersonal = $con->informacionPersonal($request);
                
                $sqlS = 'SELECT CAST(ROUND([SALARIO], 2, 1) AS DECIMAL(20,2)) AS SALARIO
                    FROM
                    [dbo].ies_new
                    WHERE
                    NUMAFI=?';
                $pdo = DB::connection('sqlsrv_diver')->getPdo();
                $sentenciaS = $pdo->prepare($sqlS);
                $sentenciaS->execute([$request->nombre]);
                $salario = $sentenciaS->fetch(PDO::FETCH_ASSOC);
                $infoPersonal['salary'] = $salario ?  $salario['SALARIO'] : 0;

                $laboral = LaboralController::laboral($request);
                $contacto = ContactoController::contacto($request);
                $vehiculos = ActivosController::authos($request);
                $propiedades = ActivosController::property($request);

                $data = [
                    'personal' => $infoPersonal,
                    'laboral' => $laboral,
                    'contacto' => $contacto,
                    'vehiculos' => $vehiculos,
                    'propiedades' => $propiedades,
                ];

                $this->generarReporte($request,$infoPersonal);

            return $this->sendResponse($data, 'Data retrieved successfully.');

        }

       return $this->sendError('Excede el máximo.', ['error'=>'Llego al máximo de sus busquedas.']);
    }

    public function generarReporte($request,$info)
    {
        $user = $request->user();
        $dat = [
            'user_id' => $user->id,
            'dni' => trim($request->nombre),
            'description' => ''.(isset($info['fullname']) ? $info['fullname'] : $info['razonSocial'])
        ];

        ApiReport::create($dat);
    }


    public function busquedaTest(Request $request){
        $user = Auth::user();
        if($user->company == 'Demo Api'){
            if($request->nombre == '1'){
                return $this->generarDemo();
            }

            return $this->sendError('Excede el máximo.', ['error'=>'Llego al máximo de sus busquedas.']);
            
        }
    }

    public function generarDemo()
    {
        
        $infoPersonal = ["placeOfBirth" => "AZUAY/PAUTE/PAUTE",
                    "fullname" => "VICUÑA CHACON ERICK DAMIAN",
                    "dni" => "0104992300",
                    "gender" => "MASCULINO",
                    "civilStatus" => "CASADO",
                    "marriageDate" => "31/7/2020",
                    "dateOfBirth" => "13/6/1995",
                    "dateOfDeath" => "",
                    "citizenship" => "ECUATORIANA",
                    "age" => 28,
                    "studyLevel" => null,
                    "address" => "CALLE DE LA QUEBRADA LA INDEPESN",
                    "profession" => "INGENIERO",
                    "familyName" => ["spouse" => "GENOVEZ QUIMIS DOMENICA FERNANDA",
                        "dad" => ["nombre" => "VICUÑA LOPEZ PABLO VELISARIO","cedula"=>"0103422622"],
                        "mom" => ["nombre"=> "CHACON MOSCOSO GLORIA ENRIQUETA"]
                    ],
                    "family" => [
                        [
                            "relationship"=> "padre",
                            "fullname"=> "VICUÑA LOPEZ PABLO VELISARIO",
                            "dni"=> "0103422622",
                            "dateOfBirth"=> "18/7/1973",
                            "citizenship"=> "ECUATORIANA",
                            "civilStatus"=> "DIVORCIADO",
                            "age"=> 50,
                            "gender"=> "MASCULINO"
                        ],
                        [
                            "relationship"=> "madre",
                            "fullname"=> "GUZMAN ROMERO ANGELA DE JESUS",
                            "dni"=> "0904557683",
                            "dateOfBirth"=> "2/8/1949",
                            "citizenship"=> "ECUATORIANA",
                            "civilStatus"=> "SOLTERO",
                            "age"=> 74,
                            "gender"=> "FEMENINO"
                        ],
                        [
                            "relationship"=> "conyuge",
                            "fullname"=> "GENOVEZ QUIMIS DOMENICA FERNANDA",
                            "dni"=> "0107418618",
                            "dateOfBirth"=> "2/4/1996",
                            "citizenship"=> "ECUATORIANA",
                            "civilStatus"=> "CASADO",
                            "age"=> 27,
                            "gender"=> "FEMENINO"
                        ]
                    ],
                    "salary" => 1306,
                    "credits" => [
                        ['banck'=> "ASOCIACION MUTUALISTA DE AHORRO Y CREDITO PARA LA VIVIENDA PICHINCHA", 'type' =>"CDC", 'cedit' =>"NO DEFINIDO", 'score' => "NO DEFINIDO", 'CALIFICACI' => "NO DEFINIDO"],
                        ['banck' => "AUSTRO", 'type' => "Tarjeta", 'cedit' => "Consumo", 'score' => "99%", 'CALIFICACI' => "A1"],
                        ['banck' => "BANCO DE GUAYAQUIL", 'type' => "G", 'cedit' => "Comercial", 'score' => "99%", 'CALIFICACI' => "A1"]
                    ],
                    "assessment" => 10,
                    "qualification" => null
        ];

        $laboral = [
            "taxContribution" => null,
            "ownInfoCompany" =>  null,
            "jobInfoCompany" => [
                ["position"=> "INSPECTOR",
                "salary"=> 1306,
                "admissionDate"=> "16/08/2021",
                "fireDate"=> "",
                "ruc"=> "0160050450001",
                "legalName"=> "EMPRESA PUBLICA DE ARIDOS Y ASFALTOS DEL AZUAY, ASFALTAR EP",
                "address"=> "EL EX CREA. AV. MEXICO. S/N. AV. DE LAS AMERICAS. ZONAL 6 EX CREA.",
                "phone"=>"072867931",
                "email"=> "edamvicuna@gmail.com",
                "codeBranchOffice"=> "0001",
                "heritage"=> ""]
            ],
            "societyInfoCompany" => []
        ];

        $contacto = [
            'address' =>
                [['address'=> "CUENCA", 'type' => "actualizado", 'province' => "sin datos", 'city' => "sin datos", 'alias' => "dirafi"]],
            'emails' => 
                [['email' => "edamvicuna@gmail.com", 'type' => "actualizado", 'alias' => "email"]],
            'phones'=> [['phone'=> "0979185924", 'type' => "actualizado", 'alias' => "celular"]]
        ];

        $vehiculos = ['vehicle'=>
                    ['appraisalValue' => "73",'brand'=> "DAYTONA",'carRegistration'=> "IR366E",'city'=> "PAUTE",'cylinderCapacity'=> "125",'dateOfLastCarRegistration'=>"",'model'=> "DY125V-B",'subClassName'
        => "",'vehicleType'=> "MOTOCICLETA",'year'=>"2009",'yearofPayment'=> "2019",'image'=> 'media/vehicle/moto.png']];

        $propiedades = [
            ['additionalRatings'=> "0",'constructionArea'=> "128,71",'constructionValuation'=> "44019,14",'dni'=> "0104992300",'economicDestination'=> "HABITACIONAL",'estateNumber'=> 
            "1266841",'front'=> "2,99",'landArea'=> "61,68",'landValuation'=> "7402,57",'latitude'=> "",'mainStreet'=> "LUIS ESPINOSA TAMAYO",'name'=> "JUAN PEREZ",'neighborhoodSector'
            => "PINAR ALTO",'number'=> "",'ownerType'=> "NATURAL",'parish'=> "COCHAPAMBA",'percentageOfShares'=> "100",'phone'=> "",'primaryUse'=> "CASA",'property'=> "HOR",'streetCode'
            => "",'totalRating'=> "51504,07",'whoElse'=> "",'zone'=> "4 NORTE O EUGENIO ESPEJO",'zoneType'=> "URBANO"]
        ];

        $data = [
            'personal' => $infoPersonal,
            'laboral' => $laboral,
            'contacto' => $contacto,
            'vehiculos' => $vehiculos,
            'propiedades' => $propiedades,
        ];

        return $this->sendResponse($data, 'Data retrieved successfully.');
    }
}

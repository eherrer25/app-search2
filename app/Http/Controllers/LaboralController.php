<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use PDOException;

class LaboralController extends Controller
{
    public static function laboral(Request $request)
    {
        // $json = [
        //     "taxContribution" => null,
        //     "ownInfoCompany" =>  [[
        //         "address" => "VIA A CHALLUABAMBA S/N  A CUADRA Y MEDIA DEL PARQUE DE QUINTA CHICA",
        //         "province" => "AZUAY - CUENCA - NULTI",
        //         "ruc" => "0150631828001       ",
        //         "activitiesStartDate" => "04/11/2014",
        //         "suspensionRequestDate" => "06/07/2018",
        //         "legalName" => "MOVIE CENTER",
        //         "activitiesRestartDate" => "",
        //         "phone" => "",
        //         "taxpayerStatus" => "SUSPENDIDO",
        //         "email" => "daniielsb@live.com",
        //         "economicActivity" => "ACTIVIDADES DE PREPARACIÓN Y SERVICIO DE BEBIDAS PARA SU CONSUMO INMEDIATO EN: CAFÉS, TIENDAS DE JUGOS DE FRUTA, VENDEDORES AMBULANTES DE BEBIDAS, ETCÉTERA.",
        //         "businessName" => "MOVIE CENTER"
        //     ]],
        //     "jobInfoCompany" => [[
        //         "position" => "INGENIERO ELECTRÓNICO ESPECIALISTA EN MA",
        //         "salary" => 2919.42,
        //         "admissionDate" => "01/02/2020",
        //         "fireDate" => "",
        //         "ruc" => "1793121578001",
        //         "legalName" => "SERVICE DIVERSITY & DATA DIVERSERVI S.A.",
        //         "address" => "PARQUE DE LA MADRE. FEDERICO MALO . 0. 12 DE ABRIL. PARQUE DE LA MADRE",
        //         "phone" => "0998652210",
        //         "email" => "marcesalcedoc@hotmail.es",
        //         "codeBranchOffice" => "",
        //         "heritage" => ""
        //     ]],
        //     "societyInfoCompany" => [
        //         ['address'=> "AV. FEDERICO MALO S/N DOCE DE ABRIL ", 'province'=> "AZUAY - CUENCA - HUAYNACAPAC",'activitiesRestartDate'=> "",'activitiesStartDate'=> "04/10/2018",
        //         'businessName' => "SERVICE DIVERSITY & DATA DIVERSERVI S.A.",'economicActivity'=> 
        //         "ACTIVIDADES DE PERSONAS, EMPRESAS Y OTRAS ENTIDADES QUE GESTIONAN CARTERAS Y FONDOS A CAMBIO DE UNA RETRIBUCIÓN O POR CONTRATO. SE INCLUYEN LAS SIGUIENTES ACTIVIDADES: GESTIÓN DE FONDOS DE PENSIONES, GESTIÓN DE FONDOS MUTUOS DE INVERSIÓN Y GESTIÓN DE OTRO",
        //         'email'=> "",'legalName'=> "SERVICE DIVERSITY % DATA DIVERSERVI",'phone'=>"",'position'=> "GERENTE GENERAL",'province'=> "AZUAY - CUENCA - HUAYNACAPAC",'ruc'=> "0190457591001",'suspensionRequestDate'=> "",'taxpayerStatus'=> "ACTIVO"]
        //     ]
        // ];

        // return $json;


        $tablas = [
            'I_OCUPACION',
            'I_sucursales',
            'I_sucursales_socio'
        ];
        try {
            $sql = "EXEC [dbo].[sp_consulta_ficha_laboral_cedula_new] ? ";
            $pdo = DB::connection('sqlsrv_diver')->getPdo();
            $sentencia = $pdo->prepare($sql);
            $sentencia->execute([$request->nombre]);

            $data = [];
            $i = 0;
            $e404 = 0;
            do {
                $conjunto_filas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                if ($conjunto_filas) {
                    $data[$tablas[$i]] = $conjunto_filas;
                } else {
                    $data[$tablas[$i]] = [];
                    $e404++;
                }
                $i++;
            } while ($sentencia->nextRowset());
        } catch (PDOException  $e) {
            dd($e);
        }



        // if ($i == $e404) {
        //     return $this->errorResponse404();
        // }

        $json = [
            "taxContribution" => null, // Aportes (solo el ultimo)
            "ownInfoCompany" => null,
            "jobInfoCompany" => [],
            "societyInfoCompany" => [],
        ];


        if (count($data['I_OCUPACION']) > 0) {
            //aqui 
            foreach ($data['I_OCUPACION'] as $key => $val) {
                $json["jobInfoCompany"][$key]["position"] = $val["OCUAFI"];
                $json["jobInfoCompany"][$key]["salary"] = $val["SALARIO"];
                $json["jobInfoCompany"][$key]["admissionDate"] = $val["FECINGAFI"];
                $json["jobInfoCompany"][$key]["fireDate"] = $val["FECSALAFI"];
                $json["jobInfoCompany"][$key]["ruc"] = trim($val["RUCEMP"]);
                $json["jobInfoCompany"][$key]["legalName"] = $val["NOMEMP"];
                $json["jobInfoCompany"][$key]["address"] = $val["DIRSUC"];
                $json["jobInfoCompany"][$key]["phone"] = $val["TELSUC"];
                $json["jobInfoCompany"][$key]["email"] = $val["EMAIL"];
                $json["jobInfoCompany"][$key]["codeBranchOffice"] = $val["CODSUC"];
                $json["jobInfoCompany"][$key]["heritage"] = ''; //$val["VALOR_PATRIMONIO"];
            }
        }
        if (count($data["I_sucursales"]) > 0) {

            $json["ownInfoCompany"][0]["address"] = $data['I_sucursales'][0]["direccion"];
            $json["ownInfoCompany"][0]["province"] = $data['I_sucursales'][0]["provincia"];
            $json["ownInfoCompany"][0]["ruc"] = $data['I_sucursales'][0]["NUMERO_RUC"];
            $json["ownInfoCompany"][0]["activitiesStartDate"] = $data['I_sucursales'][0]["FECHA_INICIO_ACTIVIDADES"];
            $json["ownInfoCompany"][0]["suspensionRequestDate"] = $data['I_sucursales'][0]["FECHA_SUSPENSION_DEFINITIVA"];
            $json["ownInfoCompany"][0]["legalName"] = $data['I_sucursales'][0]["NOMBRE_FANTASIA_COMERCIAL"];
            $json["ownInfoCompany"][0]["activitiesRestartDate"] = $data['I_sucursales'][0]["FECHA_REINICIO_ACTIVIDADES"];

            $json["ownInfoCompany"][0]["phone"] = $data['I_sucursales'][0]["TELEFONO"];
            $json["ownInfoCompany"][0]["taxpayerStatus"] = $data['I_sucursales'][0]["ESTADO_CONTRIBUYENTE"];
            $json["ownInfoCompany"][0]["email"] = $data['I_sucursales'][0]["CORREO_ELECTRONICO"];
            $json["ownInfoCompany"][0]["economicActivity"] = $data['I_sucursales'][0]["ACTIVIDAD_ECONOMICA"];
            $json["ownInfoCompany"][0]["businessName"] = $data['I_sucursales'][0]["NOMBRE_COMERCIAL"];
        }

        if (count($data["I_sucursales_socio"]) > 0) {
            foreach ($data["I_sucursales_socio"] as $key => $dat) {

                $json["societyInfoCompany"][$key]["address"] = $dat["direccion"];
                $json["societyInfoCompany"][$key]["province"] = $dat["provincia"];
                $json["societyInfoCompany"][$key]["ruc"] = $dat["NUMERO_RUC"];
                $json["societyInfoCompany"][$key]["activitiesStartDate"] = $dat["FECHA_INICIO_ACTIVIDADES"];
                $json["societyInfoCompany"][$key]["suspensionRequestDate"] = $dat["FECHA_SUSPENSION_DEFINITIVA"];
                $json["societyInfoCompany"][$key]["legalName"] = $dat["NOMBRE_FANTASIA_COMERCIAL"];
                $json["societyInfoCompany"][$key]["activitiesRestartDate"] = $dat["FECHA_REINICIO_ACTIVIDADES"];

                $json["societyInfoCompany"][$key]["phone"] = $dat["TELEFONO"];
                $json["societyInfoCompany"][$key]["taxpayerStatus"] = $dat["ESTADO_CONTRIBUYENTE"];
                $json["societyInfoCompany"][$key]["email"] = $dat["CORREO_ELECTRONICO"];
                $json["societyInfoCompany"][$key]["economicActivity"] = $dat["ACTIVIDAD_ECONOMICA"];
                $json["societyInfoCompany"][$key]["businessName"] = $dat["RAZON_SOCIAL"];
                $json["societyInfoCompany"][$key]["position"] = $dat["CARGO_REPRESENTANTE_LEGAL"];
            }
        }

        return $json;
    }
}

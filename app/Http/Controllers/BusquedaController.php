<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\QueryReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use PDOException;

class BusquedaController extends Controller
{
    private function estadoCivil($stado)
    {
        $statusc = "";
        switch ($stado) {
            case '0':
                $statusc = "indefinido";
                break;
            case '1':
                $statusc = "soltero";
                break;
            case '2':
                $statusc = "casado";
                break;
            case '3':
                $statusc = "divorciado";
                break;
            case '4':
                $statusc = "viudo";
                break;
            case '5':
                $statusc = "unionLibre";
                break;
            default:
                $statusc = "indefinido";
                break;
        }
        return $statusc;
    }
    // Esta lista la de informacion personal empieza aqui
    private function Edad($fechanacimiento)
    {
        
        list($dia, $mes, $ano) = explode("/", $fechanacimiento);
        $ano_diferencia  = date("Y") - ((int) $ano);
        $mes_diferencia = date("m") - ((int) $mes);
        $dia_diferencia   = date("d") - ((int) $dia);
        if (($dia_diferencia === 0 && $dia <= 0) || ($mes_diferencia < 0))
            $ano_diferencia--;
        return $ano_diferencia;
    }

    public function Familia(Request $request)
    {
        $tablas = [
            'consulta_1',
            'consulta_2',
            'consulta_3',
        ];
        try {
            $sql = "exec sp_consulta_familia_2_0 ?";
            $pdo = DB::connection('sqlsrv_diver')->getPdo();
            $sentencia = $pdo->prepare($sql);
            $sentencia->execute([
                ($request->has('nombre')) ? $request->nombre : 'NULL',
            ]);
            $data = [];
            $i = 0;
            do {
                $conjunto_filas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                $data[$tablas[$i]] = $conjunto_filas;
                //$data[$tablas[$i]]=$conjunto_filas;
                $i++;

                //$data[]=$conjunto_filas;
            } while ($sentencia->nextRowset());
        } catch (PDOException  $e) {
            dd($e);
        }
        $json = [];

        // return $this->showArray($data);

        foreach ($data["consulta_1"] as $val) {
            if (trim($val["Cedula"]) == trim($request->nombre)) {
                continue;
            }
            if (isset($val["tipo"])) {
                $json["family"][] = [
                    "relationship" => $val["tipo"],
                    "fullname" => $val["Nombres"],
                    "dni" => $val["Cedula"],
                    "dateOfBirth" => $val["FECHA_NACIMIENTO"],
                    "citizenship" => $val["Nacionalidad"],
                    "civilStatus" => $val["DES_ESTADO_CIVIL"], //$this->estadoCivil($val["EstadoCivil"]),

                    "age" => $this->Edad($val["FECHA_NACIMIENTO"]),
                    "gender" => ((int) $val["Sexo"] == 1) ? 'MASCULINO' : 'FEMENINO'
                ];
            }
        }
        if (count($data["consulta_1"]) == 0) {
            return '<p class="text-center pt-3">Sin datos</p>';
        }

        return view('busqueda-familia',compact('json'));
    }

    public function getImage($datos)
    {
        $img_profile = '/media/users/blank.png';

        if (!$datos['dateOfDeath']) {

            if ($datos['gender']  == 'FEMENINO') {
                $img_profile = 'media/users/baby-female.png';

                if ($datos['age'] > 5) {
                    $img_profile = 'media/users/child-female.png';
                }

                if ($datos['age'] > 15) {
                    $img_profile = 'media/users/young-female.png';
                }

                if ($datos['age'] > 25) {
                    $img_profile = 'media/users/adult-female.png';
                }

                if ($datos['age'] > 55) {
                    $img_profile = 'media/users/old-female.png';
                }
            }
            if ($datos['gender'] == 'MASCULINO') {
                $img_profile = 'media/users/baby-male.png';

                if ($datos['age'] > 5) {
                    $img_profile = 'media/users/child-male.png';
                }

                if ($datos['age'] > 15) {
                    $img_profile = 'media/users/young-male.png';
                }

                if ($datos['age'] > 25) {
                    $img_profile = 'media/users/adult-male.png';
                }

                if ($datos['age'] > 55) {
                    $img_profile = 'media/users/old-male.png';
                }
            }
        } else {
            $img_profile = 'media/users/deceased.png';
        }

        return $img_profile;
    }

    public function busqueda(Request $request)
    {
        
        return view('busqueda');
    }

    public function buscarTipo(Request $request)
    {

        // QueryReport::create($dat);

        switch ($request->tipo) {
            case 'dni':
                return $this->busquedaCedula($request);
                break;
            case 'nombre':
                return $this->busquedaNombre($request);
                break;
            case 'telefono':
                return $this->busquedaTelefono($request);
                break;
            case 'placa':
                return $this->busquedaPlaca($request);
                break;
            case 'ruc':
                return $this->busquedaRuc($request);
                break;
        }
    }

    public function busquedaCedula(Request $request)
    {
        // dd('llega');
        // $campo = $request->nombre;
        // $request = new Request(['dni' => '0150631828'], ['dni' => '0150631828'], ['dni' => '0150631828']);
        $infoPersonal = $this->informacionPersonal($request);

        $sqlV = 'SELECT count(*) as total
                FROM
                [dbo].VEHICULOS_NEW as v
                WHERE
                IDENTIFICACION_PROPIETARIO=?';
        $pdoV = DB::connection('sqlsrv_diver')->getPdo();
        $sentenciaV = $pdoV->prepare($sqlV);
        $sentenciaV->execute([$request->nombre]);
        $countV = $sentenciaV->fetch(PDO::FETCH_ASSOC);

        $sqlS = 'SELECT CAST(ROUND([SALARIO], 2, 1) AS DECIMAL(20,2)) AS SALARIO
                FROM
                [dbo].ies_new
                WHERE
                NUMAFI=?';
        // $pdoS = DB::connection('sqlsrv_diver')->getPdo();
        $sentenciaS = $pdoV->prepare($sqlS);
        $sentenciaS->execute([$request->nombre]);
        $salario = $sentenciaS->fetch(PDO::FETCH_ASSOC);
        // $laboral = $this->fichaLaboralCedulaNew($request);
        // $contacto = $this->InforamcionDeContacto($request);
        // $vehiculos = $this->authos($request);
        // $propiedades = $this->property($request);

        $img_profile = $this->getImage($infoPersonal);
        $this->generarReporte($request,$infoPersonal);

        return view('busqueda-view', compact('infoPersonal','img_profile','countV','salario')); 
    }

    public function busquedaNombre(Request $request)
    {
        
        $data = DB::connection('sqlsrv_diver')->select("EXEC usp_consulta_datos2 1,?", [$request->nombre]);

        // dd($data);
        if (count($data) == 0) {
            return redirect()->back()->with('danger','No se encontró información o ocurrío un error.');
            // return response('error', 404);
        }
        
        foreach ($data as $key => $value) {
            $data[$key]->age = $this->Edad($value->dateOfBirth);
        }

        // dd($data);
        
        $this->generarReporte($request,$data);

        return view('busqueda-nombre', compact('data')); 
    }

    public function busquedaTelefono(Request $request)
    {
        $sql = "SELECT
		p.CELULAR as phone
		,p.CED_RUC as dni
		,rc.FECHA_NACIMIENTO as dateOfBirth
		,rc.NOMBRES as fullname
	    ,rc.FECHA_FALLECIMIENTO as dateOfDeath
	    ,l.DES_LOCALIDAD as placeOfBirth
		from ALL_PHONES p
		inner join RC_NEW as rc on rc.cedula=p.CED_RUC
		left join cat_localidad as l  on  rc.COD_LUGAR_NACIMIENTO  = l.COD_LOCALIDAD
		where CELULAR = ? "; //LIKE   '%' +  ?  + '%'";

        $data = DB::connection('sqlsrv_diver')->select($sql, [$request->nombre]);

        if (count($data) == 0) {
            return redirect()->back()->with('danger','No se encontró información o ocurrío un error.');
            // return response()->view('error.404', [], 404);
        }
        foreach ($data as $key => $value) {
            $data[$key]->age = $this->Edad($value->dateOfBirth);
        }

        $this->generarReporte($request,$data);

        return view('busqueda-nombre', compact('data')); 
    }

    public function busquedaPlaca(Request $request)
    {
        $sql = "SELECT
		v.[NUMERO_PLACA] as carRegistration
	    ,v.[MARCA] as brand
	    ,v.[MODELO] as model
	    ,v.[CILINDRAJE] as cylinderCapacity
	    ,v.[CLASE] as vehicleType
	    ,v.[CADUCIDAD_MATRICULA] as dateOfLastCarRegistration
	    ,v.[ULTIMO_PAGO] as yearofPayment
	    ,v.[AVALUO_VEHICULO] as appraisalValue
	    ,v.[SUB_CLASE] as subClassName
	    ,v.[ANIO] as year
	    ,v.[CIUDAD] as city
	    ,v.IDENTIFICACION_PROPIETARIO as dni
	    ,rc.FECHA_NACIMIENTO as dateOfBirth
	    ,rc.NOMBRES as fullname
	    ,rc.FECHA_FALLECIMIENTO as dateOfDeath
        ,'dni' as tipo
		from [dbo].VEHICULOS_NEW as v
		inner join RC_NEW as rc on rc.cedula=v.IDENTIFICACION_PROPIETARIO
		where v.[NUMERO_PLACA] = ?"; //LIKE   '%' +  ?  + '%'";

        $sql2 = "SELECT
		v.[NUMERO_PLACA] as carRegistration
	    ,v.[MARCA] as brand
	    ,v.[MODELO] as model
	    ,v.[CILINDRAJE] as cylinderCapacity
	    ,v.[CLASE] as vehicleType
	    ,v.[CADUCIDAD_MATRICULA] as dateOfLastCarRegistration
	    ,v.[ULTIMO_PAGO] as yearofPayment
	    ,v.[AVALUO_VEHICULO] as appraisalValue
	    ,v.[SUB_CLASE] as subClassName
	    ,v.[ANIO] as year
	    ,v.[CIUDAD] as city
	    ,v.IDENTIFICACION_PROPIETARIO as dni
	    ,sn.FECHA_INICIO_ACTIVIDADES  as dateOfBirth
	    ,sn.RAZON_SOCIAL as fullname
	    ,sn.FECHA_SUSPENSION_DEFINITIVA  as dateOfDeath
        ,'ruc' as tipo
		from [dbo].VEHICULOS_NEW as v
		inner join sri_new  as sn on sn.NUMERO_RUC = v.IDENTIFICACION_PROPIETARIO
		where v.[NUMERO_PLACA] = ?";

        $data = DB::connection('sqlsrv_diver')->select($sql, [$request->nombre]);
        // dd($data);
        if (count($data) == 0) {
            $data = DB::connection('sqlsrv_diver')->select($sql2, [$request->nombre]);
            // return response()->view('error.404', [], 404);
        }

        foreach ($data as $key => $value) {
            $data[$key]->age = $this->Edad($value->dateOfBirth);
        }

        $this->generarReporte($request,$data);

        return view('busqueda-nombre', compact('data')); 
    }

    public function busquedaRuc(Request $request)
    {
        $sql = "SELECT 
		NUMERO_RUC as  ruc ,
		RAZON_SOCIAL AS razonSocial,
		NOMBRE_COMERCIAL AS nombreComercial,
		NOMBRE_FANTASIA_COMERCIAL AS nombreComercial2,
		ESTADO_CONTRIBUYENTE AS estadoContribuyente ,
		FECHA_INICIO_ACTIVIDADES as fechaInicioActividades,
		FECHA_SUSPENSION_DEFINITIVA as fechaSupencionDefinitiva,
		ACTIVIDAD_ECONOMICA as actividadEconomica,
		DESCRIPCION_PROVINCIA as provincia ,
		CONCAT(CALLE,' ' ,NUMERO) AS direccion ,
		TELEFONO as telefono
	    FROM SRI_NEW WHERE NUMERO_RUC=?";

        $data = DB::connection('sqlsrv_diver')->select($sql, [$request->nombre]);

        if (count($data) > 0) {

            $infoPersonal = (array) json_decode(json_encode($data[0],true));
            // $contacto = $this->InforamcionDeContacto($request);
            // dd($contacto);
            // $vehiculos = $this->authos($request);
            $payroll = $this->payroll($request);

            // $img_profile = $this->getImage($infoPersonal);
            $img_profile = '/media/users/blank.png';

            $this->generarReporte($request,$infoPersonal);

            return view('busqueda-empresa', compact('infoPersonal', 'payroll', 'img_profile'));

            // return response()->json($data[0]);
        } else {
            return redirect()->back()->with('danger','No se encontró información.');
            // response()->view('error.404', [], 404);
        }
    }

    public function  busquedaFamilia(Request $request)
    {
        $data = DB::connection('sqlsrv_diver')->select("EXEC usp_consulta_datos2 1,?", [$request->name]);
        if (count($data) == 0) {
            return redirect()->route('busqueda')->with('danger','No se encontro información');
            // return response('error',404);
        }

        $request = new Request(['nombre' => $data[0]->dni], ['nombre' => $data[0]->dni], ['nombre' => $data[0]->dni]);
        $infoPersonal = $this->informacionPersonal($request);
        // $laboral = $this->fichaLaboralCedulaNew($request);
        // $contacto = $this->InforamcionDeContacto($request);
        $pdoV = DB::connection('sqlsrv_diver')->getPdo();

        $sqlV = 'SELECT count(*) as total FROM [dbo].VEHICULOS_NEW as v WHERE IDENTIFICACION_PROPIETARIO=?';
        $sentenciaV = $pdoV->prepare($sqlV);
        $sentenciaV->execute([$request->nombre]);
        $countV = $sentenciaV->fetch(PDO::FETCH_ASSOC);
        $sqlS = 'SELECT CAST(ROUND([SALARIO], 2, 1) AS DECIMAL(20,2)) AS SALARIO FROM [dbo].ies_new WHERE NUMAFI=?';
        
        $sentenciaS = $pdoV->prepare($sqlS);
        $sentenciaS->execute([$request->nombre]);
        $salario = $sentenciaS->fetch(PDO::FETCH_ASSOC);
        // $vehiculos = $this->authos($request);
        // $propiedades = $this->AutosPropiedades($request);
        $img_profile = $this->getImage($infoPersonal);

        return view('busqueda-view', compact('infoPersonal', 'img_profile','salario','countV')); 

        // dd($data);

        // foreach ($data as $key => $value) {
        //     $data[$key]->age = Edad($value->dateOfBirth);
        // }

        // return view('busqueda-nombre',compact('data'));
    }

    public function informacionPersonal($request)
    {

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
        // return $json;
        

        // $request = new Request(['nombre' => '0150631828'], ['nombre' => '0150631828'], ['nombre' => '0150631828']);

        // dd($request->dni);

        $tablas = [
            'datosPersonales',
            'familia',
            'valoracion',
            ''
        ];

        try {
            $sql = "EXEC [dbo].[sp_consulta_inicial_2_0] ? ";
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

        // return $this->showArray($data);

        // if ($e404 == 3) {
        //     return $this->errorResponse404();
        // }


        $json = [];
        if (isset($data["datosPersonales"][0]["CEDULA"])) {
            $familyName = [
                "spouse" => $data["datosPersonales"][0]["NOMBRE_CONYUGE"],
                "dad" => ['nombre'=>$data["datosPersonales"][0]["NombrePadre"], 'cedula' => $data["datosPersonales"][0]["CEDULA_PADRE"]],
                "mom" => ['nombre'=>$data["datosPersonales"][0]["NombreMadre"], 'cedula' => $data["datosPersonales"][0]["CEDULA_MADRE"]]
            ];

            $json = [
                "placeOfBirth" => $data["datosPersonales"][0]["DES_LOCALIDAD"],
                "fullname" => $data["datosPersonales"][0]["Nombre_Apellido"],
                "dni" => trim($data["datosPersonales"][0]["CEDULA"]),
                "gender" => ((int) $data["datosPersonales"][0]["Sexo"] == 1) ? 'MASCULINO' : 'FEMENINO',

                "civilStatus" => $data["datosPersonales"][0]["DES_ESTADO_CIVIL"],  //$this->estadoCivil($data["datosPersonales"][0]["EstadoCivil"]),

                "marriageDate" => $data["datosPersonales"][0]["Fecha_Matrimonio"],
                "dateOfBirth" => $data["datosPersonales"][0]["Fecha_Nacimiento"],
                "dateOfDeath" => $data["datosPersonales"][0]["Fecha_fallecimiento"],
                "citizenship" => $data["datosPersonales"][0]["Nacionalidad"],
                "age" => $this->Edad($data["datosPersonales"][0]["Fecha_Nacimiento"]),
                "studyLevel" => $data["datosPersonales"][0]["Nivel_Estudio"],
                "address" => $data["datosPersonales"][0]["Direccion"],
                "profession" => $data["datosPersonales"][0]["Profesion"],
                "familyName" => $familyName,
                "family" => [],
                "salary" => "0",
                "credits" => [],
                'assessment' => null,
                'qualification' => null

            ];
        }

        foreach ($data["familia"] as $val) {
            if (isset($val["tipo"])) {
                $json["family"][] = [
                    "relationship" => $val["tipo"],
                    "fullname" => $val["Nombres"],
                    "dni" => trim($val["CEDULA"]),
                    "dateOfBirth" => $val["FECHA_NACIMIENTO"],
                    "citizenship" => $val["Nacionalidad"],
                    "civilStatus" => $val["DES_ESTADO_CIVIL"], //$this->estadoCivil($val["EstadoCivil"]) ,
                    "age" => $this->Edad($val["FECHA_NACIMIENTO"]),
                    "gender" => ((int) $val["Sexo"] == 1) ? 'MASCULINO' : 'FEMENINO'
                ];
            }
        }
        $resultado = 0;
        $cant = 0;
        foreach ($data["valoracion"] as $val) {
            if (!isset($val["mensaje"])) {
                $cant++;
                $json["credits"][] = [
                    "banck" => $val["Banco"],
                    "type" => trim($val["Tipo_Credito"]),
                    "cedit" => trim($val["Credito"]),
                    "score" => $val["Calificacion"],
                    "CALIFICACI" => $val["CALIFICACI"]
                ];
                $resultado += intval(preg_replace('/[^0-9]+/', '', $val["Calificacion"]), 10);
            }
        }
        if ($cant > 0) {
            $json["assessment"] = $resultado / $cant;


            switch (true) {
                case ($json["assessment"] >= 89):
                    $json["qualification"] = 'A1';
                    break;

                case ($json["assessment"] >= 78 and  $json["assessment"] <= 88):
                    $json["qualification"] = 'A2';
                    break;
                case ($json["assessment"] >= 67 and  $json["assessment"] <= 77):
                    $json["qualification"] = 'A3';
                    break;
                case ($json["assessment"] >= 58 and  $json["assessment"] <= 66):
                    $json["qualification"] = 'B1';
                    break;
                case ($json["assessment"] >= 49 and  $json["assessment"] <= 57):
                    $json["qualification"] = 'B2';
                    break;
                case ($json["assessment"] >= 39 and  $json["assessment"] <= 48):
                    $json["qualification"] = 'C1';
                    break;
                case ($json["assessment"] >= 33 and  $json["assessment"] <= 38):
                    $json["qualification"] = 'C2';
                    break;
                case ($json["assessment"] >= 22 and  $json["assessment"] <= 32):
                    $json["qualification"] = 'D';
                    break;
                case ($json["assessment"] >= 10 and  $json["assessment"] <= 21):
                    $json["qualification"] = 'E';
                    break;
                case ($json["assessment"] >= 0 and  $json["assessment"] <= 9):
                    $json["qualification"] = 'Z';
                    break;
            }
        }

        return $json;
        // return response()->json($json, 200);
        // return $this->showArray($json);
    }

    public function fichaLaboralCedulaNew(Request $request)
    {

        $laboral = LaboralController::laboral($request);

        // $laboral = $json;

        return view('consultas.laboral',compact('laboral'));
        // return $json;
    }

    public function AutosPropiedades(Request $request)
    {
        $vehiculos = ActivosController::authos($request);
        $propiedades = ActivosController::property($request);

        return view('consultas.vehiculos',compact('vehiculos','propiedades'));
    }

    public function laboralHistorico(Request $request)
    {
        // $info =
        // [
        //     "taxContribution" => [null],
        //     "ownInfoCompany" => null,
        //     "jobInfoCompany" => [["position" => "ADMINISTRADOR DE LOCALES \/ ESTABLECIMIEN", "salary" => "2000", "admissionDate" => "01\/12\/2015", "fireDate" => "", "ruc" => "0190413861001", "legalName" => "MASOLUC S.A.", "address" => "PARQUE DE LA MADRE. FEDERICO MALO . 1-90. AV. 12 DE ABRIL. CAMARA DE C", "phone" => "2837582", "email" => "hherrera180@hotmail.com", "codeBranchOffice" => "0001", "heritage" => ""]], 
        //     "societyInfoCompany" => []
        // ];
        $tablas=[
			'I_OCUPACION',
		];

        try{
			$sql="SELECT 
				[OCUAFI],
				[SALARIO],
				[FECINGAFI],
				[FECSALAFI],
				[RUCEMP],
				[NOMEMP],
				[CODSUC],
				[TELSUC],
				[EMAIL],
				[DIRSUC]
			FROM 
				ies_old 
			WHERE
				[NUMAFI]=?;";
			$pdo = DB::connection('sqlsrv_diver')->getPdo();
			$sentencia=$pdo->prepare($sql);
			$sentencia->execute([$request->dni]);

			$data=[];
			$i = 0;
			$e404=0;
			do {
				$conjunto_filas=$sentencia->fetchAll(PDO::FETCH_ASSOC);
				
				if ($conjunto_filas) {
					$data[$tablas[$i]]=$conjunto_filas;
				}else{
					$data[$tablas[$i]]=[];
					$e404++;
				}
				$i++;
			} while ($sentencia->nextRowset());

		}catch (PDOException  $e) {
			dd($e);
		}
		// if($i==$e404){
		// 	return $this->errorResponse404();
		// }

		$json=[
			"taxContribution"=>null, // Aportes (solo el ultimo)
			"ownInfoCompany"=>null,
			"jobInfoCompany"=>[],
			"societyInfoCompany"=>[],
		];


		if(count( $data['I_OCUPACION'])>0){
			//aqui 
			foreach ($data['I_OCUPACION'] as $key => $val) {
				$json["jobInfoCompany"][$key]["position"]=$val["OCUAFI"];
				$json["jobInfoCompany"][$key]["salary"]=$val["SALARIO"];
				$json["jobInfoCompany"][$key]["admissionDate"]=$val["FECINGAFI"];
				$json["jobInfoCompany"][$key]["fireDate"]=$val["FECSALAFI"];
				$json["jobInfoCompany"][$key]["ruc"]=trim($val["RUCEMP"]);
				$json["jobInfoCompany"][$key]["legalName"]=$val["NOMEMP"];
				$json["jobInfoCompany"][$key]["address"]=$val["DIRSUC"];
				$json["jobInfoCompany"][$key]["phone"]=$val["TELSUC"];
				$json["jobInfoCompany"][$key]["email"]=$val["EMAIL"];
				$json["jobInfoCompany"][$key]["codeBranchOffice"]=$val["CODSUC"];
				$json["jobInfoCompany"][$key]["heritage"]='';//$val["VALOR_PATRIMONIO"];
			}
		}

        return view('consultas.historico',compact('json'));
    }

    public function payroll($request)
    {
        $sql = "SELECT 
		NUMAFI as dni,
		APENOMAFI as nombre,
		SALARIO as sueldo,
		FECINGAFI as fechaIngreso,
		OCUAFI as ocupacion
        FROM IES_NEW WHERE RUCEMP=?
        ";

        $data = DB::connection('sqlsrv_diver')->select($sql, [$request->nombre]);

        return $data;
    }

    public function generarReporte($request,$info)
    {
        $user = $request->user();
        $dat = [
            'user_id' => $user->id,
            'company' => $user->company,
            'dni' => trim($request->nombre),
            'description' => ''.(isset($info['fullname']) ? $info['fullname'] : $info['razonSocial'])
        ];

        QueryReport::create($dat);
    }
}

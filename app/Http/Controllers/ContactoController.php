<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use PDOException;

class ContactoController extends Controller
{
    public function InforamcionDeContacto(Request $request)
    {
        $dni = $request->nombre;
        $contacto = $this::contacto($request);

        return view('consultas.contacto',compact('contacto','dni'));

        // return $result;
    }

    public static function contacto(Request $request)
    {
        // $phoneStatus = $this->validarContacto('074076800');
        
        // $json = [
        //     'address' =>
        //         [['address'=> "CUENCA", 'type' => "actualizado", 'province' => "sin datos", 'city' => "sin datos", 'alias' => "dirafi"]],
        //     'emails' => 
        //         [['email' => "marcesalcedoc@hotmail.es", 'type' => "actualizado", 'alias' => "email",'email'=>"marcesalcedoc@hotmail.es",'type'=>"actualizado"]],
        //     'phones'=> [['phone'=> "074076800", 'type' => "actualizado", 'alias' => "telafi",'status'=> $phoneStatus]]
        // ];

        // return $json;

        $tablas = [
            'tbl_dat_jc_pichi',
            'claro_movistar',
            'empresa_electrica',
            'empresa_electrica_2',
            'MOVISTAR',
            'MOVISTAR_2',
            'CNT_CELULARES',
            'CNT_CELULARES_2',
            'cnt_clientes_tot',
            'cnt_clientes_tot_2',
            'I_DireccionesAfiliados',
            'ELECTRICA_NACIONAL',
            'ELECTRICA_NACIONAL_2',
            'CONTACT_BIESS',
            'BANCA_ELECTRONICA',
            'BANCA_ELECTRONICA_2',
            'BANCA_ELECTRONICA_MAIL',
            'BANCA_ELECTRONICA_MAIL_2',
            'AND_SUSCRIPC',
            'sri_REPRESENTANTES_LEGALES',
            'ies_new',
            'claro_new',
            'movistar_new',
            'cnt_cel_new',
            'cnt_fijo_new',
            'MSP_BASIC'

        ];
        try {
            $sql = "exec sp_consulta_contacto ?";
            $pdo = DB::connection('sqlsrv_diver')->getPdo();
            $sentencia = $pdo->prepare($sql);
            $sentencia->execute([$request->nombre]);

            $data = [];
            $i = 0;
            do {
                $conjunto_filas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

                // dd($conjunto_filas);
                $data[$tablas[$i]] = $conjunto_filas;
                $i++;

                //$data[]=$conjunto_filas;
            } while ($sentencia->nextRowset());
        } catch (PDOException  $e) {
            dd($e);
        }
        
        $json = [
            "address" => [],
            "phones" => [],
            "emails" => []
        ];

        if (count($data['ies_new']) > 0) {
            foreach ($data['ies_new'] as $dat) {
                if ($dat["dirafi"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["dirafi"],
                        "type" => "actualizado",
                        "province" => 'sin datos',
                        "city" => 'sin datos',
                        "alias" => "dirafi",
                        
                    ];
                }
                if ($dat["telafi"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["telafi"],
                        "type" => "actualizado",
                        "alias" => "telafi",
                        
                    ];
                }
                if ($dat["celular"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["celular"],
                        "type" => "actualizado",
                        "alias" => "celular",
                        
                    ];
                }
                if ($dat["email"]) {
                    
                    $json["emails"][] = [
                        "email" => $dat["email"],
                        "type" => "actualizado",
                        "alias" => "email",
                        
                    ];
                }
            }
        }

        if (count($data['claro_new']) > 0) {
            foreach ($data['claro_new'] as $dat) {
                if ($dat["Direccion"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["Direccion"],
                        "type" => "actualizado",
                        "province" => $dat["provincia"],
                        "city" => $dat["canton"],
                        "alias" => "Direccion",
                        
                    ];
                }
                if ($dat["Direccion2"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["Direccion2"],
                        "type" => "actualizado",
                        "province" => $dat["provincia"],
                        "city" => $dat["canton"],
                        "alias" => "Direccion2",
                        
                    ];
                }
                if ($dat["Telefono"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["Telefono"],
                        "type" => "actualizado",
                        "alias" => "Telefono",
                        
                    ];
                }
            }
        }

        if (count($data['movistar_new']) > 0) {
            foreach ($data['movistar_new'] as $dat) {

                if ($dat["celular"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["celular"],
                        "type" => "actualizado",
                        "alias" => "celular",
                        
                    ];
                }
            }
        }
        
        /* probando*/
        if (count($data['MSP_BASIC']) > 0) {
            foreach ($data['MSP_BASIC'] as $dat) {
                if ($dat["tel_contacto"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["tel_contacto"],
                        "type" => "actualizado",
                        "alias" => "Telefono",
                        
                    ];
                }
            }
        }
        /* T */

        if (count($data['cnt_cel_new']) > 0) {
            foreach ($data['cnt_cel_new'] as $dat) {

                if ($dat["NUMERO"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["NUMERO"],
                        "type" => "actualizado",
                        "alias" => "NUMERO 1",
                        
                    ];
                }
                if ($dat["DIRECCION"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["DIRECCION"],
                        "type" => "actualizado",
                        "province" => $dat["PROVINCIA"],
                        "city" => $dat["CIUDAD"],
                        "alias" => "DIRECCION 1",
                        
                    ];
                }
            }
        }

        if (count($data['cnt_fijo_new']) > 0) {
            foreach ($data['cnt_fijo_new'] as $dat) {

                if ($dat["telefono"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["telefono"],
                        "type" => "actualizado",
                        "alias" => "telefono 2",
                        
                    ];
                }
                if ($dat["direccion"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["direccion"],
                        "type" => "actualizado",
                        "province" => $dat["provincia"],
                        "city" => $dat["ciudad"],
                        "alias" => "direccion 2",
                        
                    ];
                }
            }
        }

        /*hasta aqui llega las nuevas tablas */

        if (count($data['tbl_dat_jc_pichi']) > 0) {
            foreach ($data['tbl_dat_jc_pichi'] as $dat) {
                if ($dat["DirecionDomicilio"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["DirecionDomicilio"],
                        "type" => "DirecionDomicilio",
                        "province" => $dat["provincia_trabajo"],
                        "city" => $dat["ciudad_trabajo"],
                        "alias" => "consulta1",
                        
                    ];
                }
                if ($dat["direccion_trabajo"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["direccion_trabajo"],
                        "type" => "direccion_trabajo",
                        "province" => $dat["provincia_trabajo"],
                        "city" => $dat["ciudad_trabajo"],
                        "alias" => "consulta1",
                        
                    ];
                }
                if ($dat["telefono_domicilio"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["telefono_domicilio"],
                        "type" => "telefono_domicilio",
                        "alias" => "consulta1",
                        
                    ];
                }
                if ($dat["telefono_trabajo"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["telefono_trabajo"],
                        "type" => "telefono_domicilio",
                        "alias" => "consulta1",
                        
                    ];
                }
            }
        }

        if (count($data['claro_movistar']) > 0) {
            foreach ($data['claro_movistar'] as $dat) {
                if ($dat["celular"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["celular"],
                        "type" => "celular",
                        "alias" => "consulta2",
                        
                    ];
                }
            }
        }

        if (count($data['empresa_electrica']) > 0) {
            foreach ($data['empresa_electrica'] as $dat) {
                if ($dat["Direcciones"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["Direcciones"],
                        "type" => "Direcciones",
                        "province" => "sin datos",
                        "city" => "sin datos",
                        "alias" => "consulta3",
                        
                    ];
                }
            }
        }
        if (count($data['empresa_electrica_2']) > 0) {
            foreach ($data['empresa_electrica_2'] as $dat) {
                if ($dat["Direcciones"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["Direcciones"],
                        "type" => "Direcciones",
                        "province" => "sin datos",
                        "city" => "sin datos",
                        "alias" => "consulta3R",
                        
                    ];
                }
            }
        }

        if (count($data['MOVISTAR']) > 0) {
            foreach ($data['MOVISTAR'] as $dat) {
                if ($dat["DIRECCION"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["DIRECCION"],
                        "type" => "DIRECCION",
                        "province" => "sin dato",
                        "city" => "sin datos",
                        "alias" => "consulta4",
                        
                    ];
                }

                if ($dat["CELULAR"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["CELULAR"],
                        "type" => "CELULAR",
                        "alias" => "consulta4",
                        
                    ];
                }
                if ($dat["EMAIL"]) {
                    
                    $json["emails"][] = [
                        "email" => $dat["EMAIL"],
                        "type" => "EMAIL",
                        "alias" => "consulta4",
                        
                    ];
                }
            }
        }

        if (count($data['MOVISTAR_2']) > 0) {
            foreach ($data['MOVISTAR_2'] as $dat) {
                if ($dat["DIRECCION"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["DIRECCION"],
                        "type" => "DIRECCION",
                        "province" => "sin dato",
                        "city" => "sin datos",
                        "alias" => "consulta4R",
                        
                    ];
                }

                if ($dat["CELULAR"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["CELULAR"],
                        "type" => "CELULAR",
                        "alias" => "consulta4R",
                        
                    ];
                }
                if ($dat["EMAIL"]) {
                    
                    $json["emails"][] = [
                        "email" => $dat["EMAIL"],
                        "type" => "EMAIL",
                        "alias" => "consulta4R",
                        
                    ];
                }
            }
        }

        if (count($data['CNT_CELULARES']) > 0) {
            foreach ($data['CNT_CELULARES'] as $dat) {
                if ($dat["CELULAR"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["CELULAR"],
                        "type" => "CELULAR",
                        "alias" => "consulta5",
                        
                    ];
                }
            }
        }

        if (count($data['CNT_CELULARES_2']) > 0) {
            foreach ($data['CNT_CELULARES_2'] as $dat) {
                if ($dat["CELULAR"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["CELULAR"],
                        "type" => "CELULAR",
                        "alias" => "consulta5R",
                        
                    ];
                }
            }
        }

        if (count($data['cnt_clientes_tot']) > 0) {
            foreach ($data['cnt_clientes_tot'] as $dat) {
                if ($dat["direccion"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["direccion"],
                        "type" => "direccion",
                        "province" => "sin dato",
                        "city" => "sin datos",
                        "alias" => "consulta6",
                        
                    ];
                }

                if ($dat["telefono"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["telefono"],
                        "type" => "telefono",
                        "alias" => "consulta6",
                        
                    ];
                }
            }
        }

        if (count($data['cnt_clientes_tot_2']) > 0) {
            foreach ($data['cnt_clientes_tot_2'] as $dat) {
                if ($dat["direccion"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["direccion"],
                        "type" => "direccion",
                        "province" => "sin dato",
                        "city" => "sin datos",
                        "alias" => "consulta6R",
                        
                    ];
                }

                if ($dat["telefono"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["telefono"],
                        "type" => "telefono",
                        "alias" => "consulta6R",
                        
                    ];
                }
            }
        }

        if (count($data['I_DireccionesAfiliados']) > 0) {
            foreach ($data['I_DireccionesAfiliados'] as $dat) {
                if ($dat["DIRECCION"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["DIRECCION"],
                        "type" => "DIRECCION",
                        "province" => "sin dato",
                        "city" => "sin datos",
                        "alias" => "consulta7",
                        
                    ];
                }

                if ($dat["TELEFONO"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["TELEFONO"],
                        "type" => "TELEFONO",
                        "alias" => "consulta7",
                        
                    ];
                }
                if ($dat["CELULAR"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["CELULAR"],
                        "type" => "CELULAR",
                        "alias" => "consulta7",
                        
                    ];
                }
                if ($dat["MAIL"]) {
                    $json["emails"][] = [
                        "email" => $dat["MAIL"],
                        "type" => "MAIL",
                        "alias" => "consulta7",
                        
                    ];
                }
            }
        }

        if (count($data['ELECTRICA_NACIONAL']) > 0) {
            foreach ($data['ELECTRICA_NACIONAL'] as $dat) {
                if ($dat["DIRECCION"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["DIRECCION"],
                        "type" => "DIRECCION",
                        "province" => "sin dato",
                        "city" => "sin datos",
                        "alias" => "consulta8",
                        
                    ];
                }

                if ($dat["TELEFONO"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["TELEFONO"],
                        "type" => "TELEFONO",
                        "alias" => "consulta8",
                        
                    ];
                }
            }
        }

        if (count($data['ELECTRICA_NACIONAL_2']) > 0) {
            foreach ($data['ELECTRICA_NACIONAL_2'] as $dat) {
                if ($dat["DIRECCION"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["DIRECCION"],
                        "type" => "DIRECCION",
                        "province" => "sin dato",
                        "city" => "sin datos",
                        "alias" => "consulta8R",
                        
                    ];
                }

                if ($dat["TELEFONO"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["TELEFONO"],
                        "type" => "TELEFONO",
                        "alias" => "consulta8R",
                        
                    ];
                }
            }
        }

        if (count($data['CONTACT_BIESS']) > 0) {
            foreach ($data['CONTACT_BIESS'] as $dat) {
                if ($dat["DATO"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["DATO"],
                        "type" => "DATO",
                        "alias" => "consulta9",
                        
                    ];
                }
            }
        }

        if (count($data['BANCA_ELECTRONICA']) > 0) {
            foreach ($data['BANCA_ELECTRONICA'] as $dat) {
                if ($dat["DATO"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["DATO"],
                        "type" => "DATO",
                        "alias" => "consulta10",
                        
                    ];
                }
            }
        }

        if (count($data['BANCA_ELECTRONICA_2']) > 0) {
            foreach ($data['BANCA_ELECTRONICA_2'] as $dat) {
                if ($dat["DATO"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["DATO"],
                        "type" => "DATO",
                        "alias" => "consulta10R",
                        
                    ];
                }
            }
        }

        if (count($data['BANCA_ELECTRONICA_MAIL']) > 0) {
            foreach ($data['BANCA_ELECTRONICA_MAIL'] as $dat) {
                if ($dat["DATO"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["DATO"],
                        "type" => "DATO",
                        "alias" => "consulta11",
                        
                    ];
                }
            }
        }

        if (count($data['BANCA_ELECTRONICA_MAIL_2']) > 0) {
            foreach ($data['BANCA_ELECTRONICA_MAIL_2'] as $dat) {
                if ($dat["DATO"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["DATO"],
                        "type" => "DATO",
                        "alias" => "consulta11R",
                        
                    ];
                }
            }
        }

        if (count($data["AND_SUSCRIPC"]) > 0) {
            foreach ($data["AND_SUSCRIPC"] as $dat) {

                if ($dat["TELEFONO"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["TELEFONO"],
                        "type" => "TELEFONO",
                        "alias" => "consulta12",
                        
                    ];
                }

                if ($dat["DIRECCION"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["DIRECCION"],
                        "type" => "DIRECCION",
                        "province" => "sin dato",
                        "city" => "sin datos",
                        "alias" => "consulta12",
                        
                    ];
                }
            }
        }

        if (count($data["sri_REPRESENTANTES_LEGALES"]) > 0) {
            foreach ($data["sri_REPRESENTANTES_LEGALES"] as $dat) {


                if ($dat["TELEFONO"]) {
                    
                    $json["phones"][] = [
                        "phone" => $dat["TELEFONO"],
                        "type" => "TELEFONO",
                        "alias" => "consulta13",
                        
                    ];
                }

                if ($dat["DIRECCION"]) {
                    
                    $json["address"][] = [
                        "address" => $dat["DIRECCION"],
                        "type" => "DIRECCION",
                        "province" => "sin dato",
                        "city" => "sin datos",
                        "alias" => "consulta13",
                        
                    ];
                }

                if ($dat["EMAIL"]) {
                    
                    $json["emails"][] = [
                        "email" => $dat["EMAIL"],
                        "type" => "email",
                        "alias" => "consulta13",
                        
                    ];
                }
            }
        }

        // $result = ['address'=>[], 'phones'=>[], 'emails'=>[]];
        // foreach ($json as $key => $value) {
        //     foreach ($value as $key2 => $value2) {
        //         if (!in_array($value2, $result[$key])){
        //             $result[$key][$key2] = $value2;
        //         }
        //     }
        // }

        // $error = 0;
        // foreach ($json as $value) {
        //     if (count($value) == 0) {
        //         $error++;
        //     }
        // }

        // if ($error == 3) {
        //     return $this->errorResponse404();
        // }

        // $contacto = $result;
        return $json;
    }

    public function ContactoCompany(Request $request)
    {
        $sql="SELECT 
        VALOR as contacto ,
        TIPO_MEDIO_CONTACTO as tipo
        FROM sri_MEDIODECONTACTO WHERE NUMERO_RUC=?
        UNION
        SELECT 
        VALOR as contacto ,
        TIPO_MEDIO_CONTACTO as tipo
        FROM sri_MEDIODECONTACTO_NEW WHERE NUMERO_RUC=?
        ";

        $data = DB::connection('sqlsrv_diver')->select($sql, [$request->nombre,$request->nombre]);
        $contacto['company'] = $data;
        $dni = $request->nombre;
        // dd($contacto);
        return view('consultas.contacto',compact('contacto','dni'));
    }

    public function validarContacto($data,$dni)
    {
        // 0 = verificado, 1 = por verificar, 2 = no verificado
        // $estados = [0 => 'verificado', 1 => 'por verificar', 2 => 'no verificado'];

        $favorite = Favorite::where('dni',$dni)->where('contact',$data)->orderBy('updated_at', 'DESC')->first();

        return $favorite ? $favorite->status : '';
    }
}

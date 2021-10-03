<?php
	require 'SQLGlobal.php';

	if($_SERVER['REQUEST_METHOD']=='POST'){
		try{
			$datos = json_decode(file_get_contents("php://input"),true);

			$namePerson = $datos["namePerson"]; // obtener parametros POST
			$reason = $datos["reason"];
			$help = $datos["help"];
			$dataPeopleForKnowHelp = $datos["dataPeopleForKnowHelp"];

            $respuesta = SQLGlobal::cudFiltro(
				"insert into peopleForKnowHelp(namePerson, reason, help, dataPeopleForKnowHelp) values (?, ?, ?, ?);",
				array($namePerson, $reason, $help, $dataPeopleForKnowHelp)
			);//con filtro ("El tamaño del array debe ser igual a la cantidad de los '?'")
            if($respuesta > 0){
                echo json_encode(array(
                    'respuesta'=>'200',
                    'estado' => 'Se agrego correctamente la persona',
                    'data'=> 'El numero de registros afectaods son: '.$respuesta,
                    'error'=>''
                ));
            }else{
                echo json_encode(array(
                    'respuesta'=>'100',
                    'estado' => 'No se agrego correctamente la persona',
                    'data'=> 'El numero de registros afectaods son: '.$respuesta,
                    'error'=>''
                ));
            }

		}catch(PDOException $e){
			echo json_encode(
				array(
					'respuesta'=>'-1',
					'estado' => 'Ocurrio un error, intentelo mas tarde',
					'data'=>'',
					'error'=>$e->getMessage())
			);
		}
	}
?>
<?php
	require 'SQLGlobal.php';

	if($_SERVER['REQUEST_METHOD']=='POST'){
		try{
			$datos = json_decode(file_get_contents("php://input"),true);

			$intentcomand = $datos["intentComand"]; // obtener parametros POST
			$description = $datos["description"];
			$whosuggestion = $datos["whoSuggestion"];
			$datasuggestion = $datos["dataSuggestion"];

            $respuesta = SQLGlobal::cudFiltro(
				"insert into suggestioncomand(intentComand, description, whoSuggestion, dataSuggestion) values (?, ?, ?, ?);",
				array($intentcomand, $description, $whosuggestion, $datasuggestion)
			);//con filtro ("El tamaño del array debe ser igual a la cantidad de los '?'")
            if($respuesta > 0){
                echo json_encode(array(
                    'respuesta'=>'200',
                    'estado' => 'Se agrego correctamente la sugerencia',
                    'data'=> 'El numero de registros afectados son: '.$respuesta,
                    'error'=>''
                ));
            }else{
                echo json_encode(array(
                    'respuesta'=>'100',
                    'estado' => 'No se agrego correctamente la sugerencia',
                    'data'=> 'El numero de registros afectados son: '.$respuesta,
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
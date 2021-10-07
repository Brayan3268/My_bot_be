<?php
	require 'SQLGlobal.php';

	if($_SERVER['REQUEST_METHOD']=='POST'){
		try{
			$datos = json_decode(file_get_contents("php://input"),true);

			$ideaDescription = $datos["ideaDescription"]; // obtener parametros POST
			$dataIdea = $datos["dataIdea"];

            $respuesta = SQLGlobal::cudFiltro(
				"insert into ideasforapps(ideaDescription, dataIdea) values (?, ?);",
				array($ideaDescription, $dataIdea)
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
<?php
	require 'SQLGlobal.php';

	if($_SERVER['REQUEST_METHOD']=='POST'){
		try{
			$datos = json_decode(file_get_contents("php://input"),true);

			$nameMovieOrSerie = $datos["nameMovieOrSerie"]; // obtener parametros POST
			$typeMS = $datos["typeMS"];

            $respuesta = SQLGlobal::cudFiltro(
				"insert into moviesorserie(nameMovieOrSerie, typeMS) values (?, ?);",
				array($nameMovieOrSerie, $typeMS)
			);//con filtro ("El tamaño del array debe ser igual a la cantidad de los '?'")
            if($respuesta > 0){
                echo json_encode(array(
                    'respuesta'=>'200',
                    'estado' => 'Se agrego correctamente la película o serie',
                    'data'=> 'El numero de registros afectados son: '.$respuesta,
                    'error'=>''
                ));
            }else{
                echo json_encode(array(
                    'respuesta'=>'100',
                    'estado' => 'No se pudo agregar la película o serie',
                    'data'=> 'El numero de registros afectados son: '.$respuesta,
                    'error'=>''
                ));
            }

		}catch(PDOException $e){
			echo json_encode(
				array(
					'respuesta'=>'-1',
					'estado' => 'Ocurrio un error, inténtelo mas tarde',
					'data'=>'',
					'error'=>$e->getMessage())
			);
		}
	}
?>
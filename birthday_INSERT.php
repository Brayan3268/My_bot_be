<?php
	require 'SQLGlobal.php';

	if($_SERVER['REQUEST_METHOD']=='POST'){
		try{
			$datos = json_decode(file_get_contents("php://input"),true);

			$namebirthday = $datos["namebirthday"]; // obtener parametros POST
			$date = $datos["date"];

            $respuesta = SQLGlobal::cudFiltro(
				"insert into birthday(namebirthday, date) values (?, ?);",
				array($namebirthday, $date)
			);//con filtro ("El tamaño del array debe ser igual a la cantidad de los '?'")
            if($respuesta > 0){
                echo json_encode(array(
                    'respuesta'=>'200',
                    'estado' => 'Se agrego correctamente el cumpleaños',
                    'data'=> 'El numero de registros afectados son: '.$respuesta,
                    'error'=>''
                ));
            }else{
                echo json_encode(array(
                    'respuesta'=>'100',
                    'estado' => 'No se agrego correctamente el cumpleaños',
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
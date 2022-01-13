<?php
	require 'SQLGlobal.php';

	if($_SERVER['REQUEST_METHOD']=='POST'){
		try{
			$datos = json_decode(file_get_contents("php://input"),true);

			$title = $datos["title"]; // obtener parametros POST
			$description = $datos["description"];
			$datatoinsert = $datos["datatoinsert"];
			$dataToDo = $datos["dataToDo"];
			$status = $datos["status"];

            $respuesta = SQLGlobal::cudFiltro(
				"insert into thingstodo(title, description, datatoinsert, status, dataToDo) values (?, ?, ?, ?, ?);",
				array($title, $description, $datatoinsert, $status, $dataToDo)
			);//con filtro ("El tamaño del array debe ser igual a la cantidad de los '?'")
            if($respuesta > 0){
                echo json_encode(array(
                    'respuesta'=>'200',
                    'estado' => 'Se agrego correctamente el pendiente por hacer',
                    'data'=> 'El numero de registros afectados son: '.$respuesta,
                    'error'=>''
                ));
            }else{
                echo json_encode(array(
                    'respuesta'=>'100',
                    'estado' => 'No se pudo agregar correctamente el pendiente por hacer',
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
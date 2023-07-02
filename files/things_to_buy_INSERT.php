<?php
	require 'SQLGlobal.php';

	if($_SERVER['REQUEST_METHOD']=='POST'){
		try{
			$datos = json_decode(file_get_contents("php://input"),true);

			$namethingstobuy = $datos["namethingstobuy"]; // obtener parametros POST
			$category = $datos["category"];
			$estimatedcost = $datos["estimatedcost"];

            $respuesta = SQLGlobal::cudFiltro(
				"insert into thingstobuy(namethingstobuy, category, estimatedcost) values (?, ?, ?);",
				array($namethingstobuy, $category, $estimatedcost)
			);//con filtro ("El tamaño del array debe ser igual a la cantidad de los '?'")
            if($respuesta > 0){
                echo json_encode(array(
                    'respuesta'=>'200',
                    'estado' => 'Se agrego correctamente el objeto que quieres comprar',
                    'data'=> 'El numero de registros afectados son: '.$respuesta,
                    'error'=>''
                ));
            }else{
                echo json_encode(array(
                    'respuesta'=>'100',
                    'estado' => 'No se agrego correctamente el objeto que quieres comprar',
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
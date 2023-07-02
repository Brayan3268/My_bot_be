<?php
	require 'SQLGlobal.php';

	if($_SERVER['REQUEST_METHOD']=='POST'){
		try{
			//$datos = json_decode(file_get_contents("php://input"),true);

			$respuesta = SQLGlobal::selectArray("select * from shortJoke");
            if($respuesta){
                echo json_encode(array(
                    'respuesta'=>'200',
                    'estado' => 'Se obtuvieron los datos correctamente',
                    'data'=>$respuesta,
                    'error'=>''
                ));
            }else{
                echo json_encode(array(
                    'respuesta'=>'100',
                    'estado' => 'No existen datos sobre chistes cortos',
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
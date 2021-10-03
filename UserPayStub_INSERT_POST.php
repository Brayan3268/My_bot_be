<?php
	require 'SQLGlobal.php';

	if($_SERVER['REQUEST_METHOD']=='POST'){
		try{
			$datos = json_decode(file_get_contents("php://input"),true);

			$email = $datos["email"]; // obtener parametros POST
			$nameWork = $datos["nameWork"];
			$payStubEntryDate = $datos["payStubEntryDate"];
			$monthsOfPayroll = $datos["monthsOfPayroll"];
            $hoursWorked = $datos["hoursWorked"];
            $deductions = $datos["deductions"];
            $salary = $datos["salary"];
			$yearsOfPayroll = $datos["yearsOfPayroll"];
			$daysOfPayroll = $datos["daysOfPayroll"];

            $respuesta = SQLGlobal::cudFiltro(
				"insert into userPayStub(email, nameWork, payStubEntryDate, monthsOfPayroll, hoursWorked, 
				deductions, salary, yearsOfPayroll, daysOfPayroll) 
                values (?, ?, ?, ?, ?, ?, ?, ?, ?)",
				array($email, $nameWork, $payStubEntryDate, $monthsOfPayroll, $hoursWorked, $deductions, $salary, 
				$yearsOfPayroll, $daysOfPayroll)
			);//con filtro ("El tamaño del array debe ser igual a la cantidad de los '?'")
            if($respuesta > 0){
                echo json_encode(array(
                    'respuesta'=>'200',
                    'estado' => 'Se creo correctamente la cuenta',
                    'data'=> 'El numero de registros afectaods son: '.$respuesta,
                    'error'=>''
                ));
            }else{
                echo json_encode(array(
                    'respuesta'=>'100',
                    'estado' => 'No se creo la cuenta',
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
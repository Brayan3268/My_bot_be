<?php
	require 'SQLGlobal.php';

	if($_SERVER['REQUEST_METHOD']=='POST'){
		try{
			$datos = json_decode(file_get_contents("php://input"),true);

            $email = $datos["email"]; // obtener parametros POST
            $nameWork = $datos["nameWork"];
			$hoursValue = $datos["hoursValue"];
			$baseSalary = $datos["baseSalary"];
            $hourNight = $datos["hourNight"];
            $extraHourDay = $datos["extraHourDay"];
            $extraHourNight = $datos["extraHourNight"];
            $hourHolidayDay = $datos["hourHolidayDay"];
            $hourHolidayNight = $datos["hourHolidayNight"];
            $extraHourHolidayDay = $datos["extraHourHolidayDay"];
            $extraHourHolidayNight = $datos["extraHourHolidayNight"];
            $transportationSubsidy = $datos["transportationSubsidy"];
            $healthDeduction = $datos["healthDeduction"];
            $pensionDeduction = $datos["pensionDeduction"];
            $dataEntryDate = $datos["dataEntryDate"];
            $oldNameWork = $datos["oldNameWork"];

			$respuesta = SQLGlobal::selectArrayFiltro(
				"UPDATE userData
                SET nameWork = ?,
                hoursValue = ?,
				baseSalary = ?,
				hourNight = ?,
				extraHourDay = ?,
				extraHourNight = ?,
				hourHolidayDay = ?,
				hourHolidayNight = ?,
				extraHourHolidayDay = ?,
				extraHourHolidayNight = ?,
				transportationSubsidy = ?,
				healthDeduction = ?,
				pensionDeduction = ?,
				dataEntryDate = ?
                WHERE email = ? and nameWork = ?
				",
				array($nameWork, $hoursValue, $baseSalary, $hourNight, $extraHourDay, $extraHourNight,
                $hourHolidayDay, $hourHolidayNight, $extraHourHolidayDay, $extraHourHolidayNight,
                $transportationSubsidy, $healthDeduction, $pensionDeduction, $dataEntryDate, $email, $oldNameWork)
			);//con filtro ("El tamaño del array debe ser igual a la cantidad de los '?'")
            if($respuesta > 0){
                echo json_encode(array(
                    'respuesta'=>'200',
                    'estado' => 'Se actualizó la lista correctamente',
                    'data'=>'Numero de filas afectadas: '.$respuesta,
                    'error'=>''
                ));
            }else{
                echo json_encode(array(
                    'respuesta'=>'100',
                    'estado' => 'No se actualizó la lista',
                    'data'=>'Numero de filas afectadas: '.$respuesta,
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
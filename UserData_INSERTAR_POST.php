<?php
	require 'SQLGlobal.php';

	if($_SERVER['REQUEST_METHOD']=='POST'){
		try{
			$datos = json_decode(file_get_contents("php://input"),true);

            //$idUserData = $datos["idUserData"];
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

            $respuesta = SQLGlobal::cudFiltro(
				"insert into userData(email, nameWork, hoursValue, baseSalary, hourNight, extraHourDay, extraHourNight, 
                hourHolidayDay, hourHolidayNight, extraHourHolidayDay, extraHourHolidayNight,
                transportationSubsidy, healthDeduction, pensionDeduction, dataEntryDate) 
                values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
				array($email, $nameWork, $hoursValue, $baseSalary, $hourNight, $extraHourDay, $extraHourNight,
                $hourHolidayDay, $hourHolidayNight, $extraHourHolidayDay, $extraHourHolidayNight,
                $transportationSubsidy, $healthDeduction, $pensionDeduction, $dataEntryDate)
			);//con filtro ("El tamaño del array debe ser igual a la cantidad de los '?'")
            if($respuesta > 0){
                echo json_encode(array(
                    'respuesta'=>'200',
                    'estado' => 'Se guardaron correctamente los datos',
                    'data'=> 'El numero de registros afectaods son: '.$respuesta,
                    'error'=>''
                ));
            }else{
                echo json_encode(array(
                    'respuesta'=>'100',
                    'estado' => 'No se pudieron guardar los datos',
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
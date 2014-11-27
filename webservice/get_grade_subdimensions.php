<?php

include_once('../configuration/conf.php');
include_once(DIRROOT . '/lib/weblib.php');
include_once(DIRROOT . '/classes/plantilla.php');
include_once(DIRROOT . '/classes/dimension.php');
include_once(DIRROOT . '/classes/subdimension.php');
include_once(DIRROOT . '/classes/assessment.php');
include_once(DIRROOT . '/classes/grade.php');

/* Example of the XML received and returned by this file:

	<?xml version="1.0" encoding="utf-8"?>
	<subdimensionassessments>
		<subdimensionassessment>
			<toolid>18a8dua8sd98f9fdf8a9df</toolid>
			<subdimensionid>88a78a90safd0d0</subdimensionid>
			<assessmentid>878sad8f7afa8s9a7f8fda</assessmentid>
		<subdimensionassessment>
		[...]
	<subdimensionassessments>

	<?xml version="1.0" encoding="utf-8"?>
	<subdimensiongrades>
	  	<subdimensiongrade>
			<subdimensionid>45454ggfgffg</subdimensionid>
			<grade>90</grade>
		</subdimensiongrade>
		<subdimensiongrade>
			<subdimensionid>2222222222</subdimensionid>
			<grade>78</grade>
		</subdimensiongrade>
	<subdimensiongrades>*/

if (!isset( $HTTP_RAW_POST_DATA)) {
	$HTTP_RAW_POST_DATA = file_get_contents( 'php://input' );
}

if (!isset( $HTTP_RAW_POST_DATA)) {
	echo '<evalcomix><status>error</status><id>#1</id><description>Missing Parameters</description></evalcomix>';
	exit;
}

if(isset($_GET['format'])){
	$format = getParam($_GET['format']);
}

$xml_string = $HTTP_RAW_POST_DATA;
$xml = simplexml_load_string($xml_string);

//Definition of formats required
$required_formats = array('xml');


// Create XML to return it
header('Content-type: text/xml; charset="utf-8"', true);
echo '<?xml version="1.0" encoding="utf-8"?>
	  <subdimensiongrades>';

foreach($xml as $x){

	$toolCod = (string)$x->toolid;
	$assessmentCod = (string)$x->assessmentid;
	$subdimensionCod = (string)$x->subdimensionid;
	$grade = '';

	// Detect type of instrument
	if($tool = plantilla::fetch(array('pla_cod' => $toolCod))){
		$type = $tool->pla_tip;

		if($assessment = assessment::fetch(array('ass_id' => $assessmentCod))){

			$object = null;
			switch($type){
				case 'escala': $object = new gradescale($assessment->id, $tool->id); break;
				case 'lista': $object = new gradescale($assessment->id, $tool->id); break;
				case 'lista+escala': $object = new gradelistscale($assessment->id, $tool->id);break;
				case 'rubrica': $object = new graderubrica($assessment->id, $tool->id);break;
				case 'diferencial': $object = new gradedifferential($assessment->id, $tool->id);break;
				case 'argumentario': $object = new gradeargumentset($assessment->id, $tool->id);break;
				case 'mixto': $object = new grademix($assessmentId);break;
				default:
			}

			// Find the subdimension and get its grade
			if($dimensions = dimension::fetch_all(array('dim_pla' => $tool->id))){

				foreach($dimensions as $dimension){
					if ($subdimensions = subdimension::fetch_all(array('sub_dim' => $dimension->id))){

						foreach($subdimensions as $subdimension){
							$id = encrypt_tool_element($subdimension->id);
							if($id == $subdimensionCod){

								$grade = $object->get_grade_subdimension($subdimension, $dimension);
								break;
							}
						}
					}
				}
			}
		}
	}

	//$grade = mt_rand(0,100);

	echo '<subdimensiongrade>
			<subdimensionid>'.$subdimensionCod.'</subdimensionid>
			<grade>'.$grade.'</grade>
		  </subdimensiongrade>';
}

echo '</subdimensiongrades>';


/*

foreach($xml as $x){
	if($tool = plantilla::fetch(array('id' => $toolId))){
		$type = $tool->pla_tip;
	}
	$object = null;
	switch($type){
		case 'lista': $this->object = new gradescale($assessmentId, $toolId); break;
		case 'escala': $this->object = new gradelist($assessmentId, $toolId); break;
		//case 'lista+escala': $this->object = new gradelistscale($assessmentId, $toolId);break;
		//case 'rubrica': $this->object = new graderubrica($assessmentId, $toolId);break;
		//case 'diferencial': $this->object = new gradedifferential($assessmentId, $toolId);break;
		//case 'argumentario': $this->object = new gradeargumentset($assessmentId, $toolId);break;
		//case 'mixto': $this->object = new grademix($assessmentId);break;
		default:
	}

	if($dimensions = dimensions::fetch_all(array('dim_pla' => $plantilla->id)))
		foreach($dimensions){
			$subdimensions = subdimension::fetch_all(array('sub_dim' => $dimension->id));
			foreach($subdimeniso){
				$id = encrypt_tool_element($subdimensio->id);
				if($id == $xml_subdimens_id){
					$grade_subdimension[] = $object->get_grade_subdimension($subdimenion, $dimension);

				}
			}
		}
	}


}
*/
//TODO:
//-detectar tipo de instrumento.
//-obtener todas las subdimensiones y por cada una de ellas aplicarle el encrypt_tool_element(subdimension->id)
//$grade = new gradescale($ass1,toolid);
//$grade->get_grade_subdimension($subdimension, dimension);

?>

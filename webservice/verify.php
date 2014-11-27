<?php
	include_once('../configuration/conf.php');
	include_once(DIRROOT . '/lib/weblib.php');
	include_once(DIRROOT . '/client/tool.php');
	include_once(DIRROOT . '/classes/mixtopla.php');
	include_once(DIRROOT . '/classes/plantilla.php');
	include_once(DIRROOT . '/classes/pdo_database.php');
	
	//Comprobación de existencia y permiso de escritura de ./client/tmp
	$filename_tmp = DIRROOT . '/client/temp';
	if(!is_writable($filename_tmp)){
		header('Content-type: text/xml; charset="utf-8"', true);
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<evalcomix>
				<status>error</status>
				<description> '.$filename_tmp.' does not exist or is not writable</description>
				</evalcomix>';
		exit;
	}	
	
	$xml = '<mt:MixTool xmlns:mt="http://avanza.uca.es/assessmentservice/mixtool"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://avanza.uca.es/assessmentservice/mixtool http://avanza.uca.es/assessmentservice/MixTool.xsd"
name="Pruebas_Mixto" instruments="5">
<Description></Description>
<EvaluationSet  name="Pruebas_Mixto_Escala" dimensions="2"  percentage="20">
<Dimension name="Dimension" subdimensions="2" values="2" percentage="50">
<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
</Values>
<Subdimension name="Subdimension" attributes="1" percentage="50">
<Attribute name="Atributo" comment="" percentage="100">0</Attribute>
</Subdimension>
<Subdimension name="Subdimension2" attributes="1" percentage="50">
<Attribute name="Atributo1" comment="" percentage="100">0</Attribute>
</Subdimension>
</Dimension>
<Dimension name="Dimension2" subdimensions="1" values="5" percentage="50">
<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
<Value>Valor4</Value>
<Value>Valor5</Value>
</Values>
<Subdimension name="Subdimension1" attributes="3" percentage="50">
<Attribute name="Atributo1" comment="1" percentage="33">0</Attribute>
<Attribute name="Atributo3" comment="1" percentage="33">0</Attribute>
<Attribute name="Atributo2" comment="1" percentage="33">0</Attribute>
</Subdimension>
<DimensionAssessment percentage="50">
			<Attribute name="Global assessment" comment="1" percentage="0">0</Attribute>
		</DimensionAssessment></Dimension>
</EvaluationSet><ControlListEvaluationSet  name="Pruebas_Mixto_Lista+Escala" dimensions="2"  percentage="20">
<Dimension name="Dimension" subdimensions="2" values="4" percentage="33">
<ControlListValues>
<Value>No</Value>
<Value>Sí</Value>
</ControlListValues>
<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
<Value>Valor4</Value>
</Values>
<Subdimension name="Subdimension" attributes="3" percentage="33">
<Attribute name="Atributo" comment="" percentage="33">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
<Attribute name="Atributo2" comment="" percentage="33">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
<Attribute name="Atributo3" comment="" percentage="33">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
</Subdimension>
<Subdimension name="Subdimension2" attributes="3" percentage="33">
<Attribute name="Atributo1" comment="1" percentage="33">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
<Attribute name="Atributo2" comment="" percentage="33">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
<Attribute name="Atributo3" comment="" percentage="33">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
</Subdimension>
<DimensionAssessment percentage="33">
					<Attribute name="Global assessment" comment="1" percentage="100">0</Attribute>
				</DimensionAssessment></Dimension>
<Dimension name="Dimension2" subdimensions="1" values="2" percentage="33">
<ControlListValues>
<Value>No</Value>
<Value>Yes</Value>
</ControlListValues>
<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
</Values>
<Subdimension name="Subdimension1" attributes="1" percentage="50">
<Attribute name="Atributo1" comment="" percentage="100">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
</Subdimension>
<DimensionAssessment percentage="50">
					<Attribute name="Global assessment" comment="" percentage="100">0</Attribute>
				</DimensionAssessment></Dimension>
<GlobalAssessment values="4" percentage="33">
				<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
<Value>Valor4</Value>
</Values>

				<Attribute name="Global assessment" percentage="100">0</Attribute>
			</GlobalAssessment>
</ControlListEvaluationSet><ControlList  name="Pruebas_Mixto_Lista" dimensions="2"  percentage="20">
			<Dimension name="Dimension" subdimensions="2" values="2" percentage="50">
	<Values>
<Value>No</Value>
<Value>Sí</Value>
</Values>
<Subdimension name="Subdimension" attributes="3" percentage="50">
	<Attribute name="Atributo" comment="" percentage="33">0</Attribute>
	<Attribute name="Atributo3" comment="" percentage="33">0</Attribute>
	<Attribute name="Atributo2" comment="" percentage="33">0</Attribute>
	</Subdimension>
<Subdimension name="Subdimension2" attributes="1" percentage="50">
	<Attribute name="Atributo1" comment="" percentage="100">0</Attribute>
	</Subdimension>
</Dimension>
<Dimension name="Dimension2" subdimensions="1" values="2" percentage="50">
	<Values>
<Value>No</Value>
<Value>Yes</Value>
</Values>
<Subdimension name="Subdimension1" attributes="1" percentage="100">
	<Attribute name="Atributo1" comment="" percentage="100">0</Attribute>
	</Subdimension>
</Dimension>
</ControlList><Rubric  name="Pruebas_Mixto_Rúbrica" dimensions="2"  percentage="20">
		<Dimension name="Dimension" subdimensions="2" values="3" percentage="33">
		<Values>
<Value name="Valor1" instances="2">
<instance>1</instance>
<instance>2</instance>
</Value>
<Value name="Valor2" instances="2">
<instance>3</instance>
<instance>4</instance>
</Value>
<Value name="Valor3" instances="2">
<instance>5</instance>
<instance>6</instance>
</Value>
</Values>
<Subdimension name="Subdimension" attributes="3" percentage="33">
		<Attribute name="Atributo" comment="1" percentage="33">
						<descriptions>
<description value="0">Descripción 1</description>
<description value="1">Descripción 2</description>
<description value="2">Descripción 3</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		<Attribute name="Atributo3" comment="" percentage="33">
						<descriptions>
<description value="0">Descripción 4</description>
<description value="1">Descripción 5</description>
<description value="2">Descripción 6</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		<Attribute name="Atributo2" comment="1" percentage="33">
						<descriptions>
<description value="0">Descripción 7</description>
<description value="1">Descripción 8</description>
<description value="2">Descripción 9</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		</Subdimension>
<Subdimension name="Subdimension2" attributes="2" percentage="33">
		<Attribute name="Atributo3" comment="" percentage="50">
						<descriptions>
<description value="0">Descripción 10</description>
<description value="1">Descripción 11</description>
<description value="2">Descripción 12</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		<Attribute name="Atributo2" comment="1" percentage="50">
						<descriptions>
<description value="0">Descripción 13</description>
<description value="1">Descripción 14</description>
<description value="2">Descripción 15</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		</Subdimension>
<DimensionAssessment percentage="33">
					<Attribute name="Global assessment" comment="1" percentage="0">
					<descriptions>
<description value="0"></description>
<description value="1"></description>
<description value="2"></description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
</Attribute>
				</DimensionAssessment></Dimension>
<Dimension name="Dimension2" subdimensions="1" values="2" percentage="33">
		<Values>
<Value name="Valor1" instances="2">
<instance>1</instance>
<instance>2</instance>
</Value>
<Value name="Valor2" instances="2">
<instance>3</instance>
<instance>4</instance>
</Value>
</Values>
<Subdimension name="Subdimension1" attributes="2" percentage="100">
		<Attribute name="Atributo1" comment="" percentage="50">
						<descriptions>
<description value="0">Descripción 16</description>
<description value="1">Descripción 17</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		<Attribute name="Atributo2" comment="" percentage="50">
						<descriptions>
<description value="0">Descripción 18</description>
<description value="1">Descripción 19</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		</Subdimension>
</Dimension>
<GlobalAssessment values="5" percentage="33">
				<Values>
		<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
<Value>Valor4</Value>
<Value>Valor5</Value>
</Values>

				<Attribute name="Global assessment" percentage="0">0</Attribute>
			</GlobalAssessment>
		</Rubric><SemanticDifferential  name="Pruebas_Mixto_Diferencial" attributes="5" values="5"  percentage="20">
<Values>
<Value>-2</Value>
<Value>-1</Value>
<Value>0</Value>
<Value>1</Value>
<Value>2</Value>
</Values>
<Attribute nameN="Atributo Negativo1" nameP="Atributo Positivo1" comment="" percentage="20">0</Attribute>
<Attribute nameN="Atributo Negativo2" nameP="Atributo Positivo2" comment="" percentage="20">0</Attribute>
<Attribute nameN="Atributo Negativo3" nameP="Atributo Positivo3" comment="" percentage="20">0</Attribute>
<Attribute nameN="Atributo Negativo4" nameP="Atributo Positivo4" comment="" percentage="20">0</Attribute>
<Attribute nameN="Atributo Negativo5" nameP="Atributo Positivo5" comment="" percentage="20">0</Attribute>
</SemanticDifferential></mt:MixTool>';
	$id = uniqid('test_');
	$xml = simplexml_load_string($xml);

	$tool = new tool('es_utf8','','','','','','','','','','','','','','','','','','','','');
	$tool->import($xml);
	
	try{
		$result = $tool->save($id);
		if($plantilla = plantilla::fetch(array('pla_cod' => $id))){
			$mixtopla = mixtopla::fetch_all(array('mip_mix' => $plantilla->id));
			foreach($mixtopla as $tool){
				$pla = plantilla::fetch(array('id' => $tool->mip_pla));
				$pla->delete();
				$tool->delete();
			}
			$plantilla->delete();
		}
		header('Content-type: text/xml; charset="utf-8"', true);
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<evalcomix>
			<status>Success</status>
			<description>System Checked Successment</description>
			</evalcomix>
		';
	}
	catch(Exception $e){
		header('Content-type: text/xml; charset="utf-8"', true);
		echo '<?xml version="1.0" encoding="utf-8"?>';
		echo '<evalcomix>
				<status>error</status>
				<description> '.$e->getMessage().'</description>
				</evalcomix>';
	}
?>

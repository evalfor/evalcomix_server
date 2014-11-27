<?php
	include('../client/post_xml.php');
	/*$xml = '<es:EvaluationSet xmlns:es="http://avanza.uca.es/assessmentservice/evaluationset"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://avanza.uca.es/assessmentservice/evaluationset http://avanza.uca.es/assessmentservice/EvaluationSet.xsd" name="Versión pruebas EV_Escala para la valoración de las presentaciones orales de área temática GP_A" dimensions="1" >
<Description></Description>
<Dimension name="" subdimensions="4" values="6" percentage="100">
<Values>
<Value>1 (Ninguna)</Value>
<Value>2 (Poca)</Value>
<Value>3 (Alguna)</Value>
<Value>4 (Bastante)</Value>
<Value>5 (Mucha)</Value>
<Value>6 (Total)</Value>
</Values>
<Subdimension name="ASPECTOS FORMALES" attributes="6" percentage="25">
<Attribute name="Adecuación a los tres minutos de tiempo establecido" comment="0" percentage="16">0</Attribute>
<Attribute name="Adecuación de la vestimenta al contexto académico" comment="0" percentage="16">0</Attribute>
<Attribute name="Coordinación y colaboración del equipo durante la presentación" comment="0" percentage="16">0</Attribute>
<Attribute name="Correcta expresión gestual " comment="0" percentage="16">0</Attribute>
<Attribute name="Utilización de la 1ª persona del plural" comment="0" percentage="16">0</Attribute>
<Attribute name="Interés despertado en la audiencia" comment="1" percentage="16">0</Attribute>
</Subdimension>
<Subdimension name="CONTENIDOS DE LA PRESENTACIÓN ORAL" attributes="6" percentage="25">
<Attribute name="Organización y estructuración de la información presentada" comment="1" percentage="16">0</Attribute>
<Attribute name="Relevancia y coherencia de la información seleccionada" comment="1" percentage="16">0</Attribute>
<Attribute name="Capacidad de síntesis del área trabajada" comment="1" percentage="16">0</Attribute>
<Attribute name="Coherencia de las interrelaciones entre las áreas" comment="1" percentage="16">0</Attribute>
<Attribute name="Grado de conocimiento y dominio demostrado sobre el área trabajada" comment="1" percentage="16">0</Attribute>
<Attribute name="Relevancia e integración de los contenidos" comment="1" percentage="16">0</Attribute>
</Subdimension>
<Subdimension name="LENGUAJE" attributes="3" percentage="25">
<Attribute name="Precisión y claridad de las ideas expresadas" comment="1" percentage="33">0</Attribute>
<Attribute name="Fluidez, claridad del lenguaje y expresión oral" comment="1" percentage="33">0</Attribute>
<Attribute name="Adecuada utilización del lenguaje técnico" comment="1" percentage="33">0</Attribute>
</Subdimension>
<Subdimension name="RECURSOS" attributes="3" percentage="25">
<Attribute name="Coherencia de la estructura y organización de la presentación" comment="1" percentage="33">0</Attribute>
<Attribute name="Claridad y concisión de las diapositivas" comment="1" percentage="33">0</Attribute>
<Attribute name="Adecuación del diseño de las diapositivas (colores, tamaño) " comment="1" percentage="33">0</Attribute>
</Subdimension>
</Dimension>
</es:EvaluationSet>
';
*/
$xml = '<cl:ControlList xmlns:cl="http://avanza.uca.es/assessmentservice/controllist"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://avanza.uca.es/assessmentservice/controllist http://avanza.uca.es/assessmentservice/ControlList.xsd"
	 name="lista01" dimensions="3" >
			<Description></Description>
				<Dimension name="Dimension1" subdimensions="1" values="2" percentage="33">
	<Values>
<Value>No</Value>
<Value>Sí</Value>
</Values>
<Subdimension name="Subdimension1" attributes="4" percentage="100">
	<Attribute name="Atributo1" comment="1" percentage="25">0</Attribute>
	<Attribute name="Atributo2" comment="" percentage="25">0</Attribute>
	<Attribute name="Atributo3" comment="1" percentage="25">0</Attribute>
	<Attribute name="Atributo4" comment="" percentage="25">0</Attribute>
	</Subdimension>
</Dimension>
<Dimension name="Dimension3" subdimensions="1" values="2" percentage="33">
	<Values>
<Value>No</Value>
<Value>Yes</Value>
</Values>
<Subdimension name="Subdimension1" attributes="1" percentage="100">
	<Attribute name="Atributo1" comment="" percentage="100">0</Attribute>
	</Subdimension>
</Dimension>
<Dimension name="Dimension2" subdimensions="1" values="2" percentage="33">
	<Values>
<Value>No</Value>
<Value>Yes</Value>
</Values>
<Subdimension name="Subdimension1" attributes="1" percentage="100">
	<Attribute name="Atributo1" comment="1" percentage="100">0</Attribute>
	</Subdimension>
</Dimension>
</cl:ControlList>
'; 
$xml = '<ce:ControlListEvaluationSet xmlns:ce="http://avanza.uca.es/assessmentservice/controllistevaluationset"
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		xsi:schemaLocation="http://avanza.uca.es/assessmentservice/controllistevaluationset http://avanza.uca.es/assessmentservice/ControlListEvaluationSet.xsd"
 name="lista + escala01" dimensions="2" >
<Description></Description>
<Dimension name="Dimension1" subdimensions="2" values="3" percentage="33">
<ControlListValues>
<Value>No</Value>
<Value>Sí</Value>
</ControlListValues>
<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
</Values>
<Subdimension name="Subdimension1" attributes="2" percentage="33">
<Attribute name="Atributo1" comment="1" percentage="50">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
<Attribute name="Atributo2" comment="1" percentage="50">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
</Subdimension>
<Subdimension name="Subdimension2" attributes="2" percentage="33">
<Attribute name="Atributo1" comment="" percentage="50">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
<Attribute name="Atributo2" comment="" percentage="50">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
</Subdimension>
<DimensionAssessment percentage="34">
					<Attribute name="Global assessment" comment="" percentage="100">0</Attribute>
				</DimensionAssessment></Dimension>
<Dimension name="Dimension2" subdimensions="1" values="4" percentage="33">
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
<Subdimension name="Subdimension1" attributes="2" percentage="50">
<Attribute name="Atributo1" comment="" percentage="50">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
<Attribute name="Atributo2" comment="1" percentage="50">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
</Subdimension>
<DimensionAssessment percentage="50">
					<Attribute name="Global assessment" comment="1" percentage="100">0</Attribute>
				</DimensionAssessment></Dimension>
<GlobalAssessment values="4" percentage="34">
				<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
<Value>Valor4</Value>
</Values>

				<Attribute name="Global assessment" percentage="100">0</Attribute>
			</GlobalAssessment>
</ce:ControlListEvaluationSet>
';
/*
$xml = '<ru:Rubric xmlns:ru="http://avanza.uca.es/assessmentservice/rubric"
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		xsi:schemaLocation="http://avanza.uca.es/assessmentservice/rubric http://avanza.uca.es/assessmentservice/Rubric.xsd"
		 name="Rúbrica01" dimensions="2" >
		<Description></Description>
<Dimension name="Dimension1" subdimensions="1" values="3" percentage="33">
		<Values>
<Value name="Valor1" instances="2">
<instance>1</instance>
<instance>2</instance>
</Value>
<Value name="Valor2" instances="2">
<instance>3</instance>
<instance>4</instance>
</Value>
<Value name="Valor3" instances="1">
<instance>5</instance>
</Value>
</Values>
<Subdimension name="Subdimension1" attributes="2" percentage="50">
		<Attribute name="Atributo1" comment="1" percentage="50">
						<descriptions>
<description value="0">descripcion 1</description>
<description value="1">descripcion 2</description>
<description value="2">descripcion 3</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		<Attribute name="Atributo2" comment="" percentage="50">
						<descriptions>
<description value="0">descripcion 4</description>
<description value="1">descripcion 5</description>
<description value="2">descripcion 6</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		</Subdimension>
<DimensionAssessment percentage="50">
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
<Dimension name="Dimension2" subdimensions="1" values="3" percentage="33">
		<Values>
<Value name="Valor1" instances="2">
<instance>1</instance>
<instance>2</instance>
</Value>
<Value name="Valor2" instances="2">
<instance>3</instance>
<instance>4</instance>
</Value>
<Value name="Valor3" instances="1">
<instance>5</instance>
</Value>
</Values>
<Subdimension name="Subdimension1" attributes="2" percentage="50">
		<Attribute name="Atributo1" comment="" percentage="50">
						<descriptions>
<description value="0">descripcion </description>
<description value="1">descripcion </description>
<description value="2">descripcion </description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		<Attribute name="Atributo2" comment="" percentage="50">
						<descriptions>
<description value="0">descripcion </description>
<description value="1">descripcion </description>
<description value="2">descripcion </description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		</Subdimension>
<DimensionAssessment percentage="50">
					<Attribute name="Global assessment" comment="" percentage="0">
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
<GlobalAssessment values="4" percentage="34">
				<Values>
		<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
<Value>Valor4</Value>
</Values>

				<Attribute name="Global assessment" percentage="0">0</Attribute>
			</GlobalAssessment>
		</ru:Rubric>
';
*/
$xml = '<sd:SemanticDifferential xmlns:sd="http://avanza.uca.es/assessmentservice/semanticdifferential"
		xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		xsi:schemaLocation="http://avanza.uca.es/assessmentservice/semanticdifferential http://avanza.uca.es/assessmentservice/SemanticDifferential.xsd"
		 name="diferencial01" attributes="5" values="5" >
<Description></Description>
<Values>
<Value>-2</Value>
<Value>-1</Value>
<Value>0</Value>
<Value>1</Value>
<Value>2</Value>
</Values>
<Attribute nameN="Atributo Negativo1" nameP="Atributo Positivo1" comment="1" percentage="20">0</Attribute>
<Attribute nameN="Atributo Negativo2" nameP="Atributo Positivo2" comment="" percentage="20">0</Attribute>
<Attribute nameN="Atributo Negativo3" nameP="Atributo Positivo3" comment="1" percentage="20">0</Attribute>
<Attribute nameN="Atributo Negativo4" nameP="Atributo Positivo4" comment="" percentage="20">0</Attribute>
<Attribute nameN="Atributo Negativo5" nameP="Atributo Positivo5" comment="" percentage="20">0</Attribute>
</sd:SemanticDifferential>
';
$xml = '<mt:MixTool xmlns:mt="http://avanza.uca.es/assessmentservice/mixtool"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://avanza.uca.es/assessmentservice/mixtool http://avanza.uca.es/assessmentservice/MixTool.xsd"
name="mixta01" instruments="5">
<Description></Description>
<EvaluationSet  name="escala01" dimensions="1"  percentage="20">
<Description></Description>
<Dimension name="Dimension" subdimensions="1" values="3" percentage="50">
<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
</Values>
<Subdimension name="Subdimension" attributes="3" percentage="50">
<Attribute name="Atributo" comment="1" percentage="33">0</Attribute>
<Attribute name="Atributo3" comment="" percentage="33">0</Attribute>
<Attribute name="Atributo2" comment="1" percentage="33">0</Attribute>
</Subdimension>
<DimensionAssessment percentage="50">
			<Attribute name="Global assessment" comment="1" percentage="0">0</Attribute>
		</DimensionAssessment></Dimension>
<GlobalAssessment values="4" percentage="50">
		<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
<Value>Valor4</Value>
</Values>
		<Attribute name="Global assessment" percentage="0">0</Attribute>
	</GlobalAssessment>
</EvaluationSet><ControlListEvaluationSet  name="lista+escala01" dimensions="1"  percentage="20">
<Description></Description>
<Dimension name="Dimension" subdimensions="2" values="2" percentage="50">
<ControlListValues>
<Value>No</Value>
<Value>Sí</Value>
</ControlListValues>
<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
</Values>
<Subdimension name="Subdimension" attributes="2" percentage="33">
<Attribute name="Atributo" comment="1" percentage="50">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
<Attribute name="Atributo2" comment="" percentage="50">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
</Subdimension>
<Subdimension name="Subdimension2" attributes="1" percentage="33">
<Attribute name="Atributo2" comment="1" percentage="100">
			<selectionControlList>0</selectionControlList>
			<selection>0</selection>
		</Attribute>
</Subdimension>
<DimensionAssessment percentage="34">
					<Attribute name="Global assessment" comment="" percentage="100">0</Attribute>
				</DimensionAssessment></Dimension>
<GlobalAssessment values="3" percentage="50">
				<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
</Values>

				<Attribute name="Global assessment" percentage="100">0</Attribute>
			</GlobalAssessment>
</ControlListEvaluationSet><ControlList  name="lista01" dimensions="1"  percentage="20">
			<Description></Description>
				<Dimension name="Dimension" subdimensions="1" values="2" percentage="100">
	<Values>
<Value>No</Value>
<Value>Sí</Value>
</Values>
<Subdimension name="Subdimension" attributes="4" percentage="100">
	<Attribute name="Atributo" comment="1" percentage="25">0</Attribute>
	<Attribute name="Atributo4" comment="" percentage="25">0</Attribute>
	<Attribute name="Atributo3" comment="1" percentage="25">0</Attribute>
	<Attribute name="Atributo2" comment="" percentage="25">0</Attribute>
	</Subdimension>
</Dimension>
</ControlList><Rubric  name="rubrica01" dimensions="1"  percentage="20">
		<Description></Description>
<Dimension name="Dimension" subdimensions="1" values="3" percentage="50">
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
<Subdimension name="Subdimension" attributes="4" percentage="50">
		<Attribute name="Atributo" comment="1" percentage="25">
						<descriptions>
<description value="0">descripción 1</description>
<description value="1">descripción 2</description>
<description value="2">descripción 3</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		<Attribute name="Atributo2" comment="" percentage="25">
						<descriptions>
<description value="0">descripción 4</description>
<description value="1">descripción 5</description>
<description value="2">descripción 6</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		<Attribute name="Atributo3" comment="1" percentage="25">
						<descriptions>
<description value="0">descripción 7</description>
<description value="1">descripción 8</description>
<description value="2">descripción 9</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		<Attribute name="Atributo4" comment="" percentage="25">
						<descriptions>
<description value="0">descripción 10</description>
<description value="1">descripción 11</description>
<description value="2">descripción 12</description>
</descriptions>
						<selection>
							<val>0</val>
							<instance>0</instance>
						</selection>
		</Attribute>
		</Subdimension>
<DimensionAssessment percentage="50">
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
<GlobalAssessment values="4" percentage="50">
				<Values>
		<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
<Value>Valor4</Value>
</Values>

				<Attribute name="Global assessment" percentage="0">0</Attribute>
			</GlobalAssessment>
		</Rubric><SemanticDifferential  name="diferencial01" attributes="3" values="3"  percentage="20">
<Description></Description>
<Values>
<Value>-1</Value>
<Value>0</Value>
<Value>1</Value>
</Values>
<Attribute nameN="Atributo Negativo1" nameP="Atributo Positivo1" comment="1" percentage="33">0</Attribute>
<Attribute nameN="Atributo Negativo2" nameP="Atributo Positivo2" comment="" percentage="33">0</Attribute>
<Attribute nameN="Atributo Negativo3" nameP="Atributo Positivo3" comment="1" percentage="33">0</Attribute>
</SemanticDifferential></mt:MixTool>
';
$xml = '<es:EvaluationSet xmlns:es="http://avanza.uca.es/assessmentservice/evaluationset"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://avanza.uca.es/assessmentservice/evaluationset http://avanza.uca.es/assessmentservice/EvaluationSet.xsd" name="escala01_evalcomix41" dimensions="2" >
<Description></Description>
<Dimension name="Dimension1" subdimensions="2" values="2" percentage="33">
<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
</Values>
<Subdimension name="Subdimension1" attributes="2" percentage="33">
<Attribute name="Atributo1" comment="1" percentage="50">0</Attribute>
<Attribute name="Atributo2" comment="" percentage="50">0</Attribute>
</Subdimension>
<Subdimension name="Subdimension2" attributes="2" percentage="33">
<Attribute name="Atributo2" comment="" percentage="50">0</Attribute>
<Attribute name="Atributo2" comment="1" percentage="50">0</Attribute>
</Subdimension>
<DimensionAssessment percentage="34">
			<Attribute name="Global assessment" comment="1" percentage="0">0</Attribute>
		</DimensionAssessment></Dimension>
<Dimension name="Dimension2" subdimensions="1" values="5" percentage="33">
<Values>
<Value>Valor1</Value>
<Value>Valor2</Value>
<Value>Valor3</Value>
<Value>Valor4</Value>
<Value>Valor5</Value>
</Values>
<Subdimension name="Subdimension1" attributes="2" percentage="50">
<Attribute name="Atributo1" comment="" percentage="50">0</Attribute>
<Attribute name="Atributo2" comment="1" percentage="50">0</Attribute>
</Subdimension>
<DimensionAssessment percentage="50">
			<Attribute name="Global assessment" comment="" percentage="0">0</Attribute>
		</DimensionAssessment></Dimension>
</es:EvaluationSet>
';
	$id = md5(time());
	/*include_once('../classes/plantilla.php');
	if($tools = plantilla::fetch_all()){
		foreach($tools as $tool){
			$url = 'http://lince.uca.es/evalfor/evalcomix41/webservice/delete_tool.php?id='.$tool->pla_cod;
			
			if($xml = simplexml_load_file($url)){
				print_r($xml);
			}
		}
	}*/
	
	$url = 'http://lince.uca.es/evalfor/evalcomix41/webservice/import_tool.php?id=658301866318672';
	//$url = 'http://lince.uca.es/evalfor/evalcomix41/webservice/import_tool.php?id='.$id;
	$response = xml_post($xml, $url, 80);
	print_r($response);
?>
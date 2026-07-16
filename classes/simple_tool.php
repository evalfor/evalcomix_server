<?php

class simple_tool{
	public $id;
	public $title;
	public $observation;
	public $description;
	public $percentage;
	public $num_dimensions;
	public $type;
	public $yesnovglobal;
	public $total_value_por;
	public $pla_cod;
	
	public $num_values_dim;
	public $values_dim;
	public $values_dimension_id;
	public $dimen_code;
	public $dimen_com;
	public $global_value;
	public $global_value_por;
	public $percentages_dim;
	
	public $num_subdimension;
	public $name_subdimension;
	public $subdimension_code;
	public $percentage_subdimension;
	public $subdimension_id;
	
	public $num_atr_dim;
	public $attributes;
	public $attributes_percentage;
	public $attributes_code;
	public $attributes_com;
	
	public $num_total_value;
	public $name_total_values;
	public $cod_total_values;
	
	public $num_rango;
	public $rango;
	public $rango_id;
	public $description_rubric;
	public $description_rubric_id;

	public $grade_attribute;
	public $grade_attribute_range;
	public $grade_dimension;
	public $grade_dimension_range;
	public $grade_tool;	
	public $comment_attribute;
	public $comment_dimension;
	
	function __construct($id){
		if (isset($id) and is_numeric($id)){
			$this->id = $id;
		}
	}

	public function recovery_grades($assessments)
    {
        require_once('db.php');

        if (empty($assessments)) {
            return false;
        }

        // ============================
        // Obtener IDs de evaluaciones
        // ============================

        $assessmentIds = [];

        foreach ($assessments as $assessment) {
            $assessmentIds[] = (int)$assessment->id;
        }

        $idList = implode(',', $assessmentIds);

        // ============================
        // Cargar TODAS las valoraciones
        // ============================

        $attributeGrades = [];
        $attributeComments = [];
        $dimensionGrades = [];
        $dimensionComments = [];
        $toolGrades = [];

        // ---- ATRIBUTOS ----

        $sql = "
            SELECT
                ate_eva,
                atributo.id AS atributoid,
                ate_val,
                ate_ran
            FROM atreva
            INNER JOIN atributo
                ON ate_atr = atributo.id
            INNER JOIN subdimension
                ON atr_sub = subdimension.id
            INNER JOIN dimen
                ON sub_dim = dimen.id
            WHERE dim_pla = {$this->id}
            AND ate_eva IN ($idList)
        ";

        $rst = db::query($sql);

        while ($row = db::next_row($rst)) {

            $attributeGrades[
                $row['ate_eva']
            ][
                $row['atributoid']
            ] = [
                'value' => $row['ate_val'],
                'range' => $row['ate_ran']
            ];
        }

        // ---- COMENTARIOS ATRIBUTOS ----

        $sql = "
            SELECT
                atc_eva,
                atributo.id AS atributoid,
                atc_obs
            FROM atrcomment
            INNER JOIN atributo
                ON atc_atr = atributo.id
            INNER JOIN subdimension
                ON atr_sub = subdimension.id
            INNER JOIN dimen
                ON sub_dim = dimen.id
            WHERE dim_pla = {$this->id}
            AND atc_eva IN ($idList)
        ";

        $rst = db::query($sql);

        while ($row = db::next_row($rst)) {

            $attributeComments[
                $row['atc_eva']
            ][
                $row['atributoid']
            ] = $row['atc_obs'];
        }

        // ---- DIMENSIONES ----

        $sql = "
            SELECT
                die_eva,
                dimen.id AS dimensionid,
                die_val,
                die_ran
            FROM dimeva
            INNER JOIN dimen
                ON die_dim = dimen.id
            WHERE dim_pla = {$this->id}
            AND die_eva IN ($idList)
        ";

        $rst = db::query($sql);

        while ($row = db::next_row($rst)) {

            $dimensionGrades[
                $row['die_eva']
            ][
                $row['dimensionid']
            ] = [
                'value' => $row['die_val'],
                'range' => $row['die_ran']
            ];
        }

        // ---- COMENTARIOS DIMENSIONES ----

        $sql = "
            SELECT
                dic_eva,
                dimen.id AS dimensionid,
                dic_obs
            FROM dimcomment
            INNER JOIN dimen
                ON dic_dim = dimen.id
            WHERE dim_pla = {$this->id}
            AND dic_eva IN ($idList)
        ";

        $rst = db::query($sql);

        while ($row = db::next_row($rst)) {

            $dimensionComments[
                $row['dic_eva']
            ][
                $row['dimensionid']
            ] = $row['dic_obs'];
        }

        // ---- HERRAMIENTA ----

        $sql = "
            SELECT
                ple_eva,
                ple_val
            FROM plaeva
            WHERE ple_pla = {$this->id}
            AND ple_eva IN ($idList)
        ";

        $rst = db::query($sql);

        while ($row = db::next_row($rst)) {

            $toolGrades[$row['ple_eva']] =
                $row['ple_val'];
        }

        // ============================
        // Contadores
        // ============================

        $rate = [];
        $rateRange = [];
        $rateDimension = [];
        $rateDimensionRange = [];
        $rateTool = [];

        // ============================
        // Procesamiento
        // ============================

        foreach ($assessments as $assessmentIndex => $assessment) {

            $assessmentId = (int)$assessment->id;

            if (isset($assessment->ass_com)) {
                $this->observation = $assessment->ass_com;
            }

            for ($i = 0; $i < $this->num_dimensions; $i++) {

                $dimensionId = $this->dimen_code[$i];

                // ----------------------
                // DIMENSIONES
                // ----------------------

                if (isset(
                    $dimensionGrades[$assessmentId][$dimensionId]
                )) {

                    $value =
                        $dimensionGrades[$assessmentId][$dimensionId]['value'];

                    $rateDimension[$i][$value] =
                        ($rateDimension[$i][$value] ?? 0) + 1;

                    if ($this->type === 'rubrica') {

                        $range =
                            $dimensionGrades[$assessmentId][$dimensionId]['range'];

                        $rateDimensionRange[$i][$range] =
                            ($rateDimensionRange[$i][$range] ?? 0) + 1;
                    }
                }

                if (isset(
                    $dimensionComments[$assessmentId][$dimensionId]
                )) {

                    $this->comment_dimension[$i] =
                        $dimensionComments[$assessmentId][$dimensionId];
                }

                // ----------------------
                // ATRIBUTOS
                // ----------------------

                for ($l = 0; $l < $this->num_subdimension[$i]; $l++) {

                    for ($j = 0; $j < $this->num_atr_dim[$i][$l]; $j++) {

                        $attributeId =
                            $this->attributes_code[$i][$l][$j];

                        if (isset(
                            $attributeGrades[$assessmentId][$attributeId]
                        )) {

                            $value =
                                $attributeGrades[$assessmentId][$attributeId]['value'];

                            $rate[$i][$l][$j][$value] =
                                ($rate[$i][$l][$j][$value] ?? 0) + 1;

                            if ($this->type === 'rubrica') {

                                $range =
                                    $attributeGrades[$assessmentId][$attributeId]['range'];

                                $rateRange[$i][$l][$j][$range] =
                                    ($rateRange[$i][$l][$j][$range] ?? 0) + 1;
                            }
                        }

                        if (isset(
                            $attributeComments[$assessmentId][$attributeId]
                        )) {

                            $this->comment_attribute[$i][$l][$j] =
                                $attributeComments[$assessmentId][$attributeId];
                        }
                    }
                }
            }

            if (isset($toolGrades[$assessmentId])) {

                $value = $toolGrades[$assessmentId];

                $rateTool[$value] =
                    ($rateTool[$value] ?? 0) + 1;
            }
        }

        // ============================
        // Calcular moda
        // ============================

        for ($i = 0; $i < $this->num_dimensions; $i++) {

            if (!empty($rateDimension[$i])) {
                arsort($rateDimension[$i]);
                $this->grade_dimension[$i] =
                    key($rateDimension[$i]);
            }

            if (!empty($rateDimensionRange[$i])) {
                arsort($rateDimensionRange[$i]);
                $this->grade_dimension_range[$i] =
                    key($rateDimensionRange[$i]);
            }

            for ($l = 0; $l < $this->num_subdimension[$i]; $l++) {

                for ($j = 0; $j < $this->num_atr_dim[$i][$l]; $j++) {

                    if (!empty($rate[$i][$l][$j])) {
                        arsort($rate[$i][$l][$j]);
                        $this->grade_attribute[$i][$l][$j] =
                            key($rate[$i][$l][$j]);
                    }

                    if (!empty($rateRange[$i][$l][$j])) {
                        arsort($rateRange[$i][$l][$j]);
                        $this->grade_attribute_range[$i][$l][$j] =
                            key($rateRange[$i][$l][$j]);
                    }
                }
            }
        }

        if (!empty($rateTool)) {
            arsort($rateTool);
            $this->grade_tool = key($rateTool);
        }

        return true;
    }
	
	function recovery(){
		require_once('plantilla.php');
		require_once('dimension.php');
		require_once('subdimension.php');
		require_once('atributo.php');
		require_once('dimval.php');
		require_once('rango.php');
		require_once('ranval.php');
		require_once('atribdes.php');
		require_once('plaval.php');
		require_once('valoracion.php');
		$plantilla = plantilla::fetch(array('id' => $this->id));

		$this->title = $plantilla->pla_tit;
		$this->description = $plantilla->pla_des;
		$this->observation = '';
		$this->percentage = $plantilla->pla_por;		
		$this->type = $plantilla->pla_tip;
		$this->yesnovglobal = $plantilla->pla_glo;
		$this->total_value_por = $plantilla->pla_gpr;
		$this->pla_cod = $plantilla->pla_cod;
		
		if($plaval = plaval::fetch_all(array('plv_pla' => $this->id))){
			$this->num_total_value = count($plaval);
			$i = 0;
			foreach($plaval as $plv){
				$this->name_total_values[$i] = $plv->plv_val;
				$this->cod_total_values[$i] = $plv->id;
				++$i;
			}
		}
		
		$dimensions = dimension::fetch_all(array('dim_pla' => $this->id), array('dim_pos'));
		$this->num_dimensions = count($dimensions);
		$i = 0;
		foreach($dimensions as $dimension){
			$this->dimen_code[$i] = $dimension->id;
			$this->dimen_com[$i] = $dimension->dim_com;
			$this->global_value[$i] = $dimension->dim_glo;
			$this->global_value_por[$i] = $dimension->dim_gpr;
			$this->percentages_dim[$i] = $dimension->dim_por;
			
			$dimval = dimval::fetch_all(array('div_dim' => $dimension->id), array('div_pos'));
			$this->num_values_dim[$i] = count($dimval);
			$this->values_dim[$i][0] = $dimension->dim_nom;
			$v = 1;
			foreach($dimval as $div){
				$this->values_dim[$i][$v] = $div->div_val;
				$this->values_dimension_id[$i][$v] = $div->id;
				if($this->type == 'rubrica' && $ranval = ranval::fetch_all(array('rav_dim' => $dimension->id, 'rav_val' => $div->div_val), array('rav_pos'))){
					$this->num_rango[$i][$v-1] = count($ranval);
					$r = 0;
					foreach($ranval as $rav){
						$this->rango[$i][$v-1][$r] = $rav->rav_ran;
						$this->rango_id[$i][$v-1][$r] = $rav->id;
						++$r;
					}
				}
				++$v;
			}
			
			$subdimensions = subdimension::fetch_all(array('sub_dim' => $dimension->id), array('sub_pos'));
			$this->num_subdimension[$i] = count($subdimensions);
			$j = 0;
			$subkeys = array_keys($subdimensions);
			
			$order = 'atr_pos';
			if($this->type == 'diferencial'){
				$order = 'atr_pos, id';
			}
			$sqlatr = 'SELECT *
FROM atributo
WHERE atr_sub IN ('.implode(',', $subkeys).')
ORDER BY '. $order;//echo $sqlatr . '<br>';
			$attributes = array();
			$atrraw = array();
			if ($rst_atr = db::query($sqlatr)) {
				foreach ($rst_atr as $item) {
					$subid = $item['atr_sub'];
					$atrid = $item['id'];
					$attributes[$subid][$atrid] = (object)$item;
					$atrraw[$atrid] = (object)$item;
				}
			}
			
			$attid = array_keys($atrraw);
			$atribdes = array();
			if ($this->type == 'rubrica') {
				$sqlatribdes = 'SELECT * FROM atribdes WHERE atd_atr IN ('.implode(',', $attid).')';//echo "$sqlatribdes<br>";
				$rst_atribdes = db::query($sqlatribdes);
				foreach ($rst_atribdes as $item) {
					$atd_atr = $item['atd_atr'];
					$atd_val = $item['atd_val'];
					$atribdes[$atd_atr][$atd_val] = $item;
				}
			}
			
			foreach($subdimensions as $subdimension){
				$subdimid = $subdimension->id;
				$this->name_subdimension[$i][$j] = $subdimension->sub_nom;
				$this->subdimension_code[$i][$j] = $subdimension->id;
				$this->subdimension_id[$i][$j] = (!empty($subdimension->sub_cod)) ? $subdimension->sub_cod : 
					encrypt_tool_element($subdimension->id);
				$this->percentage_subdimension[$i][$j] = $subdimension->sub_por;
				
				/*$order = array('atr_pos');
				if($this->type == 'diferencial'){
					$order = array('atr_pos', 'id');
				}*/
				
				//$attributes = atributo::fetch_all(array('atr_sub' => $subdimension->id), $order);
				
				$this->num_atr_dim[$i][$j] = count($attributes[$subdimid]);
				$k = 0;
				foreach($attributes[$subdimid] as $attribute){
					$atrid = $attribute->id;
					$this->attributes[$i][$j][$k] = $attribute->atr_des;
					$this->attributes_percentage[$i][$j][$k] = $attribute->atr_por;
					$this->attributes_code[$i][$j][$k] = $attribute->id;
					$this->attributes_com[$i][$j][$k] = $attribute->atr_com;
			
					$l = 0;
					foreach($dimval as $div){
						$div_val = $div->div_val;
						if (!empty($atribdes[$atrid][$div_val])) {
							$this->description_rubric[$i][$j][$k][$l] = $atribdes[$atrid][$div_val]['atd_des'];
							$this->description_rubric_id[$i][$j][$k][$l] = $atribdes[$atrid][$div_val]['id'];
						}
						/*if($atribdes = atribdes::fetch(array('atd_val' => $div->div_val, 'atd_atr' => $attribute->id))){
							$this->description_rubric[$i][$j][$k][$l] = $atribdes->atd_des;
							$this->description_rubric_id[$i][$j][$k][$l] = $atribdes->id;
						}*/
						++$l;
					}
					++$k;
				}
				++$j;
			}
			++$i;
		}
	}
	
	/**
	* Converts $scale in numeric $scale from 0 to 100
	* @param array $scale array of values alphanumeric
	* @return array with numeric scale
	*/
	/*public static function get_numeric_scale($scale){
		if(!is_array($scale)){
			return false;
		}
		$is_numeric = true;
		foreach($scale as $grade){
			if(!is_numeric($grade)){
				$is_numeric = false;
			}
		}
		
		if($is_numeric){
			return $scale;
		}
		
		$result = array();
		
		//First Value
		$key = $scale[0];
		$result[$key] = 0;
		
		//Next Values
		$size = count($scale);
		$distance = 100 / ($size - 1);
		$accumulator = 0;
		for($i = 1; $i <= ($size - 1); $i++){
			$accumulator += $distance;
			$key = $scale[$i];
			$result[$key] = $accumulator;
			if($i == ($size - 1)){
				$result[$key] = 100;
			}
		}		
		return $result;
	}*/
}
function validar(e) {
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==8 || tecla==37 || tecla==39 || tecla==46 || tecla==0) return true;
		//patron =/[A-Za-zñÑ\s/./-/_/:/;]/;
		patron = /\d/;
		te = String.fromCharCode(tecla);
		return patron.test(te);
}
						
function validarEntero(valor){
      //intento convertir a entero.
     //si era un entero no le afecta, si no lo era lo intenta convertir
     valor = parseInt(valor)

      //Compruebo si es un valor numérico
      if (isNaN(valor)) {
            //entonces (no es numero) devuelvo el valor cadena vacia
			//alert("Valor no numérico");
            return false
      }else{
            //En caso contrario (Si era un número) devuelvo el valor
            return valor
      }
} 

function valida(campo){
      //extraemos el valor del campo
      textoCampo = campo.value
      //lo validamos como entero
      textoCampo = validarEntero(textoCampo)
      //colocamos el valor de nuevo
      campo.value = textoCampo
} 
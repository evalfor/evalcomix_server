function validarEntero(valor){
      //intento convertir a entero.
     //si era un entero no le afecta, si no lo era lo intenta convertir
     valor = parseInt(valor)

      //Compruebo si es un valor numérico
      if (isNaN(valor)) {
            //entonces (no es numero) devuelvo el valor cadena vacia
            return “”
      }else{
            //En caso contrario (Si era un número) devuelvo el valor
            return valor
      }
} 

function valida(campo){alert("hola");
      //extraemos el valor del campo
      textoCampo = campo.value
      //lo validamos como entero
      textoCampo = validarEntero(textoCampo)
      //colocamos el valor de nuevo
      campo.value = textoCampo
} 
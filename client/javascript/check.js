function validarEntero(valor){
     //intento convertir a entero.
     //si era un entero no le afecta, si no lo era lo intenta convertir
     valoraux = parseInt(valor)

      //Compruebo si es un valor numérico
      if (isNaN(valor) || isNaN(valoraux) || valoraux == 0) {
            //entonces (no es numero) devuelvo el valor cadena vacia
            return false
      }else{
            //En caso contrario (Si era un número) devuelvo el valor
            return true
      }
}

 //busca caracteres que no sean espacio en blanco en una cadena
 function vacio(q) {
         for ( i = 0; i < q.length; i++ ) {
                 if ( q.charAt(i) != " " ) {
                         return true
                 }
         }
         return false
 }
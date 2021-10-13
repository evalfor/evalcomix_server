function archivo(evt) {
                  var files = evt.target.files; // FileList object
             
                  // Obtenemos la imagen del campo "file".
                  for (var i = 0, f; f = files[i]; i++) {
                    //Solo admitimos imágenes.
                    if (!f.type.match('image.*')) {
                        continue;
                    }
             
                    var reader = new FileReader();
             
                    reader.onload = (function(theFile) {
                        return function(e) {
                          // Insertamos la imagen
                         document.getElementById("list").innerHTML = ['<img class="thumb" src="', e.target.result,'" style="max-height:12em; max-width:100%" title="', escape(theFile.name), '" data-toggle="modal" data-target="#myModal"/> <div class="modal fade" id="myModal" role="dialog"><div class="modal-dialog modal-lg"><!-- Modal content--><div class="modal-content"><div class="modal-body"><img src="', e.target.result,'" style="width:50%"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>'].join('');
                        };
                    })(f);
             
                    reader.readAsDataURL(f);
                  }
              }

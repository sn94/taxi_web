<script>
            var FirstDeletingDone_user= false;
            var FirstDeletingDone_pass= false;
            function resetear( ev){ 
               if(  ev.target.id =="nick" && !FirstDeletingDone_user ){ 
                ev.target.value=""; FirstDeletingDone_user= true;
               }
               if(  ev.target.id =="pass-nick" && !FirstDeletingDone_pass ){ 
                ev.target.value=""; FirstDeletingDone_pass= true;
               }
              
            }


            function hab_deshab_pass(ev){
                document.getElementById("pass-nick").disabled= !ev.target.checked;
            }
           
</script>
<?php  echo form_open("usuario/edit/{$datos->cedula}/1", array("onsubmit" => "verificar(event)") ); ?>

    <div class="row">
        <div class="col-sm col-md-6">
                <label class="text-light"  for="cedula">CI</label>
                <input  class="form-control" type="text"  name="cedula" readonly value="<?= $datos->cedula?>"/>
                <label class="text-light"  for="nombres">Nombres</label>
                <input class="form-control" type="text" name="nombres"  maxlength="30" value="<?= $datos->nombres?>" />
               
               <label class="text-light"  for="telefono">Telefono</label>
                <input class="form-control" type="text" name="telefono"  maxlength="20"   value="<?= $datos->telefono?>" />
                <label class="text-light"  for="celular">Celular</label>
                <input class="form-control" type="text" name="celular"  maxlength="20"   value="<?= $datos->celular?>"/>
                <label class="text-light"  for="email">Email</label>
                <input class="form-control"  type="text" name="email"   maxlength="50" value="<?= $datos->email?>"/>

        </div>
        <div class="col-sm col-md-6">
                <label class="text-light"  for="observacion">Observacion</label>
                <textarea  class="form-control"  name="observacion" ><?= $datos->observacion?></textarea>

                <label class="text-light"  for="usuario">Usuario </label>
                <input id="nick"  class="form-control" type="text" name="usuario" value="<?= $datos->usuario?>" maxlength="20"   />


                <label class="text-light"  for="pass">Password
                 <input onchange="hab_deshab_pass(event)" type="checkbox" id="edit-pass"/>Editar</label>
                <input id="pass-nick" class="form-control"   disabled  type="password" name="pass" maxlength="20" />
                
                <label class="text-light"  for="tipousuario">Tipo de usuario:</label>

                <select  class="form-control"  name="tipousuario"  >
                    <option value="V">Vendedor</option>
                    <option value="A">Administrativo</option> 
                    <option value="S">Supervisor</option> 
                </select> 
                <label class="text-light"  for="comision">Comisi&oacute;n %</label>
                 <input  class="form-control" maxlength="2" type="text" name="comision" value="<?= $datos->comision?>"  oninput="numericInput(event)"  />
                
                <button class="btn btn-info mt-1" type="submit">Guardar</button>
        </div>
    </div> 
               
                
</form>
 
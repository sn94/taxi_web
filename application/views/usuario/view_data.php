<div class="row">
    <div class="col-sm col-md-6">
                <label class="text-light" for="cedula">CI</label>
                <input class="form-control"  type="text"  name="cedula" readonly value="<?= $datos->cedula?>"/>
                <label class="text-light" for="nombres">Nombres</label>
                <input class="form-control"  type="text" name="nombres"  readonly   value="<?= $datos->nombres?>" />
               
               <label class="text-light" for="telefono">Telefono</label>
                <input class="form-control"  type="text" name="telefono" readonly      value="<?= $datos->telefono?>" />
                <label class="text-light" for="celular">Celular</label>
                <input class="form-control"  type="text" name="celular" readonly    value="<?= $datos->celular?>"/>
                <label class="text-light" for="email">Email</label>
                <input class="form-control"  type="text" name="email"  readonly   value="<?= $datos->email?>"/>
    </div>
    <div class="col-sm col-md-6">
                <label class="text-light" for="observacion">Observacion</label>
                <textarea class="form-control"  readonly  name="observacion" ><?= $datos->email?></textarea>

                <label class="text-light" for="usuario">Usuario </label>
                <input class="form-control"  type="text" name="usuario" readonly value="<?= $datos->usuario?>"    />

                <label class="text-light" for="pass">Password</label>
                <input class="form-control"  type="password" name="pass" readonly     />
                
                <label class="text-light" for="tipousuario">Tipo de usuario:</label>
                <select class="form-control"    name="tipousuario"  readonly>
                    <option value="V">Vendedor</option>
                    <option value="A">Administrativo</option> 
                    <option value="S">Supervisor</option> 
                </select>
                <label class="text-light"  for="comision">Comisi&oacute;n %</label>
                 <input  class="form-control" maxlength="2" type="text" name="comision" value="<?= $datos->comision?>"  oninput="numericInput(event)"  />       
    </div>
</div>           
                
  <script>   $('select').val('<?= $datos->tipousuario?>');  </script>

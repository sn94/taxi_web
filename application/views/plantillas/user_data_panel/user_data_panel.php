<div class="row ">
					<div class="col-md-8">
						<dl class="row">
							<dt class="col-md-3">Ubicación:</dt><dd class="col-md-3"></dd>
							<dt class="col-md-3">Dpto:</dt><dd class="col-md-3"><?= $usuario->depart ?></dd>
							<dt class="col-md-3">Ciudad:</dt><dd class="col-md-3"><?= $usuario->ciudad ?></dd>
							<dt class="col-md-3">Barrio:</dt><dd class="col-md-3"><?= $usuario->barrio ?></dd> 
						</dl>
						<div class="row">
							PUBLICIDAD
						</div>
						<div class="row bg-warning">
							ELEGIDO. PROVEEDOR
						</div>
					</div>
					<div class="col-md-4  border border-secondary">
						<div class="row">Visita: 15000</div>
						<div class="row bg-warning"><?= $this->session->userdata("tipo")=="c"?"Soy Cliente":"Soy Proveedor" ?> </div>
						<div class="row">N° 1</div>
						<div class="row bg-warning">Mensajes</div>
					</div>
				</div>
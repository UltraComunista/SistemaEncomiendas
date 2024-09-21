<div class="container-fluid mt-10">
  <div class="card bg-light-info shadow-none position-relative overflow-hidden">

    <div class="card-body px-4 py-3">
      <div class="row align-items-center">
        <div class="col-9">
          <h4 class="fw-semibold mb-8">Sucursales</h4>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="text-muted" href="./index.html">Inicio</a></li>
              <li class="breadcrumb-item" aria-current="page">Sucursales</li>
            </ol>
          </nav>
        </div>
        <div class="col-3">
          <div class="text-center mb-n5">
            <img src="vistas/dist/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4">
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="datatables">
    <div class="card">
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Buscar sucursales..." id="buscar">
              <button class="btn btn-outline-secondary" type="button">
                <i class="ti ti-search"></i>
              </button>
            </div>
          </div>
          <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#agregarsucursal">
              <i class="ti ti-building-store me-1"></i> Agregar Sucursal
            </button>
            <button class="btn btn-secondary me-2">
              <i class="ti ti-filter me-1"></i> Filtrar
            </button>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover tablas" style="width: 100%">
            <thead>
              <tr>
                <th>ID</th>
                <th>Sucursal</th>
                <th>Departamento</th>
                <th>Provincia</th>
                <th>Estado</th>
                <th>Teléfono</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $item = null;
              $valor = null;
              $sucursales = ControladorSucursales::ctrMostrarSucursales($item, $valor);
              $contador = 1;

              $departamentos = [
                1 => 'Santa Cruz',
                2 => 'La Paz',
                3 => 'Cochabamba',
                4 => 'Sucre',
                5 => 'Potosi',
                6 => 'Oruro',
                7 => 'Beni',
                8 => 'Pando',
                9 => 'Tarija'
              ];

              $estado = [
                1 => '<span class="badge bg-light-success text-success fw-semibold fs-2 gap-1 d-inline-flex align-items-center"><i class="ti ti-circle fs-3"></i>En línea</span>',
                2 => '<span class="badge bg-light text-dark fw-semibold fs-2 gap-1 d-inline-flex align-items-center"><i class="ti ti-circle fs-3"></i>Desconectado</span>',
                3 => '<span class="badge bg-light-danger text-danger fw-semibold fs-2 gap-1 d-inline-flex align-items-center"><i class="ti ti-circle fs-3"></i>Fuera de servicio</span>'
              ];

              $provincias = [
                1 => ['Andrés Ibáñez', 'Ichilo', 'Sara', 'Cordillera', 'Germán Busch'],
                2 => ['Murillo', 'Los Andes', 'Ingavi', 'Pacajes', 'Nor Yungas'],
                3 => ['Arani', 'Carrasco', 'Cercado', 'Esteban Arce', 'Germán Jordán'],
                4 => ['Oropeza', 'Azurduy', 'Tomina', 'Zudáñez', 'Yamparáez'],
                5 => ['Tomás Frías', 'Charcas', 'Nor Chichas', 'Sud Chichas', 'Linares'],
                6 => ['Cercado', 'Litoral', 'Ladislao Cabrera', 'Poopó', 'Sajama'],
                7 => ['Cercado', 'Yacuma', 'Ballivián', 'Moxos', 'Vaca Díez'],
                8 => ['Madre de Dios', 'Manuripi', 'Abuná', 'Federico Román', 'Nicolás Suárez'],
                9 => ['Cercado', 'Arce', 'Avilés', 'O’Connor', 'Gran Chaco']
              ];

              foreach ($sucursales as $key => $value) {
                // Convertir los valores de departamento y provincia a nombres
                $nombreDepartamento = isset($departamentos[$value["departamento"]]) ? $departamentos[$value["departamento"]] : 'Desconocido';
                $nombreProvincia = isset($provincias[$value["departamento"]][$value["provincia"] - 1]) ? $provincias[$value["departamento"]][$value["provincia"] - 1] : 'Desconocido';

                echo '<tr>';
                echo '<td><div class="d-flex align-items-center"><h6>' . $contador . '</h6></div></td>';
                echo '<td><div class="ms-3"><div class="user-meta-info"><h6 class="user-name mb-0" data-name="' . $value["nombre"] . '">' . $value["nombre"] . '</h6></div></div></td>';
                echo '<td><span class="usr-location" data-location="' . $nombreDepartamento . '">' . $nombreDepartamento . '</span></td>';
                echo '<td><span class="usr-location" data-location="' . $nombreProvincia . '">' . $nombreProvincia . '</span></td>';
                echo '<td>' . $estado[$value["estado"]] . '</td>';
                echo '<td><p class="mb-0 fw-normal">' . $value["telefono"] . '</p></td>';
                echo '<td>';
                echo '    <div class="dropdown dropstart">';
                echo '        <a href="#" class="text-muted" id="dropdownMenuButton' . $contador . '" data-bs-toggle="dropdown" aria-expanded="false">';
                echo '            <i class="ti ti-dots fs-5"></i>';
                echo '        </a>';
                echo '        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $contador . '">';
                echo '            <li>';
                echo '                <a class="dropdown-item d-flex align-items-center gap-3 btnEditarSucursal" idSucursal="' . $value["id"] . '" href="#" data-bs-toggle="modal" data-bs-target="#editarsucursal"><i class="fs-4 ti ti-edit"></i>Editar</a>';
                echo '            </li>';
                echo '            <li>';
                echo '                <a class="dropdown-item d-flex align-items-center gap-3" href="#"><i class="fs-4 ti ti-trash"></i>Eliminar</a>';
                echo '            </li>';
                echo '        </ul>';
                echo '    </div>';
                echo '</td>';
                echo '</tr>';
                $contador++;
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal -->
<div class="modal fade" id="agregarsucursal" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h5 class="modal-title"> <i class="ti ti-building-store text-blue me-1 fs-5"></i> Nueva Sucursal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="add-contact-box">
          <div class="add-contact-content">
            <form id="addContactModalTitle" method="post" enctype="multipart/form-data">
              <div class="mb-3">
                <input type="text" name="nuevoNombre" class="form-control" placeholder="Ingrese nombre de la sucursal" required />
              </div>
              <div class="mb-3">
                <select class="form-select" name="nuevoDepartamento" id="nuevoDepartamento" required>
                  <option value="">Departamento...</option>
                  <option value="1">Santa Cruz</option>
                  <option value="2">La Paz</option>
                  <option value="3">Cochabamba</option>
                  <option value="4">Sucre</option>
                  <option value="5">Potosi</option>
                  <option value="6">Oruro</option>
                  <option value="7">Beni</option>
                  <option value="8">Pando</option>
                  <option value="9">Tarija</option>
                </select>
              </div>
              <div class="mb-3">
                <select class="form-select" name="nuevaProvincia" id="nuevaProvincia" required>
                  <option value="">Provincia...</option>
                </select>
              </div>
              <div class="mb-3">
                <input type="text" name="nuevaDireccion" class="form-control" placeholder="Ingrese dirección" required />
              </div>
              <div class="mb-3">
                <input type="text" name="nuevoTelefono" class="form-control" placeholder="Ingrese teléfono" required />
              </div>
              <div class="mb-3">
                <select class="form-select" name="nuevoEstado" required>
                  <option value="">Estado...</option>
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
                </select>
              </div>
              <button type="submit" class="btn btn-success">Registrar</button>
              <?php
              $crearSucursal = new ControladorSucursales();
              $crearSucursal->ctrCrearSucursal();
              ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Editar-->
<div class="modal fade" id="editarsucursal" tabindex="-1" role="dialog" aria-labelledby="editContactModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h5 class="modal-title">
          <i class="ti ti-building-store text-blue me-1 fs-5"></i> Editar Sucursal
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="edit-contact-box">
          <div class="edit-contact-content">
            <form id="editContactModalTitle" method="post" enctype="multipart/form-data">
              <div class="mb-3">
                <input type="text" name="editarNombre" id="editarNombre" class="form-control" placeholder="Ingrese sucursal" required />
                <input type="hidden" name="idSucursal" id="idSucursal" required>
              </div>
              <div class="mb-3">
                <select class="form-select" name="editarDepartamento" id="editarDepartamento" required>
                  <option value="">Departamento...</option>
                  <option value="1">Santa Cruz</option>
                  <option value="2">La Paz</option>
                  <option value="3">Cochabamba</option>
                  <option value="4">Sucre</option>
                  <option value="5">Potosi</option>
                  <option value="6">Oruro</option>
                  <option value="7">Beni</option>
                  <option value="8">Pando</option>
                  <option value="9">Tarija</option>
                </select>
              </div>
              <div class="mb-3">
                <select class="form-select" name="editarProvincia" id="editarProvincia" required>
                  <option value="">Provincias...</option>
                </select>
              </div>
              <div class="mb-3">
                <input type="text" name="editarDireccion" id="editarDireccion" class="form-control" placeholder="Dirección" required />
              </div>
              <div class="mb-3">
                <input type="text" name="editarTelefono" id="editarTelefono" class="form-control" placeholder="Teléfono" required />
              </div>
              <div class="mb-3">
                <select class="form-select" name="editarEstado" id="editarEstado" required>
                  <option value="">Estado...</option>
                  <option value="1">En línea</option>
                  <option value="2">Desconectado</option>
                  <option value="3">Fuera de servicio</option>
                </select>
              </div>
              <button type="submit" class="btn btn-success">Guardar cambios</button>
              <?php
              $editarSucursal = new ControladorSucursales();
              $editarSucursal->ctrEditarSucursal();
              ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
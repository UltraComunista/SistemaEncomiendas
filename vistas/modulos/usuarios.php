<div class="container-fluid mt-10">
  <div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
      <div class="row align-items-center">
        <div class="col-9">
          <h4 class="fw-semibold mb-8">Usuarios</h4>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="text-muted " href="./index.html">Inicio</a></li>
              <li class="breadcrumb-item" aria-current="page">Usuarios</li>
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
              <input type="text" class="form-control" placeholder="Buscar usuarios..." id="buscar">
              <button class="btn btn-outline-secondary" type="button">
                <i class="ti ti-search"></i>
              </button>
            </div>
          </div>
          <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#agregarusuario">
              <i class="ti ti-plus me-1"></i> Agregar Usuario
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
                <th>Foto</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Perfil</th>
                <th>Estado</th>
                <th>Última vez</th>
                <th>Sucursal</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $item = null;
              $valor = null;
              $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
              $contador = 1;

              $perfiles = [
                1 => 'Administrador',
                2 => 'Recepcion',
                3 => 'Delivery',
                4 => 'Ayudante',
                5 => 'Empresa'
              ];

              $estados = [
                0 => '<span class="badge bg-light text-dark fw-semibold fs-2 gap-1 d-inline-flex align-items-center"><i class="ti ti-clock-hour-4 fs-3"></i>Desconectado</span>',
                1 => '<span class="badge bg-light-success text-success fw-semibold fs-2 gap-1 d-inline-flex align-items-center"><i class="ti ti-circle fs-3"></i>En linea</span>',
                2 => '<span class="badge bg-light-danger text-danger fw-semibold fs-2 gap-1 d-inline-flex align-items-center"><i class="ti ti-circle fs-3"></i>Fuera de servicio</span>'
              ];

              foreach ($usuarios as $key => $value) {
                $foto = !empty($value["foto"]) ? $value["foto"] : './img/predeterminado/images.png';
                $estado = $estados[$value["estado"]];
                $perfil = isset($perfiles[$value["perfil"]]) ? $perfiles[$value["perfil"]] : 'Desconocido';
                $sucursal = isset($value["nombreSucursal"]) ? $value["nombreSucursal"] : 'Sin Sucursal';  // Obtener la sucursal

                echo '<tr>';
                echo '<td><div class="d-flex align-items-center"><h6>' . $contador . '</h6></div></td>';
                echo '<td>';
                echo '<div class="d-flex align-items-center">';
                echo '<img src="' . $foto . '" class="rounded-circle" width="40" height="40" />';
                echo '</div>';
                echo '</td>';
                echo '<td>';
                echo '<div class="d-flex align-items-center">';
                echo '<div class="ms-3">';
                echo '<h6 class="fs-4 fw-semibold mb-0">' . $value["nombre"] . ' ' . $value["apellido"] . '</h6>';
                echo '<span class="fw-normal">@' . $value["usuario"] . '</span>';
                echo '</div>';
                echo '</div>';
                echo '</td>';
                echo '<td><p class="mb-0 fw-normal">' . $value["usuario"] . '</p></td>';
                echo '<td><p class="mb-0 fw-normal">' . $perfil . '</p></td>';
                echo '<td>' . $estado . '</td>';
                echo '<td><p class="mb-0 fw-normal">' . $value["ultimoLogin"] . '</p></td>';
                echo '<td><p class="mb-0 fw-normal">' . $sucursal . '</p></td>';  // Mostrar la sucursal

                echo '<td>';
                echo '<div class="dropdown dropstart">';
                echo '<a href="#" class="text-muted" id="dropdownMenuButton' . $contador . '" data-bs-toggle="dropdown" aria-expanded="false">';
                echo '<i class="ti ti-dots fs-5"></i>';
                echo '</a>';
                echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $contador . '">';
                echo '<li>';
                echo '<a class="dropdown-item d-flex align-items-center gap-3 btnEditarUsuario" idUsuario="' . $value["id"] . '" href="#" data-bs-toggle="modal" data-bs-target="#editarusuario"><i class="fs-4 ti ti-pencil"></i>Editar</a>';
                echo '</li>';
                echo '</ul>';
                echo '</div>';
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
    <!-- Modal -->
    <div class="modal fade" id="agregarusuario" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header d-flex align-items-center">
            <h5 class="modal-title"> <i class="ti ti-user text-blue me-1 fs-5"></i> Nuevo usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="add-contact-box">
              <div class="add-contact-content">
                <form id="addContactModalTitle" method="post" enctype="multipart/form-data">
                  <div class="mb-3">
                    <input type="text" name="nuevoNombre" class="form-control" placeholder="Ingrese nombre" required />
                  </div>
                  <div class="mb-3" id="apellidoContainer">
                    <input type="text" name="nuevoApellido" class="form-control" placeholder="Ingrese apellido" required />
                  </div>

                  <div class="mb-3">
                    <input type="text" name="nuevoCedula" class="form-control" placeholder="Ingrese cédula de identidad" required />
                  </div>
                  <div class="mb-3">
                    <input type="text" name="nuevoUsuario" class="form-control" placeholder="Usuario" required />
                  </div>
                  <div class="mb-3">
                    <input type="password" name="nuevoPassword" class="form-control" placeholder="Contraseña" required />
                  </div>
                  <div class="mb-3">
                    <select class="form-select" name="nuevoPerfil" required>
                      <option value="">Perfil...</option>
                      <option value="1">Administrador</option>
                      <option value="2">Recepción</option>
                      <option value="3">Delivery</option>
                      <option value="4">Ayudante</option>
                      <option value="5">Empresa</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <select class="form-select" name="nuevaSucursal" required>
                      <option value="">Seleccione una sucursal...</option>
                      <?php
                      $sucursales = ControladorSucursales::ctrMostrarSucursales(null, null);
                      foreach ($sucursales as $sucursal) {
                        echo '<option value="' . $sucursal["id"] . '">' . $sucursal["nombre"] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <!-- Campo para la dirección -->
                  <div class="mb-3">
                    <input type="text" name="nuevaDireccion" class="form-control" placeholder="Ingrese dirección" />
                  </div>
                  <!-- Campo para el teléfono -->
                  <div class="mb-3">
                    <input type="text" name="nuevoTelefono" class="form-control" placeholder="Ingrese teléfono" />
                  </div>
                  <div class="mb-3">
                    <input type="file" name="nuevaFoto" class="form-control">
                  </div>
                  <button type="submit" class="btn btn-success">Registrar</button>
                  <?php
                  $crearUsuario = new ControladorUsuarios();
                  $crearUsuario->ctrCrearUsuario();
                  ?>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Editar-->
    <div class="modal fade" id="editarusuario" tabindex="-1" role="dialog" aria-labelledby="editContactModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header d-flex align-items-center">
            <h5 class="modal-title"> <i class="ti ti-user text-blue me-1 fs-5"></i> Editar usuario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="edit-contact-box">
              <div class="edit-contact-content">
                <form method="post" enctype="multipart/form-data">
                  <input type="hidden" name="idUsuario" id="idUsuario" />
                  <input type="hidden" name="passwordActual" id="passwordActual" />
                  <input type="hidden" name="fotoActual" id="fotoActual">
                  <div class="mb-3">
                    <input type="text" name="editarNombre" id="editarNombre" class="form-control" placeholder="Ingrese nombre" required />
                  </div>
                  <div class="mb-3" id="editarApellidoContainer">
                    <input type="text" name="editarApellido" id="editarApellido" class="form-control" placeholder="Ingrese apellido" required />
                  </div>
                  <div class="mb-3">
                    <input type="text" name="editarCedula" id="editarCedula" class="form-control" placeholder="Ingrese cedula" required />
                  </div>
                  <div class="mb-3">
                    <input type="text" name="editarDireccion" id="editarDireccion" class="form-control" placeholder="Ingrese dirección" />
                  </div>
                  <div class="mb-3">
                    <input type="text" name="editarTelefono" id="editarTelefono" class="form-control" placeholder="Ingrese teléfono" />
                  </div>
                  <div class="mb-3">
                    <input type="text" class="form-control" name="editarUsuario" id="editarUsuario" placeholder="Usuario" required />
                  </div>
                  <div class="mb-3">
                    <select class="form-select" name="editarPerfil" id="editarPerfil" required>
                      <option value="1">Administrador</option>
                      <option value="2">Recepcion</option>
                      <option value="3">Delivery</option>
                      <option value="4">Ayudante</option>
                      <option value="5">Empresa</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="editarToken">Token de Empresa (No Editable)</label>
                    <input type="text" class="form-control" name="editarToken" id="editarToken" readonly />
                  </div>
                  <div class="mb-3">
                    <img src="" id="previsualizar" class="img-thumbnail" width="100" height="100">
                  </div>
                  <div class="mb-3">
                    <input type="file" name="editarFoto" id="editarFoto" class="form-control">
                  </div>
                  <button type="button" id="resetUsuarioPassword" class="btn btn-warning">Resetear Usuario y Contraseña</button>
                  <button type="submit" class="btn btn-success">Guardar cambios</button>
                  <?php
                  $editarUsuarios = new ControladorUsuarios();
                  $editarUsuarios->ctrEditarUsuario();
                  ?>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
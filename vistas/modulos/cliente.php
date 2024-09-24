<div class="container-fluid mt-10">
  <div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
      <div class="row align-items-center">
        <div class="col-9">
          <h4 class="fw-semibold mb-8">Clientes</h4>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="text-muted" href="./index.html">Inicio</a></li>
              <li class="breadcrumb-item" aria-current="page">Clientes</li>
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
              <input type="text" class="form-control" placeholder="Buscar clientes..." id="buscar">
              <button class="btn btn-outline-secondary" type="button">
                <i class="ti ti-search"></i>
              </button>
            </div>
          </div>
          <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#agregarcliente">
              <i class="ti ti-plus me-1"></i> Agregar Cliente
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
                <th>Cédula de Identidad</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $item = null;
              $valor = null;
              $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
              $contador = 1;

              foreach ($clientes as $key => $value) {
                echo '<tr>';
                echo '<td><div class="d-flex align-items-center"><h6>' . $contador . '</h6></div></td>';
                echo '<td><p class="mb-0 fw-normal">' . $value["cedula"] . '</p></td>';
                echo '<td><p class="mb-0 fw-normal">' . $value["nombre"] . '</p></td>';
                echo '<td><p class="mb-0 fw-normal">' . $value["direccion"] . '</p></td>';
                echo '<td><p class="mb-0 fw-normal">' . $value["telefono"] . '</p></td>';
                echo '<td>';
                echo '<div class="dropdown dropstart">';
                echo '<a href="#" class="text-muted" id="dropdownMenuButton' . $contador . '" data-bs-toggle="dropdown" aria-expanded="false">';
                echo '<i class="ti ti-dots fs-5"></i>';
                echo '</a>';
                echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $contador . '">';
                echo '<li>';
                echo '<a class="dropdown-item d-flex align-items-center gap-3 btnEditarCliente" idCliente="' . $value["id"] . '" href="#" data-bs-toggle="modal" data-bs-target="#editarcliente"><i class="fs-4 ti ti-pencil"></i>Editar</a>';
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
  </section>
</div>

<!-- Modal Agregar Cliente -->
<div class="modal fade" id="agregarcliente" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center bg-primary text-white">
        <h5 class="modal-title text-white"> <i class="ti ti-user text-white me-1 fs-5"></i> Nuevo Cliente</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="add-contact-box">
          <div class="add-contact-content">
            <form method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="nuevoCedula" class="form-label"><i class="ti ti-id me-2"></i>Cédula de Identidad</label>
                  <input type="text" name="nuevoCedula" class="form-control" placeholder="Ingrese cédula de identidad" required />
                </div>
                <div class="col-md-6 mb-3">
                  <label for="nuevoNombre" class="form-label"><i class="ti ti-user me-2"></i>Nombre Completo</label>
                  <input type="text" name="nuevoNombre" class="form-control" placeholder="Ingrese nombre completo" required />
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="nuevoDireccion" class="form-label"><i class="ti ti-home me-2"></i>Dirección</label>
                  <input type="text" name="nuevoDireccion" class="form-control" placeholder="Ingrese dirección" required />
                </div>
                <div class="col-md-6 mb-3">
                  <label for="nuevoTelefono" class="form-label"><i class="ti ti-phone me-2"></i>Teléfono</label>
                  <input type="text" name="nuevoTelefono" class="form-control" placeholder="Ingrese teléfono" required />
                </div>
              </div>
              <button type="submit" class="btn btn-primary w-100">Agregar Cliente</button>
              <?php
              $crearCliente = new ControladorClientes();
              $crearCliente->ctrCrearCliente();
              ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal Editar Cliente -->
<div class="modal fade" id="editarcliente" tabindex="-1" role="dialog" aria-labelledby="editContactModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center bg-primary text-white">
        <h5 class="modal-title text-white"> <i class="ti ti-user text-white me-1 fs-5"></i> Editar Cliente</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <div class="edit-contact-box">
          <div class="edit-contact-content">
            <form method="post" enctype="multipart/form-data">
              <input type="hidden" name="idCliente" id="idCliente" required>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="editarCedula" class="form-label"><i class="ti ti-id me-2"></i>Cédula de Identidad</label>
                  <input type="text" name="editarCedula" id="editarCedula" class="form-control" placeholder="Ingrese cédula de identidad" required />
                </div>
                <div class="col-md-6 mb-3">
                  <label for="editarNombre" class="form-label"><i class="ti ti-user me-2"></i>Nombre Completo</label>
                  <input type="text" name="editarNombre" id="editarNombre" class="form-control" placeholder="Ingrese nombre completo" required />
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="editarDireccion" class="form-label"><i class="ti ti-home me-2"></i>Dirección</label>
                  <input type="text" name="editarDireccion" id="editarDireccion" class="form-control" placeholder="Ingrese dirección" required />
                </div>
                <div class="col-md-6 mb-3">
                  <label for="editarTelefono" class="form-label"><i class="ti ti-phone me-2"></i>Teléfono</label>
                  <input type="text" name="editarTelefono" id="editarTelefono" class="form-control" placeholder="Ingrese teléfono" required />
                </div>
              </div>
              <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
              <?php
              $editarCliente = new ControladorClientes();
              $editarCliente->ctrEditarCliente();
              ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
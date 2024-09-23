<div class="container-fluid mt-10">
  <div class="card bg-light-info shadow-none position-relative overflow-hidden">
    <div class="card-body px-4 py-3">
      <div class="row align-items-center">
        <div class="col-9">
          <h4 class="fw-semibold mb-8">Categorías</h4>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="text-muted" href="./index.html">Inicio</a></li>
              <li class="breadcrumb-item" aria-current="page">Categorías</li>
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
              <input type="text" class="form-control" placeholder="Buscar categorías..." id="buscar">
              <button class="btn btn-outline-secondary" type="button">
                <i class="ti ti-search"></i>
              </button>
            </div>
          </div>
          <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#agregarcategoria">
              <i class="ti ti-plus me-1"></i> Agregar Categoría
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
                <th>Nombre</th>
                <th>Precio</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $item = null;
              $valor = null;
              $categorias = ControladorCategoria::ctrMostrarCategorias($item, $valor);
              $contador = 1;

              foreach ($categorias as $key => $value) {
                echo '<tr>';
                echo '<td><div class="d-flex align-items-center"><h6>' . $contador . '</h6></div></td>';
                echo '<td><p class="mb-0 fw-normal">' . $value["nombre"] . '</p></td>';
                echo '<td><p class="mb-0 fw-normal">' . $value["precio"] . '</p></td>';
                echo '<td>';
                echo '<div class="dropdown dropstart">';
                echo '<a href="#" class="text-muted" id="dropdownMenuButton' . $contador . '" data-bs-toggle="dropdown" aria-expanded="false">';
                echo '<i class="ti ti-dots fs-5"></i>';
                echo '</a>';
                echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $contador . '">';
                echo '<li>';
                echo '<a class="dropdown-item d-flex align-items-center gap-3 btnEditarCategoria" idCategoria="' . $value["id"] . '" href="#" data-bs-toggle="modal" data-bs-target="#editarcategoria"><i class="fs-4 ti ti-pencil"></i>Editar</a>';
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

<!-- Modal -->
<div class="modal fade" id="agregarcategoria" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h5 class="modal-title"> <i class="ti ti-building-store text-blue me-1 fs-5"></i> Nueva Categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="add-contact-box">
          <div class="add-contact-content">
            <form method="post" enctype="multipart/form-data">
              <div class="mb-3">
                <input type="text" name="nuevoNombre" class="form-control" placeholder="Ingrese nombre de la categoría" required />
              </div>
              <div class="mb-3">
                <input type="text" name="nuevoPrecio" class="form-control" placeholder="Ingrese el precio" required />
              </div>
              <button type="submit" class="btn btn-success">Agregar</button>
              <?php
              $crearCategoria = new ControladorCategoria();
              $crearCategoria->ctrCrearCategoria();
              ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Modal Editar Categoria -->
<div class="modal fade" id="editarcategoria" tabindex="-1" role="dialog" aria-labelledby="editarcategoria" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h5 class="modal-title"> <i class="ti ti-building-store text-blue me-1 fs-5"></i> Editar Categoría</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="edit-contact-box">
          <div class="edit-contact-content">
            <form method="post" enctype="multipart/form-data">
              <div class="mb-3">
                <input type="hidden" name="idCategoria" id="idCategoria" required>
                <input type="text" name="editarNombre" id="editarNombre" class="form-control" placeholder="Ingrese nombre de la categoría" required />
              </div>
              <div class="mb-3">
                <input type="text" name="editarPrecio" id="editarPrecio" class="form-control" placeholder="Ingrese el precio" required />
              </div>
              <button type="submit" class="btn btn-success">Guardar cambios</button>
              <?php
              $editarCategoria = new ControladorCategoria();
              $editarCategoria->ctrEditarCategoria();
              ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
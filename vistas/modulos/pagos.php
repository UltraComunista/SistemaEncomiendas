<div class="container-fluid mt-10">
  <div class="card bg-light-info shadow-none position-relative overflow-hidden">

    <div class="card-body px-4 py-3">
      <div class="row align-items-center">
        <div class="col-9">
          <h4 class="fw-semibold mb-8">Historial de Pagos</h4>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a class="text-muted" href="./index.html">Inicio</a></li>
              <li class="breadcrumb-item" aria-current="page">Pagos</li>
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
              <input type="text" class="form-control" placeholder="Buscar Pagos..." id="buscar">
              <button class="btn btn-outline-secondary" type="button">
                <i class="ti ti-search"></i>
              </button>
            </div>
          </div>
          <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <button class="btn btn-primary me-2">
              <i class="ti ti-filter me-1"></i> Filtrar
            </button>
            <button class="btn btn-secondary me-2">
              <i class="ti ti-download me-1"></i> Exportar
            </button>
            <button class="btn btn-secondary">
              <i class="ti ti-printer me-1"></i> Imprimir
            </button>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover tablas" style="width: 100%">
            <thead>
              <tr>
                <th>ID</th>
                <th>Transacción ID</th>
                <th>Método de Pago</th>
                <th>Estado de Pago</th>
                <th>Monto</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $Pagoss = ControladorPagos::ctrMostrarPagos(null, null);

              $contador = 1;
              foreach ($Pagoss as $key => $value) {
                // Método de pago
                $metodoPago = '';
                switch ($value["metodoPago"]) {
                  case 0:
                    $metodoPago = 'Efectivo';
                    break;
                  case 1:
                    $metodoPago = 'QR';
                    break;
                  default:
                    $metodoPago = 'Otro';
                    break;
                }

                // Estado de Pago
                $estadoPago = $value["estadoPago"] == 1 ?
                  '<span class="mb-1 badge rounded-pill text-bg-success">Pagado</span>' :
                  '<span class="mb-1 badge rounded-pill text-bg-danger">Por pagar</span>';

                echo '<tr>';
                echo '<td>' . $contador . '</td>';
                echo '<td>' . $value["idTransaccion"] . '</td>';
                echo '<td>' . $metodoPago . '</td>';
                echo '<td>' . $estadoPago . '</td>';
                echo '<td>' . $value["monto"] . '</td>';
                echo '<td class="text-center">
      <button class="btn btn-info btn-sm">Info</button>
    </td>';
                $contador++;
                echo '</tr>';
              }
              ?>
            </tbody>

          </table>
        </div>
      </div>
    </div>
  </section>
</div>
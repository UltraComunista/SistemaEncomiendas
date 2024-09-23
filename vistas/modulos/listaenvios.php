<div class="container-fluid mw-100">
  <h3 class="text-center"><strong>Registrar envios</strong></h3>
  <h5 class="text-center">Encomiendas</h5>
  <div class="col-12">
    <section class="datatables">
      <div class="row">
        <div class="col-4">
          <div class="card">
            <div class="cad-body wizard-content">
              <form class="validation-wizard wizard-circle mt-5" id="paqueteForm" method="post">
                <!-- Remitente -->
                <h6>Remitente</h6>
                <section>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="cedula_enviador">Cédula :</label>
                        <input type="text" class="form-control" id="cedula_enviador" name="cedula_enviador" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="nombre_enviador">Nombre :</label>
                        <input type="text" class="form-control" id="nombre_enviador" name="nombre_enviador" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="direccion_enviador">Dirección :</label>
                        <input type="text" class="form-control" id="direccion_enviador" name="direccion_enviador" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="telefono_enviador">Teléfono :</label>
                        <input type="text" class="form-control" id="telefono_enviador" name="telefono_enviador" />
                      </div>
                    </div>
                  </div>
                </section>
                <!-- Destinatario -->
                <h6>Destinatario</h6>
                <section>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="cedula_remitente">Cédula :</label>
                        <input type="text" class="form-control" id="cedula_remitente" name="cedula_remitente" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="nombre_remitente">Nombre :</label>
                        <input type="text" class="form-control" id="nombre_remitente" name="nombre_remitente" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="direccion_remitente">Dirección :</label>
                        <input type="text" class="form-control" id="direccion_remitente" name="direccion_remitente" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="telefono_remitente">Teléfono :</label>
                        <input type="text" class="form-control" id="telefono_remitente" name="telefono_remitente" />
                      </div>
                    </div>
                  </div>
                </section>



                <!-- Sucursal -->
                <?php
                $idSucursal = $_SESSION["idSucursal"]; // Obtener la idSucursal desde la sesión
                $sucursal = ControladorSucursales::ctrMostrarSucursales("id", $idSucursal);

                // Definir arrays de departamentos y provincias
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

                // Rellenar los campos con la información obtenida
                $departamento = $departamentos[$sucursal["departamento"]];
                $provincia = $provincias[$sucursal["departamento"]][$sucursal["provincia"] - 1]; // Restar 1 porque los índices de las provincias son 0-based
                $nombreSucursal = $sucursal["nombre"];
                ?>

                <h6>Sucursal</h6>
                <section>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="mb-3">
                        <label for="departamentoPartida">Departamento salida:</label>
                        <input type="text" class="form-control" id="departamentoPartida" name="departamentoPartida" value="<?php echo $departamento; ?>" readonly>

                      </div>
                      <div class="mb-3">
                        <label for="departamentoLlegada">Departamento arribo:</label>
                        <select class="form-select" id="departamentoLlegada" name="departamentoLlegada">
                          <option value="">Departamento...</option>
                          <option value="1">Santa Cruz</option>
                          <option value="2">La Paz</option>
                          <option value="3">Cochabamba</option>
                          <option value="4">Sucre</option>
                          <option value="5">Potosí</option>
                          <option value="6">Oruro</option>
                          <option value="7">Beni</option>
                          <option value="8">Pando</option>
                          <option value="9">Tarija</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="mb-3">
                        <label for="provinciaPartida">Provincia de Partida:</label>
                        <input type="text" class="form-control" id="provinciaPartida" name="provinciaPartida" value="<?php echo $provincia; ?>" readonly>
                      </div>
                      <div class="mb-3">
                        <label for="provinciaLlegada">Provincia de Llegada:</label>
                        <select class="form-select" id="provinciaLlegada" name="provinciaLlegada">
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="mb-3">
                        <label for="sucursalPartida">Sucursal de Partida:</label>
                        <input type="hidden" class="form-control" id="sucursalPartida" name="sucursalPartida" value="<?php echo $sucursal["id"]; ?>" readonly>
                        <input type="text" class="form-control" id="sucursalPartid" name="sucursalPartid" value="<?php echo $nombreSucursal; ?>" readonly>

                      </div>
                      <div class="mb-3">
                        <label for="sucursalLlegada">Sucursal de Llegada:</label>

                        <select class="form-select" id="sucursalLlegada" name="sucursalLlegada">
                          <!-- Sucursales se llenarán dinámicamente -->
                        </select>
                      </div>
                    </div>
                    <!-- Tipo de Envío -->
                    <div class="mb-3">
                      <label for="tipoEnvio">Tipo de Envío:</label>
                      <select class="form-select" id="tipoEnvio" name="tipoEnvio">
                        <option value="0">Normal</option>
                        <option value="1">Domiciliario</option>
                      </select>
                    </div>

                    <div class="mb-3" id="direccionContainer" style="display: none;">
                      <label for="direccionDomiciliario">Dirección:</label>
                      <input type="text" class="form-control" id="direccionDomiciliario" name="direccionDomiciliario" />
                    </div>

                  </div>
                </section>
                <!-- Detalles del Paquete -->
                <h6>Detalles</h6>
                <section>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="cantidad">Cantidad:</label>
                        <input type="text" class="form-control" id="cantidad" name="cantidad" />
                      </div>
                      <div class="mb-3">
                        <label for="pesoPaquete">Peso (KG):</label>
                        <input type="number" class="form-control" id="pesoPaquete" name="pesoPaquete" />
                      </div>
                      <div class="mb-3">
                        <label for="tipoPaquete">Tipo:</label>
                        <select class="form-select" id="tipoPaquete" name="tipoPaquete" required>
                          <option value="">Selecciona...</option>
                          <?php
                          // Aquí generamos las opciones dinámicamente desde la base de datos
                          $categorias = ControladorCategoria::ctrMostrarCategorias(null, null);
                          foreach ($categorias as $categoria) {
                            echo '<option value="' . $categoria["id"] . '">' . $categoria["nombre"] . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="precio">Precio:</label>
                        <input type="text" class="form-control" id="precio" name="precio" readonly />
                      </div>
                      <div class="mb-3">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" />
                      </div>
                    </div>
                  </div>
                </section>

               



              </form>

              <!-- sample modal content -->
              <div class="modal fade" id="bs-example-modal-xlg" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                  <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                      <h4 class="modal-title" id="myLargeModalLabel">Detalles del Envío</h4>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-body-content">
                      <input type="hidden" id="idPaquete" name="idPaquete" value="">
                      <!-- Aquí se cargarán los datos del envío -->

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" id="update-status-btn">Actualizar Estado</button>
                      <button type="button" class="btn btn-light-danger text-danger font-medium waves-effect text-start" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            </div>
          </div>
        </div>
        <div class="col-8">
          <section class="datatables">
            <div class="card">
              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-md-6">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Buscar envíos..." id="buscarEnvios">
                      <button class="btn btn-outline-secondary" type="button">
                        <i class="ti ti-search"></i>
                      </button>
                    </div>
                  </div>
                  <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <button class="btn btn-secondary me-2">
                      <i class="ti ti-filter me-1"></i> Filtrar
                    </button>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover tablas" style="width: 100%">
                    <thead>
                      <tr>
                        <th class="text-center">Número de Rastreo</th>
                        <th class="text-center">Destinatario</th>
                        <th class="text-center">Sucursal Salida</th>
                        <th class="text-center">Estado Envío</th>
                        <th class="text-center">Estado Pago</th>
                        <th class="text-center">Precio</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Detalle</th>
                        <th class="text-center">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $item = null;
                      $valor = null;
                      $paquetes = ControladorPaquetes::ctrMostrarPaquetes($item, $valor);

                      foreach ($paquetes as $key => $value) {
                        // Estado de Pago
                        $estadoPago = $value["estadoPago"] == 1 ? '<span class="mb-1 badge rounded-pill text-bg-success">Pagado</span>' : '<span class="mb-1 badge rounded-pill text-bg-danger">Debe</span>';

                        // Estado del Paquete
                        switch ($value["estadoPaquete"]) {
                          case 0:
                            $estadoPaquete = '<span class="mb-1 badge rounded-pill text-bg-warning">Recepcionado</span>';
                            break;
                          case 1:
                            $estadoPaquete = '<span class="mb-1 badge rounded-pill text-bg-primary">En camino</span>';
                            break;
                          case 2:
                            $estadoPaquete = '<span class="mb-1 badge rounded-pill text-bg-info">Recepcionado en destino</span>';
                            break;
                          case 3:
                            $estadoPaquete = '<span class="mb-1 badge rounded-pill text-bg-success">Entregado</span>';
                            break;
                          default:
                            $estadoPaquete = '<span class="mb-1 badge rounded-pill text-bg-secondary">Desconocido</span>';
                            break;
                        }

                        // Tipo de Paquete
                        $tipoPaquete = !empty($value["tipo_paquete"]) ? $value["tipo_paquete"] : 'Desconocido';

                        echo '<tr>';
                        echo '<td class="text-center">' . $value["nro_registro"] . '</td>';
                        echo '<td class="text-center">' . $value["nombre_destinatario"] . '</td>';
                        echo '<td class="text-center">' . (isset($value["nombre_sucursal_salida"]) ? $value["nombre_sucursal_salida"] : 'Desconocido') . '</td>';
                        echo '<td class="text-center">' . $estadoPaquete . '</td>';
                        echo '<td class="text-center">' . $estadoPago . '</td>';
                        echo '<td class="text-center">' . number_format($value["precio"], 2) . '</td>';
                        echo '<td class="text-center">' . $tipoPaquete . '</td>';
                        echo '<td class="text-center">' . $value["descripcion"] . '</td>';
                        echo '<td class="text-center">
                <div class="dropdown dropstart">
                    <a href="#" class="text-muted" id="dropdownMenuButton' . $value["id"] . '" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ti ti-dots fs-5"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $value["id"] . '">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-3 btnEditarPaquete" idPaquete="' . $value["id"] . '" href="#" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xlg">
                                <i class="fs-4 ti ti-pencil"></i>Editar
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-3" href="reportes/guia_envio.php?idPaquete=' . $value["id"] . '" target="_blank">
                                <i class="fs-4 ti ti-printer"></i>Imprimir
                            </a>
                        </li>
                    </ul>
                </div>
            </td>';
                        echo '</tr>';
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </section>
          <!-- ---------------------
                                    end Scroll - Horizontal
                                ---------------- -->
        </div>
      </div>
    </section>
  </div>

</div>
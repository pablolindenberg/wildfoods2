<template>
  <main class="main">
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i>
          Pedidos
        </div>
        <div class="card-body">
          <div class="form-group row">
            <div class="col-md-6">
              <div class="input-group">
                <select class="form-control col-md-3" v-model="criterio">
                  <option value="idusuario">ID Usuario</option>
                  <option value="estado">Estado</option>
                  <option value="updated_at">Fecha actualización</option>
                </select>
                <input
                  type="text"
                  v-model="buscar"
                  @keyup.enter="listarPedido(1,buscar,criterio)"
                  class="form-control"
                  placeholder="Buscar"
                />
                <button
                  type="submit"
                  @click="listarPedido(1,buscar,criterio)"
                  class="btn btn-primary"
                >
                  <i class="fa fa-search"></i> Buscar
                </button>
              </div>
            </div>
          </div>
          <!--
        <a @click="descargarPedidos(buscar)">Descargar
          </a>
              -->
           
          <a href="/pedido/descargar">Exportar a Excel
          </a>
          
          <table
            class="table table-bordered table-striped table-sm"
           
          >
            <thead>
              <tr>
                <th>Acciones</th>
                <th>Bodega</th>
                <th>Factura</th>
                <th>ID Pedido</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Tracking ID</th>
                <th>Fecha ingreso</th>
                <th>Actualizado</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody >
              <tr v-for="pedido in arrayPedido" :key="pedido.id">
                <td>
                  <a href="#">
                    <i @click="abrirModal('ver',pedido.id,pedido)" class="material-icons">zoom_in</i>
                  </a>
                   <a href="#">
                    <i @click="abrirModal('actualizar',pedido.id,pedido)" class="material-icons">edit</i>
                  </a>
                </td>
                <td >
                  <a href="#">
                    <i
                      v-if="pedido.bodega==1"
                      @click="desactivarBodega(pedido.id)"
                      class="material-icons"
                      style="color:#009A00;"
                    >check_circle</i>
                  </a>
                  <a href="#">
                    <i
                      v-if="pedido.bodega==0"
                      @click="activarBodega(pedido.id)"
                      class="material-icons"
                      style="color:red;"
                    >block</i>
                  </a>
                </td>
                <td>
                  <a href="#">
                    <i 
                    @click="cargarFactura(pedido.id)"
                    class="material-icons">attachment</i>
                  </a>

                   <a href="#">
                      <span v-if="pedido.factura==1" class="badge badge-success" @click="verFactura(pedido.id)">Abrir</span>
                    </a>

                </td>
                <td v-text="pedido.id"></td>
                <td v-text="pedido.nombre_usuario"></td>
                <td v-text="pedido.total"></td>
                <td v-text="pedido.tracking"></td>
                <td v-text="pedido.created_at"></td>
                <td v-text="pedido.updated_at"></td>
                <td>
                  <div v-if="pedido.estado==0">
                    <a href="#">
                      <span class="badge badge-danger" @click="activar(pedido.id)">Descartado</span>
                    </a>
                  </div>
                  <div v-if="pedido.estado==1">
                    <a href="#">
                      <span class="badge badge-warning" @click="despachado(pedido.id,pedido.id_usuario)">Pendiente</span>
                    </a>
                  </div>
                  <div v-if="pedido.estado==2">
                    <a href="#">
                      <span class="badge badge-success" @click="desactivar(pedido.id)">Despachado</span>
                    </a>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <nav>
            <ul class="pagination">
              <li class="page-item" v-if="pagination.current_page > 1">
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)"
                >Ant</a>
              </li>
              <li
                class="page-item"
                v-for="page in pagesNumber"
                :key="page"
                :class="[page == isActived ? 'active' : '']"
              >
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="cambiarPagina(page,buscar,criterio)"
                  v-text="page"
                ></a>
              </li>
              <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                <a
                  class="page-link"
                  href="#"
                  @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)"
                >Sig</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div
      class="modal fade"
      tabindex="-1"
      :class="{'mostrar' : modal}"
      role="dialog"
      aria-labelledby="myModalLabel"
      style="display: none;"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-primary modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" v-text="tituloModal"></h4>
            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div v-if="tipoAccion>2">
               <form action method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group row">
                  <label class="col-md-3 form-control-label" for="text-input">ID Usuario</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" v-model="idusuario">                                       
                  </div>
                </div>
                 <div class="form-group row">
                  <label class="col-md-3 form-control-label" for="text-input">Tracking ID</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" v-model="tracking">                                       
                  </div>
                </div>
                 
               </form>
               
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
               
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="actualizarPedido()"
                >Actualizar</button>
              </div>

            </div>    

            <div v-if="tipoAccion<=2">
              <div class="row">
                <div class="col-md-2">
                  <h4>SKU</h4>
                </div>
                <div class="col-md-2 text-right">
                  <h4>Nombre</h4>
                </div>
                <div class="col-md-2 text-right">
                  <h4>Precio unitario</h4>
                </div>
                <div class="col-md-2 text-right">
                  <h4>Cantidad</h4>
                </div>
                <div class="col-md-2 text-right">
                  <h4>Total</h4>
                </div>
              </div>
              <div v-for="item in cart" :key="item.id" :value="item.id">
                <div class="row">
                  <div class="col-md-2">
                    <h6 v-text="item.SKU"></h6>
                  </div>
                  <div class="col-md-2">
                    <h6 v-text="item.nombre"></h6>
                  </div>
                  <div class="col-md-2">
                    <h6 v-text="'$'+item.precio_unitario"></h6>
                  </div>
                  <div class="col-md-2 text-right">
                    <h6 v-text="item.cantidad"></h6>
                  </div>
                  <div class="col-md-2 text-right">
                    <h6 v-text="'$'+item.total"></h6>
                  </div>
                </div>
              </div>

              <div class="modal-footer">
                <h6 v-text="'Total: $'+total_carrito"></h6>

                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Fin del modal-->
  </main>
</template>

<script>
export default {
  data() {
    return {
      arrayPedido: [],
      total_carrito: 0,
      cart: [],
      modal: 0,
      idusuario:"",
      tracking:"",
      tituloModal: "",
      tipoAccion: 0,
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      offset: 3,
      criterio: "nombre",
      buscar: ""
    };
  },

  computed: {
    isActived: function() {
      return this.pagination.current_page;
    },
    //Calcula los elementos de la paginación
    pagesNumber: function() {
      if (!this.pagination.to) {
        return [];
      }

      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }

      var to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    }
  },
  methods: {
    listarPedido(page, buscar, criterio) {
      let me = this;
      var url =
        "/pedido?page=" + page + "&buscar=" + buscar + "&criterio=" + criterio;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayPedido = respuesta.pedidos.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    cambiarPagina(page, buscar, criterio) {
      let me = this;
      //Actualiza la página actual
      me.pagination.current_page = page;
      //Envia la petición para visualizar la data de esa página
      me.listarPedido(page, buscar, criterio);
    },
    cargarFactura(id) {
      let me = this;
      axios
        .put("/pedido/cargarFactura",{
        idpedido: id
        })      
        .then(function(response) {
          me.listarPedido(1, "", "idusuario");
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    descargarPedidos(id){
      let me = this;

       axios
            .get("/pedido/descargar",{
              idusuario: id
            })          
        .catch(function(error) {
          console.log(error);
        });  
    },
    verDetallePedido(page, buscar, criterio) {
      let me = this;
      var url =
        "/detalle_pedido?page=" +
        page +
        "&buscar=" +
        buscar +
        "&criterio=" +
        criterio;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.cart = respuesta.detalle_pedidos.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });

      url = "/pedido?page=" + page + "&buscar=" + buscar + "&criterio=id";
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.total_carrito = respuesta.pedidos.data[0].total;
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    cerrarModal() {
      this.modal = 0;
      this.tituloModal = "";
      this.tipoAccion = 0;
      this.cart = [];
    },

    abrirModal(accion,idpedido,data=[]) {
      this.modal = 1;
      if(accion=="ver"){
      this.tituloModal = "Detalle del pedido";
      this.tipoAccion = 2;
      this.verDetallePedido(1, idpedido, "idpedido");
      }
      if(accion=="actualizar"){
      this.tituloModal = "Actualizar pedido: "+idpedido;
      this.tipoAccion = 3;
      this.idpedido=idpedido;
      this.idusuario=data["id_usuario"];
      this.tracking=data["tracking"];

      }
    },
     actualizarPedido() {
      let me = this;
      axios
        .put("/pedido/actualizar", {
          id: this.idpedido,
          idusuario: this.idusuario,
          tracking: this.tracking
        })
        .then(function(response) {
           me.listarPedido(1, "", "idusuario");
           me.cerrarModal();
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    verFactura(idepedido){
      this.modal = 1;
      this.tituloModal = "Factura "+ idpedido;
      this.tipoAccion = 3;  
    },
   
    desactivarBodega(idpedido) {
      swal({
        title: "Desactivar para bodega?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true
      }).then(result => {
        if (result.value) {
          let me = this;

          axios
            .put("/pedido/desactivarBodega", {
              id: idpedido
            })
            .then(function(response) {
              me.listarPedido(1, "", "idusuario");
              swal(
                "Desactivado!",
                "El registro ha sido desactivado con éxito.",
                "success"
              );
            })
            .catch(function(error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
        }
      });
    },
    activarBodega(idpedido) {
      swal({
        title: "Activar para bodega?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true
      }).then(result => {
        if (result.value) {
          let me = this;

          axios
            .put("/pedido/activarBodega", {
              id: idpedido
            })
            .then(function(response) {
              me.listarPedido(1, "", "idusuario");
              swal(
                "Aactivado!",
                "El registro ha sido activado con éxito.",
                "success"
              );
            })
            .catch(function(error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
        }
      });
    },

    despachado(idpedido,idusuario) {
      swal({
        title: "Cambiar pedido a despachado?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true
      }).then(result => {
        if (result.value) {
          let me = this;

          axios
            .put("/pedido/despachado", {
              id: idpedido,
              idusuario: idusuario
            })
            .then(function(response) {
              me.listarPedido(1, "", "idusuario");
              swal(
                "Despachado!",
                "El pedido ha sido modificado con éxito.",
                "success"
              );
            })
            .catch(function(error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
        }
      });
    },
    activar(idpedido) {
      swal({
        title: "Cambiar pedido a pendiente?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true
      }).then(result => {
        if (result.value) {
          let me = this;

          axios
            .put("/pedido/activar", {
              id: idpedido
            })
            .then(function(response) {
              me.listarPedido(1, "", "idusuario");
              swal(
                "Pendiente!",
                "El pedido ha sido modificado con éxito.",
                "success"
              );
            })
            .catch(function(error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
        }
      });
    },
    desactivar(idpedido) {
      swal({
        title: "Descartar pedido?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,
        reverseButtons: true
      }).then(result => {
        if (result.value) {
          let me = this;

          axios
            .put("/pedido/desactivar", {
              id: idpedido
            })
            .then(function(response) {
              me.listarPedido(1, "", "idusuario");
              swal(
                "Descartado!",
                "El pedido ha sido modificado con éxito.",
                "success"
              );
            })
            .catch(function(error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
        }
      });
    }
  },

  mounted() {
    this.listarPedido(1, "", "idusuario");
  }
};
</script>
<style>
.modal-content {
  width: 100% !important;
  position: absolute !important;
}
.mostrar {
  display: list-item !important;
  opacity: 1 !important;
  position: absolute !important;
  background-color: #3c29297a !important;
}
.div-error {
  display: flex;
  justify-content: center;
}
.text-error {
  color: red !important;
  font-weight: bold;
}
</style>



<template>
  <main class="main">
    <a @click="abrirModal('catalogo')">
     <a href="#">
     <i class="material-icons" style="color:green;float: right;font-size: 7vh;width:50px;height:50px;margin-right:10px;">shopping_cart 
     </i>
     </a>
    </a>
    <!--
                                          <i @click="abrirModal('catalogo')" style="float: right;width: 48px;height: 48px;" class="icon-pencil"></i>
    -->
    <!-- Catalogo -->

    <div class="container">
      <div class="row">
        <div class="col-md-4" v-for="producto in arrayProducto" :key="producto.id">
          <div class="card">
            <a href="#">
              <img
                width="200"
                height="200"
                src="https://cdn.shopify.com/s/files/1/2964/0212/products/Barra-Chocolate_800x.png?v=1542991921"
              />
            </a>
            <div class="card-body">
            <hr>
              <div class="row">
                <div class="col-md-7">
                  <h5 class="card-title" v-text="producto.nombre"></h5>
                </div>
                <div class="col-md-5 text-right">
                  <p
                    class="card-text"
                    style="color:green;"
                    v-text="'Precio unitario: $'+producto.total"
                  ></p>
                </div>
              </div>

              <!--
               <button
                class="btn btn-info"
                type="submit"
                onClick="agregar({{producto.id}})"
              >agregar carrito</button>
              -->
              <button
                class="btn btn-info"
                @click="sumar(producto.id,producto.nombre,1,producto.total)"
              >+1</button>
              <button
                class="btn btn-info"
                @click="sumar(producto.id,producto.nombre,5,producto.total)"
              >+5</button>
              <button
                class="btn btn-info"
                @click="sumar(producto.id,producto.nombre,10,producto.total)"
              >+10</button>

              <br />

              <button
                class="btn btn-info"
                @click="sumar(producto.id,producto.nombre,-1,producto.total)"
              >-1</button>
              <button
                class="btn btn-info"
                @click="sumar(producto.id,producto.nombre,-5,producto.total)"
              >-5</button>
              <button
                class="btn btn-info"
                @click="sumar(producto.id,producto.nombre,-10,producto.total)"
              >-10</button>

              <div class="row">
                <div class="col-md-6">
                  <div v-for="item in cart" :key="item.id">
                    <h6 v-if="item.cantidad && (producto.id==item.id)">En Carrito: {{item.cantidad}}</h6>
                  </div>
                </div>

                <div class="col-md-6 text-right">
                  <div v-for="item in cart" :key="item.id">
                    <h5
                      style="color:green;"
                      v-if="item.cantidad && (producto.id==item.id)"
                    >Total: ${{item.total}}</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <br />
        </div>
      </div>
    </div>

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

    <!-- Fin Catalogo -->

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
            <div v-if="tipoAccion<=2">
              <form action method="post" enctype="multipart/form-data" class="form-horizontal">
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
                      <h6 v-text="item.id"></h6>
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
              </form>

              <div class="modal-footer">
                <h6 v-text="'Total: $'+total_carrito"></h6>
                <!--
                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>             
                -->
                <button
                  type="button"
                  class="btn btn-success"
                  @click="registrarPedido()"
                >Confirmar Pedido</button>
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
      producto_id: 0,
      idcategoria: 0,
      nombre_categoria: "",
      SKU: "",
      nombre: "",
      descripcion: "",
      marca: "",
      contenido_display: 0,
      valor_neto: 0,
      valor_bruto: 0,
      pvp_unitario: 0,
      total_neto: 0,
      imagen: new Image(),
      stock: 0,
      total: 0,
      estado: 0,
      descuento: 0,
      arrayProducto: [],
      modal: 0,
      tituloModal: "",
      tipoAccion: 0,
      errorProducto: 0,
      errorMostrarMsjProducto: [],
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
      buscar: "",
      arrayCategoria: [],
      arrayCarrito: [],
      cart: [],
      total_carrito: 0,
      arrayPedido: []
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
    listarProducto(page, buscar, criterio) {
      let me = this;
      var url =
        "/producto?page=" +
        page +
        "&buscar=" +
        buscar +
        "&criterio=" +
        criterio;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayProducto = respuesta.productos.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    selectCategoria() {
      let me = this;
      var url = "/categoria/selectCategoria";
      axios
        .get(url)
        .then(function(response) {
          // console.log(response);
          var respuesta = response.data;
          me.arrayCategoria = respuesta.categorias;
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
      me.listarProducto(page, buscar, criterio);
    },

    registrarProducto() {
      if (this.validarProducto()) {
        return;
      }

      let me = this;
      // axios.post('/producto/cargarImagen',{'imagen':this.imagen});

      axios
        .post("/producto/registrar", {
          imagen: this.imagen,
          idcategoria: this.idcategoria,
          //'nombre_categoria':this.nombre_categoria,
          SKU: this.SKU,
          nombre: this.nombre,
          descripcion: this.descripcion,
          descuento: this.descuento,
          total: this.total,
          estado: this.estado
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarProducto(1, "", "nombre");
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    verProducto() {},

    agregar() {},
    sumar(id_producto, nombre_producto, cantidad_producto, precio_producto) {
      for (var i = 0; i < this.cart.length; i++) {
        if (this.cart[i].id == id_producto) {
          if (!(this.cart[i].cantidad + cantidad_producto < 0)) {
            this.cart[i].cantidad += cantidad_producto;
            this.cart[i].total = this.cart[i].cantidad * precio_producto;
            if(this.cart[i].cantidad==0){
              this.cart.splice(i,1);
            }
            return;
          }
        }
      }
      if (cantidad_producto > 0) {
        var total_producto = cantidad_producto * precio_producto;
        this.cart.push({
          id: id_producto,
          nombre: nombre_producto,
          precio_unitario: precio_producto,
          cantidad: cantidad_producto,
          total: total_producto
        });
      }
    },

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
    registrarPedido() {
      let me = this;

      if(this.cart.length >0){
      axios
        .post("/pedido/registrar", {
          //idusuario: this.auth_user,
          total: this.total_carrito,
          cart: this.cart
        })
        .then(function(response) {
          // me.registrarDetalle_Pedido();
          me.cerrarModal();
        })
        .catch(function(error) {
          console.log(error);
        });
    }else{
      alert('No tiene productos en el carrito para hacer un pedido');
    }
    },
    registrarDetalle_Pedido() {
      let me = this;
      axios
        .post("/detalle_pedido/registrar", {
          cart: this.cart
        })
        .then(function(response) {
          // me.cerrarModal();
        })
        .catch(function(error) {
          console.log(error);
        });
    },

    actualizarProducto() {
      if (this.validarProducto()) {
        return;
      }

      let me = this;

      axios
        .put("/producto/actualizar", {
          id: this.producto_id,
          idcategoria: this.idcategoria,
          //'nombre_categoria':this.nombre_categoria,
          SKU: this.SKU,
          nombre: this.nombre,
          descripcion: this.descripcion,
          descuento: this.descuento,
          total: this.total,
          estado: this.estado
        })
        .then(function(response) {
          me.cerrarModal();
          me.listarProducto(1, "", "nombre");
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    desactivarProducto(id) {
      swal({
        title: "Esta seguro de desactivar este producto?",
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
            .put("/producto/desactivar", {
              id: id
            })
            .then(function(response) {
              me.listarProducto(1, "", "nombre");
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
    activarProducto(id) {
      swal({
        title: "Esta seguro de activar este producto?",
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
            .put("/producto/activar", {
              id: id
            })
            .then(function(response) {
              me.listarProducto(1, "", "nombre");
              swal(
                "Activado!",
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
    validarProducto() {
      this.errorProducto = 0;
      this.errorMostrarMsjProducto = [];
      if (this.idcategoria == 0)
        this.errorMostrarMsjProducto.push("Seleccione una categoria");
      if (!this.nombre)
        this.errorMostrarMsjProducto.push(
          "El nombre de del producto no puede estar vacío."
        );
      if (this.errorMostrarMsjProducto.length) this.errorProducto = 1;

      return this.errorProducto;
    },
    cerrarModal() {
      this.modal = 0;
      this.tituloModal = "";
      this.idcategoria = 0;
      this.nombre_categoria = "";
      this.SKU = "";
      this.nombre = "";
      this.descripcion = "";
      this.descuento = 0;
      this.total = 0;
      this.estado = 0;
      this.errorProducto = 0;
      this.total_carrito= 0;
    },

    abrirModal(modelo, accion, data = []) {
      switch (modelo) {
        case "producto": {
          switch (accion) {
            case "registrar": {
              this.modal = 1;
              this.tituloModal = "Registrar Producto";
              this.idcategoria = 0;
              this.nombre_categoria = "";
              this.SKU = "";
              this.nombre = "";
              this.descripcion = "";
              this.descuento = 0;
              this.total = 0;
              this.estado = 1;
              this.tipoAccion = 1;

              break;
            }
            case "actualizar": {
              //console.log(data);
              this.modal = 1;
              this.tituloModal = "Actualizar Producto";
              this.tipoAccion = 2;
              this.producto_id = data["id"];
              this.idcategoria = data["idcategoria"];
              //  this.nombre_categoria=data['nombre_categoria'];
              this.SKU = data["SKU"];
              this.nombre = data["nombre"];
              this.descripcion = data["descripcion"];
              this.descuento = data["descuento"];
              this.total = data["total"];
              this.estado = data["estado"];
              break;
            }
            case "ver": {
              //console.log(data);
              this.modal = 1;
              this.tituloModal = data["nombre"];
              this.tipoAccion = 3;
              this.producto_id = data["id"];
              this.idcategoria = data["idcategoria"];
              //  this.nombre_categoria=data['nombre_categoria'];
              this.SKU = data["SKU"];
              this.nombre = data["nombre"];
              this.descripcion = data["descripcion"];
              this.descuento = data["descuento"];
              this.total = data["total"];
              this.estado = data["estado"];
              break;
            }
          }
        }
        case "catalogo": {
          this.modal = 1;
          this.tituloModal = "Carrito";
          this.tipoAccion = 2;

          for (var i = 0; i < this.cart.length; i++) {
            this.total_carrito += this.cart[i].total;
          }
          break;
        }
      }
      this.selectCategoria();
    }
  },

  mounted() {
    this.listarProducto(1, this.buscar, this.criterio);
    //this.listarPedido(1, this.buscar, this.criterio);
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

<template>
  <main class="main">
    <!-- Breadcrumb 
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Escritorio</a></li>

    </ol>-->
    <div class="container-fluid">
      <!-- Ejemplo de tabla Listado -->
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Productos
          <button
            type="button"
            @click="abrirModal('producto','registrar')"
            class="btn btn-secondary"
          >
            <i class="icon-plus"></i>&nbsp;Nuevo
          </button>
        </div>
        <div class="card-body">
          <div class="form-group row">
            <div class="col-md-6">
              <div class="input-group">
                <select class="form-control col-md-3" v-model="criterio">
                  <option value="nombre">Nombre</option>
                  <option value="descripcion">Descripción</option>
                </select>
                <input
                  type="text"
                  v-model="buscar"
                  @keyup.enter="listarProducto(1,buscar,criterio)"
                  class="form-control"
                  placeholder="Texto a buscar"
                />
                <button
                  type="submit"
                  @click="listarProducto(1,buscar,criterio)"
                  class="btn btn-primary"
                >
                  <i class="fa fa-search"></i> Buscar
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered table-striped table-sm">
            <thead>
              <tr>
                <th></th>
                <th>Opciones</th>
                <th>SKU</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Total</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="producto in arrayProducto" :key="producto.id">
                <td>
                  <!--<img src="/img/productos/1.png" />-->
                   <img :src="'/img/productos/'+producto.imagen" style="max-width:40px;"/>
                   

                </td>
                <td>
                  <a href="#" @click="abrirModal('producto','actualizar',producto)">
                    <i class="material-icons">edit</i>
                  </a>
                  &nbsp;
                  <a
                    href="#"
                    @click="abrirModal('producto','ver',producto)"
                  >
                    <i class="material-icons">zoom_in</i>
                  </a>
                </td>
                <td v-text="producto.SKU"></td>
                <td v-text="producto.nombre"></td>
                <td v-text="producto.nombre_categoria"></td>
                <td v-text="producto.descripcion"></td>
                <td v-text="producto.total"></td>
                <td>
                  <div v-if="producto.estado">
                    <a href="#" @click="desactivarProducto(producto.id)">
                      <span class="badge badge-success">Activo</span>
                    </a>
                  </div>
                  <div v-else>
                    <a href="#" @click="activarProducto(producto.id)">
                      <span class="badge badge-danger">Desactivado</span>
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
            <div v-if="tipoAccion<=2">
              <form action method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group row">
                  <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                  <div class="col-md-9">
                    <select class="form-control" v-model="idcategoria">
                      <option value="0" disabled>seleccione</option>
                      <option
                        v-for="categoria in arrayCategoria"
                        :key="categoria.id"
                        :value="categoria.id"
                        v-text="categoria.nombre"
                      ></option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-3 form-control-label" for="text-input">SKU</label>
                  <div class="col-md-9">
                    <input
                      type="text"
                      v-if="tipoAccion<=2"
                      v-model="SKU"
                      class="form-control"
                      placeholder="SKU"
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                  <div class="col-md-9">
                    <input
                      type="text"
                      v-model="nombre"
                      class="form-control"
                      placeholder="Nombre de producto"
                    />
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-3 form-control-label" for="text-input">Descripcion</label>
                  <div class="col-md-9">
                    <input
                      type="text"
                      v-model="descripcion"
                      class="form-control"
                      placeholder="Descripcion"
                    />
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-3 form-control-label" for="text-input">Total</label>
                  <div class="col-md-9">
                    <input type="number" v-model="total" class="form-control" placeholder="Total" />
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-3 form-control-label" for="text-input">Descuento</label>
                  <div class="col-md-9">
                    <input
                      type="hidden"
                      v-model="descuento"
                      class="form-control"
                      placeholder="Descuento"
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-3 form-control-label" for="text-input">Imagen</label>
                  <div class="col-md-9">
                   <input type="file"  class="form-control" name='imagen' @change="updateImage" >   
                    <br /> 
                    <vue-progress-bar></vue-progress-bar>
                    <!--
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click.prevent="updateInfo">Cargar Imagen</button>
                    -->
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-3 form-control-label" for="text-input">Estado</label>
                  <div class="col-md-9">
                    <select class="form-control" v-model="estado">
                      <option value="1">Activo</option>
                      <option value="0">Inactivo</option>
                    </select>
                  </div>
                </div>

                <div v-show="errorProducto" class="form-group row div-error">
                  <div class="text-center text-error">
                    <div v-for="error in errorMostrarMsjProducto" :key="error" v-text="error"></div>
                  </div>
                </div>
              </form>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                <button
                  type="button"
                  v-if="tipoAccion==1"
                  class="btn btn-primary"
                  @click="registrarProducto()"
                >Guardar</button>
                <button
                  type="button"
                  v-if="tipoAccion==2"
                  class="btn btn-primary"
                  @click="actualizarProducto()"
                >Actualizar</button>
              </div>
            </div>
            <div v-if="tipoAccion>2">
              <img src="/storage/imagenes/logo1.jpg" />
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
      imagen: 0,
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
      arrayCategoria: []
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
    //

    getImage(){

       let vm=this;
      return "img/productos/"+ vm.imagen;
    },
    
    /*
    
     updateInfo () {

      this.$Progress.start();
      var url= '/producto/cargarImagen';

      axios.put(url,{
          'imagen': this.imagen
          }).then(() => {
              this.$Progress.finish();
          }).catch(() => {
                this.$Progress.fail();
          });

    },*/

    updateImage (e){
                
      let vm=this;
      let file = e.target.files[0];
      console.log(file);
      let reader = new FileReader();
        
      if(file['size'] < 2111775 ){
            reader.onloadend = (file) => {
           //console.log('nombre img', reader.result);
            vm.imagen = reader.result;
          //
        }
      reader.readAsDataURL(file);
      } else {

              swal({
                  type: 'error',
                  title: 'Imagen pesada',
                  text: 'El peso de la imagen excede el recomendado: 2 MB',
              });
                  vm.imagen = 0;
      }

  },

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

    //this.$Progress.start();

      axios
        .post("/producto/registrar", {
          imagen: this.imagen, /*this.imagen*/ /* Acá va el nombre de la imagen que se aloja en la BBDD */
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
          //this.$Progress.finish();
          me.cerrarModal();
          me.listarProducto(1, "", "nombre");
        })
        .catch(function(error) {
           //this.$Progress.fail();
          console.log(error);
        });
         
    },
    verProducto() {},

    actualizarProducto() {
      if (this.validarProducto()) {
        return;
      }

      let me = this;

      axios
        .put("/producto/actualizar", {
          id: this.producto_id,
          idcategoria: this.idcategoria,
          imagen: this.imagen,
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
         if (this.imagen == 0)
        this.errorMostrarMsjProducto.push("Debe ingresar una imagen");
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
      }
      this.selectCategoria();
    }
  },
  mounted() {
    this.listarProducto(1, this.buscar, this.criterio);
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

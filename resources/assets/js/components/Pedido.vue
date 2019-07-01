<template>
            <main class="main">
           

         
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Pedidos
                      
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="idusuario">idusuario</option>
                                      
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPedido(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarPedido(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Acciones</th>
                                    <th>ID Pedido</th>
                                    <th>Total</th>                               
                                    <th>Tracking ID</th>
                                    <th>Fecha</th>
                                    <th>Actualizado</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="pedido in arrayPedido" :key="pedido.id">
                                   
                                    <td>
                                        <button type="button" @click="abrirModal(pedido.id)" class="btn btn-outline-warning">
                                          <i class="icon-eye"></i>
                                        </button> &nbsp;
                                    </td>
                                    <td v-text="pedido.id"></td>
                                    <td v-text="pedido.total"></td>
                                    <td v-text="pedido.tracking"></td>
                                    <td v-text="pedido.created_at"></td>
                                    <td v-text="pedido.updated_at"></td>
                                    <td>
                                        <div v-if="pedido.estado">
                                            <span class="badge badge-success">Pendiente</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Despachado</span>
                                        </div>
                                        
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
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
             
               <div class="row">
                <div class="col-md-2">
                   <h4 >SKU</h4>
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
        data (){
            return {
                
                arrayPedido : [],
                total_carrito:0,
                cart:[],
                modal : 0,
            
                tituloModal : '',
                tipoAccion : 0,              
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : ''
            }
        },
        
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            }
        },
        methods : {
            listarPedido (page,buscar,criterio){
                let me=this;
                var url= '/pedido?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPedido = respuesta.pedidos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarPedido(page,buscar,criterio);
            },

            verDetallePedido (page,buscar,criterio){
                let me=this;
                var url= '/detalle_pedido?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.cart = respuesta.detalle_pedidos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });

                url= '/pedido?page=' + page + '&buscar='+ buscar + '&criterio=id';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.total_carrito = respuesta.pedidos.data[0].total;
                  
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

        cerrarModal() {
        this.modal = 0;
        this.tituloModal = "";
        this.tipoAccion = 0;
        this.cart=[];
    },
 
    abrirModal(idpedido) {

          this.modal = 1;
          this.tituloModal = "Detalle del pedido";
          this.tipoAccion = 2;        
          this.verDetallePedido(1,idpedido,'idpedido');            
         }
        
        },    
          
  mounted() {
    this.listarPedido(1,'','idusuario');
  }
};
    
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>

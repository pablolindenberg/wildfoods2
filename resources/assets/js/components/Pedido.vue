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
           
        </main>
</template>

<script>
    export default {
        data (){
            return {
                
                arrayPedido : [],
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
        props:[
            "authUser"
        ],
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
            }
           
        },
        mounted() {
            console.log(this.authUser);
            this.listarPedido(1,'','idusuario');
        }
    }
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

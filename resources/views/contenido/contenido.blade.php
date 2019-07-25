    @extends('principal')
    @section('contenido')


    @if(Auth::check())
            @if(Auth::user()->idrol ==1)
                <template v-if="menu==0">
                <h1></h1>
                </template>

                <template v-if="menu==1">
               <!-- <h1>Categorias</h1>-->
                    <categoria></categoria>
                </template>

                <template v-if="menu==2">
                <!-- h1>Productos</h1> -->
                <producto></producto>
                </template>
                <template v-if="menu==3">
                  <catalogo></catalogo>
                </template>

                <template v-if="menu==4">
                    <!--<h1>Pedidos</h1>-->
                    <pedido></pedido>
                </template>

            

                <template v-if="menu==5">
                   <!-- <h1>Contenido del menú 5</h1>-->
                </template>

                <template v-if="menu==6">
               <!-- <h1>Usuarios</h1>-->
                <user></user>
                </template>

                <template v-if="menu==7">
                <!--<h1>Roles</h1>-->
                <rol></rol>
                </template>

                <template v-if="menu==8">
                    
                </template>

                <template v-if="menu==9">
                   <!-- <h1>Contenido del menú 9</h1>-->
                </template>        

            @elseif(Auth::user()->idrol ==2)
            <template v-if="menu==1">
                    <!--<h1>Pedidos</h1>-->
                    <pedidoBodega></pedidoBodega>
                </template>
            @elseif(Auth::user()->idrol ==3)
                <template v-if="menu==11">
              <!--  <h1>Catálogo</h1> -->
                    <catalogo></catalogo>
                </template>
                <template v-if="menu==12">
              <!--  <h1>Pedidos</h1> -->
                    <pedidoCliente></pedidoCliente>
                </template>
            @else
            @endif  
              
        @endif  

        
        
    @endsection
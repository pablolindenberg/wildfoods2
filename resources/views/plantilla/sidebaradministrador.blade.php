<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                <!--
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link active" href="#"><i class="icon-speedometer"></i>Administración</a>
                    </li>
                -->
                    <li class="nav-title">
                        Menu
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i> Productos</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=1" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Categorías</a>
                            </li>
                            <li @click="menu=2" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i> Productos</a>
                            </li>
                        </ul>
                    </li>
                  
                            <li @click="menu=3" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-basket-loaded"></i> Pedidos</a>
                            </li>
                            
                        
                    
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i>Acceso</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=6" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user"></i> Usuarios</a>
                            </li>
                            <li @click="menu=7" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user-following"></i> Roles</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> Reportes</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=8" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i> Reporte Ingresos</a>
                            </li>
                            <li @click="menu=9" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i> Reporte Ventas</a>
                            </li>
                        </ul>
                    </li>
                   
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>
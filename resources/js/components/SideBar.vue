<template>
<!-- sidebar-dark-primary
 -->    <aside class="main-sidebar sidebar-light-info  
    elevation-4">
   <a href="index3.html" class="brand-link">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
        </a>

        <div class="sidebar">

            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
<!--                     <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
 -->              
 <img class="img-circle elevation-2 bg-white"
 src="/assets/img/21-avatar-flat.gif" alt="User Image">
</div>
                <div class="info">
                    <a href="#" class="d-block">Alexander Pierce</a>
                </div> 
            </div>

            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
                <div class="sidebar-search-results">
                    <div class="list-group"><a href="#" class="list-group-item">
                            <div class="search-title"><strong class="text-light"></strong>N<strong
                                    class="text-light"></strong>o<strong class="text-light"></strong> <strong
                                    class="text-light"></strong>e<strong class="text-light"></strong>l<strong
                                    class="text-light"></strong>e<strong class="text-light"></strong>m<strong
                                    class="text-light"></strong>e<strong class="text-light"></strong>n<strong
                                    class="text-light"></strong>t<strong class="text-light"></strong> <strong
                                    class="text-light"></strong>f<strong class="text-light"></strong>o<strong
                                    class="text-light"></strong>u<strong class="text-light"></strong>n<strong
                                    class="text-light"></strong>d<strong class="text-light"></strong>!<strong
                                    class="text-light"></strong></div>
                            <div class="search-path"></div>
                        </a></div>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    <li class="nav-item">

                        <router-link :to="{ name: 'ProductsIndex' }" active-class=" text-white active" class="nav-link text-gray-dark fw-medium">
                            <!--                             <i class="nav-icon fas fa-users"></i>
 -->
                            <i class="fas fa-shopping-cart"></i>

                            <p>
                                Productos
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item">

                        <router-link :to="{ name: 'BlancoBioIndex' }" active-class=" text-white active" class="nav-link text-gray-dark fw-medium">

                            <i class="fas fa-feather"></i>
                            <p>
                                  Blanco Biologico
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">

                        <router-link :to="{ name: 'UnidadMediIndex' }" active-class="text-white active"
                            class="nav-link text-gray-dark fw-medium">

                            <i class="fas fa-grip-lines"></i>
                            <p>
                                Unidad Medida
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">

                        <router-link :to="{ name: 'TipoProductIndex' }" active-class="text-white active"
                        class="nav-link text-gray-dark fw-medium">

                            <i class="fas fa-quidditch"></i>
                            <p>
                                Tipo de producto
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">

                        <router-link :to="{ name: 'IngredienteActivoIndex' }" active-class="text-white active"
                            class="nav-link text-gray-dark fw-medium">

                            <i class="fas fa-quidditch"></i>
                            <p>
                                Ingrediente activo
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">

                        <router-link :to="{ name: 'IngredienteActivoProductIndex' }" active-class="text-white active"
                            class="nav-link text-gray-dark fw-medium">

                            <i class="fas fa-quidditch"></i>
                            <p>
                                Ingredientes x producto
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">

                        <router-link :to="{ name: 'TipoAplicacionIndex' }" active-class="text-white active"
                            class="nav-link text-gray-dark fw-medium ">

                            <i class="fas fa-spray-can"></i>                            <p>
                                Tipo de aplicacion
                            </p>
                        </router-link>
                    </li>
              <!--            <li class="nav-item">

                        <router-link :to="{ name: 'IngredienteActivoProductIndex' }" active-class="text-white active"
                            class="nav-link text-gray-dark fw-medium">

                            <i class="fas fa-quidditch"></i>
                            <p>
                                Blanco Biologico X producto
                            </p>
                        </router-link>
                    </li> -->
                </ul>
            </nav>

        </div>

    </aside>
</template>
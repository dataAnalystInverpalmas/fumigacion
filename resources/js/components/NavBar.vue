<script setup>
/* import { useRouter } from 'vue-router'; */


</script>
<template>
<nav class="main-header navbar navbar-expand-md bg-gradient-navBar navbar-white">
    <div class="container">
     <a href="" class="navbar-brand">
            <img src="/assets/img/Logo-Inv.png" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3 d-inline-block align-middle mr-2" style="opacity: .8"  width="45">
            <span class="brand-text font-weight-bold  text-white" >FUMIGACION</span>
        </a> 
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
            data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars text-white" ></i></a>
                </li>
                <li class="nav-item">
                    <router-link   :to="{ name: 'programIndex'}"  active-class="active" class="nav-link text-white">
<!--                             <i class="nav-icon fas fa-users"></i>
 -->                            <p>
                                PROGRAMACION
                            </p>
                        </router-link>
<!--                     <a href="index3.html" class="nav-link text-white">PROGRAMACION</a>
 -->                </li>
           
    <!--             <li class="nav-item">
                    <a href="index3.html" class="nav-link">PROGRAMACION</a>
                </li> -->
                <li class="nav-item">
                    <a href="#" class="nav-link"></a>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" class="text-white nav-link dropdown-toggle">RECETAS</a>
                    <ul aria-labelledby="dropdownSubMenu1" class=" dropdown-menu border-0 shadow">
                        <li><a href="#" class="dropdown-item ">Definicion </a></li>
<!--                         <li><a href="#" class="dropdown-item">Some other action</a></li>
 -->                        <li class="dropdown-divider"></li>

                        <li class="dropdown-submenu dropdown-hover">
                            <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"
                                class="dropdown-item dropdown-toggle">Hover for action</a>
                            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                                <li>
                                    <a tabi ndex="-1" href="#" class="dropdown-item">level 2</a>
                                </li>

                                <li class="dropdown-submenu">
                                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false"
                                        class="dropdown-item dropdown-toggle">level 2</a>
                                    <ul aria-labelledby="dropdownSubMenu3"
                                        class="dropdown-menu border-0 shadow">
                                        <li><a href="#" class="dropdown-item">3rd level</a></li>
                                        <li><a href="#" class="dropdown-item">3rd level</a></li>
                                    </ul>
                                </li>

                                <li><a href="#" class="dropdown-item">level 2</a></li>
                                <li><a href="#" class="dropdown-item">level 2</a></li>
                            </ul>
                        </li>

                    </ul>
                </li>
            </ul>

            <form class="form-inline ml-0 ml-md-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
<i class="fas fa-comments"></i>
<span class="badge badge-danger navbar-badge">3</span>
</a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="#" class="dropdown-item">

                        <div class="media">
          <!--                   <img src="../../dist/img/user1-128x128.jpg" alt="User Avatar"
                                class="img-size-50 mr-3 img-circle"> -->
                            <div class="media-body">
                                <h3 class="dropdown-item-title text-white">
                                    Brad Diesel
                                    <span class="float-right text-sm text-danger"><i
                                            class="fas fa-star text-white"></i></span>
                                </h3>
                                <p class="text-sm">Call me whenever you can...</p>
                                <p class="text-sm text-muted text-white"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>

                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">

                        <div class="media">
<!--                             <img src="../../dist/img/user8-128x128.jpg" alt="User Avatar"
                                class="img-size-50 img-circle mr-3"> -->
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    John Pierce
                                    <span class="float-right text-sm text-muted"><i
                                            class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">I got your message bro</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>

                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">

                        <div class="media">
                          <!--   <img src="../../dist/img/user3-128x128.jpg" alt="User Avatar"
                                class="img-size-50 img-circle mr-3"> -->
                            <div class="media-body">
                                <h3 class="dropdown-item-title">
                                    Nora Silvester
                                    <span class="float-right text-sm text-warning"><i
                                            class="fas fa-star"></i></span>
                                </h3>
                                <p class="text-sm">The subject goes here</p>
                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                            </div>
                        </div>

                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="text-orange far fa-comments "></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header ">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2  "></i> 4 new messages
                        <span class="float-right text-muted text-sm  ">3 mins</span>
                    </a>
                    

                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>
</template>
<style>
.bg-gradient-navBar{
    background: rgb(23,112,212);
background: linear-gradient(90deg, rgba(23,112,212,0.8799894957983193) 34%, rgba(6,140,156,1) 56%);

}
</style>
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

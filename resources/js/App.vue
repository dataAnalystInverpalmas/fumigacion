<script setup>
import ExampleComponent from './components/ExampleComponent.vue';
import NavBar from './components/NavBar.vue';
import SideBar from './components/SideBar.vue';
</script>
<template>
    <div id="app">
<!--         <router-view></router-view>
 -->
<!--         <h1>Vue Router Demo App</h1>
 -->     
<div class="wrapper">
<SideBar/>
 <NavBar/>
 <div class="wrapper d-flex flex-column min-vh-100 bg-light dark:bg-transparent">
           <router-view></router-view>
     </div>
    </div>
</div>
    </template>  
 
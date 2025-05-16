<script setup>
import logo from '@/assets/white-colorful.png';
import darkLogo from '@/assets/dark.png';
import {RouterLink, RouterView, useRouter} from 'vue-router'
import BtnFull from "@/components/BtnFull.vue";
import BtnEmpty from "@/components/BtnEmpty.vue";
import Switch from "@/components/Switch.vue";
import {onMounted, watch, watchEffect} from "vue";
import {debug, siteInfo} from "@/utils.js";

const router = useRouter();
onMounted(() => {
  checkUser();
})

watchEffect(() => {
  localStorage.setItem('theme', siteInfo.isWhiteTheme);
})

function checkUser() {
  const user = JSON.parse(localStorage.getItem('user') || '{}');
  const theme = JSON.parse(localStorage.getItem('theme') || 'false');
  if (siteInfo.userEmail === null && user !== null) {
    siteInfo.userToken = user.token;
    siteInfo.userEmail = user.email;
  }
  siteInfo.isWhiteTheme = theme;
}

function handleLogout() {
  siteInfo.clearUser();
  checkUser()
  router.push('/login');
}

function logout() {
  siteInfo.userEmail = undefined;
  siteInfo.userToken = undefined;
  localStorage.removeItem('user');
  router.push('/')
}

</script>

<template>
  <div class="home" :class="{
    'dark': !siteInfo.isWhiteTheme
  }">
    <header class="container d-flex align-items-center justify-content-between">
      <img :src="siteInfo.isWhiteTheme ? logo : darkLogo" alt="Logotipo da marca">
      <div>
        <nav>
          <router-link class="link-header" to="/">Home</router-link>
          <Switch v-model="siteInfo.isWhiteTheme">Alterar Tema</Switch>
          <router-link to="/login" v-if="!siteInfo.userEmail">
            <BtnFull>Entrar</BtnFull>
          </router-link>
          <router-link to="/cadastro" v-if="!siteInfo.userEmail">
            <BtnEmpty>Cadastrar-se</BtnEmpty>
          </router-link>
          <router-link to="/view-profile" v-if="siteInfo.userEmail">
            {{ siteInfo.userEmail }}
          </router-link>
          <BtnEmpty v-if="siteInfo.userEmail" @click="logout">Sair</BtnEmpty>
        </nav>
      </div>
    </header>
  <RouterView/>
  </div>
</template>

<style scoped>
nav {
  display: flex;
  align-items: center;
  gap: 1rem;
}
</style>

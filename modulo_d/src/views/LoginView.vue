<script setup>

import Title from "@/components/Title.vue";
import {reactive, useId} from "vue";
import InputLabel from "@/components/InputLabel.vue";
import BtnFull from "@/components/BtnFull.vue";
import {request, siteInfo} from "@/utils.js";
import Text from "@/components/Text.vue";
import {useRouter} from "vue-router";

const router = useRouter();
const user = reactive({
  email: '',
  password: '',
  errorMessage: '',
})

const idEmail = useId();
const idPass = useId();

async function handleSubmit() {
  user.errorMessage = '';
  const res = await request('auth/login', {
    method: "POST",
    body: JSON.stringify(user),
  })
  const data = await res.json();
  if (data.token !== undefined) {
    siteInfo.userToken = data.token;
    siteInfo.userEmail = user.email;
    localStorage.setItem('user', JSON.stringify({
      email: user.email,
      token: data.token
    }));
    await router.push('/view-profile');
  } else {
    user.errorMessage = 'Email ou senha inválidos. Tente novamente'
  }
}
</script>

<template>
  <div class="container col-sm-12 col-md-5 mx-auto">
    <Title class="mb-5">Login</Title>
    <form @submit.prevent="handleSubmit">
      <div class="mb-3 d-flex flex-column">
        <label :for="idEmail" class="form-label">Email</label>
        <input type="email" v-model="user.email" :id="idEmail">
      </div>
      <div class="mb-3 d-flex flex-column">
        <label :for="idPass" class="form-label">Senha</label>
        <input type="password" v-model="user.password" :id="idPass">
      </div>
      <Text class="text-danger">{{ user.errorMessage }}</Text>
      <BtnFull>Logar</BtnFull>
    </form>
  </div>
</template>

<style scoped>

</style>
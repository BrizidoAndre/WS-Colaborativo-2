<script setup>

import Title from "@/components/Title.vue";
import BtnFull from "@/components/BtnFull.vue";
import {reactive, useId} from "vue";
import {debug, request} from "@/utils.js";
import Text from "@/components/Text.vue";
import {useRouter} from "vue-router";

const router = useRouter();
const newUser = reactive({
  name: '',
  email: '',
  phone: '',
  password: '',
  error: '',
})

const idName = useId();
const idEmail = useId();
const idPhone = useId();
const idPass = useId();

async function handleSubmit() {
  newUser.error = '';
  const res = await request('auth/register', {
    method: "POST",
    body: JSON.stringify(newUser),
  });
  const data = await res.json();
  if (res.status !== 201) {
    newUser.error = 'O cadastro foi inválido, verifique os errors';
    return null;
  }
  router.push('/login');
}
</script>

<template>
  <div class="container col-sm-12 col-md-5 mx-auto">
    <Title class="mb-5">Cadastro</Title>
    <form @submit.prevent="handleSubmit">
      <div class="mb-3 d-flex flex-column">
        <label :for="idName" class="form-label">Nome</label>
        <input type="text" v-model="newUser.name" :id="idName">
      </div>
      <div class="mb-3 d-flex flex-column">
        <label :for="idEmail" class="form-label">Email</label>
        <input type="email" v-model="newUser.email" :id="idEmail">
      </div>
      <div class="mb-3 d-flex flex-column">
        <label :for="idPhone" class="form-label">Telefone</label>
        <input type="text" v-model="newUser.phone" :id="idPhone">
      </div>
      <div class="mb-3 d-flex flex-column">
        <label :for="idPass" class="form-label">Senha</label>
        <input type="password" v-model="newUser.password" :id="idPass">
      </div>
      <Text class="text-danger">{{ newUser.error }}</Text>
      <BtnFull>Cadastrar</BtnFull>
    </form>
  </div>
</template>

<style scoped>

</style>
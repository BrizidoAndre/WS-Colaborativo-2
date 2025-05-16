<script setup>

import {useId, useModel} from "vue";

const id = useId()
const model = useModel();
</script>

<template>

  <div class="mb-3 d-flex flex-column">
    <label :for="id" class="form-label"><slot></slot></label>
    <input type="text" v-model="model" :id="id">
  </div>
</template>

<style scoped>

</style>
<script setup>

  const model = defineModel();

</script>

<template>
  <div class="form-check form-switch">
    <input class="form-check-input" v-model="model" type="checkbox" role="switch" id="switchCheckDefault">
    <label class="form-check-label" for="switchCheckDefault">
      <slot></slot>
    </label>
  </div>
</template>

<style scoped>
label{
  border-bottom: 1px solid var(--black);
}
</style>
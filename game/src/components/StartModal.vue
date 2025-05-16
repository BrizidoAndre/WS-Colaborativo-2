<script setup>
  const emits = defineEmits(['btnPress'])
</script>

<template>
  <div class="modal-background">
    <div class="modal">
      <img class="modal-image"  src="@/assets/images_essencial/wood-modal-bg.png" alt="">
        <h1>Seja bem-vindo!</h1>
        <button class="btn x-auto" @click="emits('btnPress')">Iniciar jornada</button>
    </div>
  </div>
</template>

<style scoped>
.modal-background{
  z-index: 99;
}
.modal{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 5rem;
  z-index: 999;
}

h1{
  font-size: 3rem;
}
.btn{
  font-size: 1.5rem;
}
</style>
<script setup>

const emits = defineEmits(['btnPress'])
const props = defineProps(['xPosition', 'yPosition'])
</script>

<template>
  <button
      :style="{
        'left': props.xPosition + 'px',
        'top': props.yPosition + 'px',
      }"
      @click="emits('btnPress')" class="btn-modal">
    <img src="@/assets/images_essencial/x-mark.png" alt="Pressione para abrir o jogo">
  </button>
</template>

<style scoped>
.btn-modal{
  position: fixed;
  background:none;
  border:none;
  width: 150px;
  aspect-ratio: 1;
  cursor: pointer;
  img{
    width: 100%;
    height: 100%;
  }
}
</style>
<script setup>
import binoculos from '@/assets/images/binoculos.png';
import bussola from '@/assets/images/bussola.png';
import chapeu from '@/assets/images/chapeu.png';
import chaleira from '@/assets/images/chaleira.png';
import {onMounted, onUnmounted, reactive, ref} from "vue";
import {getRandomInt} from "@/assets/utils.js";

const emits = defineEmits(['btnPress', 'btnOut', 'gameWon'])
const props = defineProps(['gameEnd'])
const items = ref([])
const pureItems = [
  {
    img: binoculos,
    value: 0,
    title: 'Binóculos',
  }, {
    img: chapeu,
    value: 1,
    title: 'Chapéu',
  }, {
    img: chaleira,
    value: 2,
    title: 'Chaleira',
  }, {
    img: bussola,
    value: 3,
    title: 'Bussola',
  },
]
const gameInfo = reactive({
  itemSelected: 0,
  itemPressed: null,
})
onMounted(() => {
  if (props.gameEnd) {
    items.value = pureItems;
    return null;
  }
  startGame()
})

function startGame() {
  gameInfo.itemSelected = pureItems[getRandomInt(4)].title;
  items.value = pureItems.sort((a, b) => Math.random() - .5);
}

function pressImg(index) {
  gameInfo.itemPressed = index;
  setTimeout(() => {
    if (items.value[index].title !== gameInfo.itemSelected) {
      gameInfo.itemPressed = 4;
      return null
    }
    emits('gameWon')
  }, 3000)
}
</script>

<template>
  <div class="modal-background">
    <div class="modal">
      <button @click="emits('btnOut')" class="btn-out">
        <img src="@/assets/images_essencial/x-mark.png" alt="Pressione para fechar o modal">
      </button>
      <h2 v-if="!props.gameEnd">Selecione o/a {{ gameInfo.itemSelected }}</h2>
      <h2 v-else>Você ganhou!</h2>
      <div class="container-grid">
        <img
            :class="{
          'press': props.gameEnd || index === gameInfo.itemPressed
            }"
            class="img-game"
            v-for="(item, index) in items" :src="item.img"
            @click="pressImg(index)"
            alt="Imagem a ser selecionada">
      </div>
      <img class="modal-image" src="@/assets/images_essencial/wood-modal-bg.png" alt="">
    </div>
  </div>
</template>

<style scoped>

.img-game {
  width: 150px;
  height: 150px;
  object-fit: cover;
  filter: brightness(0);
}

.press {
  filter: brightness(100%);
}

.container-grid {
  display: grid;
  grid-template-columns: repeat(2, 150px);
  gap: 3rem;
}

.modal-background {
  z-index: 99;
  animation: show .5s linear 1 forwards;
}

.modal {
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 2rem;
  z-index: 9999;
  animation: fadein linear 1s 1 forwards;
}

@keyframes fadein {
  from {
    transform: translateY(-100px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

@keyframes show {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.btn-out {
  cursor: pointer;
  position: absolute;
  top: 10%;
  right: 5%;
  background: none;
  border: none;
  width: 75px;
  aspect-ratio: 1;

  img {
    width: 100%;
    height: 100%;
  }
}

</style>
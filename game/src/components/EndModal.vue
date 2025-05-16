<script setup>
import binoculos from '@/assets/images/binoculos.png';
import bussola from '@/assets/images/bussola.png';
import chapeu from '@/assets/images/chapeu.png';
import chaleira from '@/assets/images/chaleira.png';
import {onMounted, onUnmounted, reactive, ref} from "vue";
import {getRandomInt} from "@/assets/utils.js";

const emits = defineEmits(['btnPress', 'btnOut', 'gameWon'])
const props = defineProps(['time'])
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
      <p>{{time}} segundos</p>
      <form action="">
        <div class="row">
          <div class="col">
            <label for="name">Name</label>
            <input type="text" id="name">
          </div>
          <div class="col">
            <label for="email">Email</label>
            <input type="email" id="email">
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="idade">Number</label>
            <input type="number" id="idade">
          </div>
          <div class="col">
            <label for="telefone">Telefone</label>
            <input type="text" id="telefone">
          </div>
        </div>
        <label for="sugestao">Sugestões</label>
        <input type="text" id="sugestao">
        <input type="submit" class="btn">
      </form>
      <img class="modal-image" src="@/assets/images_essencial/wood-modal-bg.png" alt="">
    </div>
  </div>
</template>

<style scoped>
.col {
  display: flex;
  flex-direction: column;
}

.row {
  display: flex;
  justify-content: space-between;
  gap: 1rem;
}
.row{
  .col{
    flex-grow: 1;
  }
}

form {
  width: 80%;
  display: flex;
  flex-direction: column;
}

input {
  border: none;
  border-radius: var(--radius);
  padding:1rem 1rem 1rem 1.5rem;
}

input[type='submit']{
  margin-top: 2rem;
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

</style>
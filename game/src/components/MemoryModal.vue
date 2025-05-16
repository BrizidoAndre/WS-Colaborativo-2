<script setup>
import canivete from '@/assets/images_essencial/canivete_suico.jpg';
import socorro from '@/assets/images_essencial/primeiros_socorros.jpg'
import filter from '@/assets/images_essencial/garrafa_com_filtro.jpg'
import {onMounted, ref} from "vue";

const emits = defineEmits(['btnPress', 'btnOut'])
const props = defineProps(['gameEnd'])
const cards = ref([]);
const cardsPure = [
  {
    img: canivete,
    value: 1,
    turn: false,
    selected: false,
  }, {
    img: canivete,
    value: 1,
    turn: false,
    selected: false,
  }, {
    img: socorro,
    value: 2,
    turn: false,
    selected: false,
  }, {
    img: socorro,
    value: 2,
    turn: false,
    selected: false,
  }, {
    img: filter,
    value: 3,
    turn: false,
    selected: false,
  }, {
    img: filter,
    value: 3,
    turn: false,
    selected: false,
  },
]

onMounted(() => {
  if (!props.gameEnd) {
    gameStart();
  }
})

function gameStart() {
  cardsPure.sort((a, b) => Math.random() - 0.5);
  cards.value = cardsPure;
}
</script>

<template>
  <div class="modal-background">
    <div class="modal">
      <button @click="emits('btnOut')" class="btn-out">
        <img src="@/assets/images_essencial/x-mark.png" alt="Pressione para fechar o modal">
      </button>
      <div class="game-grid">
        <div v-for="card in cards" class="card">
          <div
              class="card-flip"
              :class="{
            turn: true,
            }"
          >
            <div class="half turn">
              <img :src="card.img" alt="Imagem do jogo">
            </div>
            <div class="half back">

            </div>
          </div>
        </div>
      </div>
      <img class="modal-image" src="@/assets/images_essencial/wood-modal-bg.png" alt="">
    </div>
  </div>
</template>

<style scoped>
.card {
  cursor: pointer;
  width: 250px;
  height: 250px;
  overflow: hidden;
  perspective: 1000px;

  img {
    width: 250px !important;
    height: 250px !important;
    object-fit: cover;
  }
}

.card-flip {
  position: relative;
  height: 250px;
  width: 250px;
}

.back {
  width: 250px;
  height: 250px;
  background: var(--brown);
}

.turn {
  transform: rotateY(180deg);
}

.half {
  position: absolute;
  top: 0;
  backface-visibility: hidden;
}

.game-grid {
  display: grid;
  grid-template-columns: repeat(3, 250px);
  grid-template-rows: repeat(2, 250px);
  gap: 20px;
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
  gap: 5rem;
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
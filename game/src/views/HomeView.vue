<script setup>
import inFull from '@/assets/images_essencial/fullscreen-mark.png';
import outFull from '@/assets/images_essencial/lesscreen-mark.png';
import {onMounted, reactive, useTemplateRef} from "vue";
import StartModal from "@/components/StartModal.vue";
import ButtonModal from "@/components/ButtonModal.vue";
import MemoryModal from "@/components/MemoryModal.vue";
import FireModal from "@/components/FireModal.vue";
import BagModal from "@/components/BagModal.vue";
import EndModal from "@/components/EndModal.vue";


const mainRef = useTemplateRef('mainRef')
const gameInfo = reactive({
  start: false,
  memoryGame: false,
  fireGame: false,
  barrackGame: false,
  showMemoryGame: false,
  showFireGame: false,
  showBarrackGame: false,
  xPosition: 850,
  intervalMovement: null,
  alreadyMoving: false,
  fullScreen: false,
  allDone: false,
  time: 0,
  timeInterval: null
})


function startGame() {
  gameInfo.start = true;
  setEvents()
  localStorage.setItem('start', JSON.stringify(true));
  gameInfo.timeInterval = setInterval(() => {
    gameInfo.time++;
  }, 1000)
}

function setEvents() {
  setTimeout(() => {
    window.addEventListener('keydown', addPressKey);
    window.addEventListener('keyup', clearMovement)
  }, 500);
}

function unsetEvents() {
  window.removeEventListener('keydown', addPressKey);
  window.removeEventListener('keyup', clearMovement);
}

function addPressKey(ev) {
  if (gameInfo.alreadyMoving) {
    return null;
  }
  let key = (ev.key);
  if (key === 'ArrowLeft') {
    gameInfo.intervalMovement = setInterval(() => {
      gameInfo.xPosition += -5;
    }, 10)
  } else if (key === "ArrowRight") {
    gameInfo.intervalMovement = setInterval(() => {
      gameInfo.xPosition += 5;
    }, 10)
  }
  gameInfo.alreadyMoving = true;
}

onMounted(() => {
  gameInfo.start = JSON.parse(localStorage.getItem('start') || "false");
  if (gameInfo.start) {
    setEvents()
  }
})

function clearMovement() {
  clearInterval(gameInfo.intervalMovement);
  gameInfo.alreadyMoving = false;
}

function toggleFullScreen() {
  if (!gameInfo.fullScreen) {
    mainRef.value.requestFullscreen();
  } else {
    document.exitFullscreen()
  }
  gameInfo.fullScreen = !gameInfo.fullScreen;
}

function fireGameWon() {
  gameInfo.fireGame = true;
  gameInfo.showFireGame = false;
  gameEnd();
}

function gameEnd() {
  if (!gameInfo.fireGame || !gameInfo.barrackGame) {
    return null;
  }
  let id = setInterval(() => {
    clearInterval(gameInfo.timeInterval);
    unsetEvents();
    gameInfo.xPosition -= 60;
    if (gameInfo.xPosition < -100) {
      clearInterval(id);
      gameInfo.allDone = true;
    }
  }, 3000)
}

function barrackGameWon() {
  gameInfo.barrackGame = true;
  gameInfo.showBarrackGame = false;
  gameEnd();
}
</script>

<template>
  <main ref="mainRef">
    <StartModal v-if="!gameInfo.start" @btn-press="startGame"/>
    <EndModal :time="gameInfo.time" v-if="gameInfo.allDone"/>
    <MemoryModal
        :game-end="gameInfo.memoryGame"
        v-if="gameInfo.showMemoryGame"
        @btn-out="gameInfo.showMemoryGame = false"
    />
    <FireModal
        @game-won="fireGameWon"
        :game-end="gameInfo.fireGame"
        v-if="gameInfo.showFireGame"
        @btn-out="gameInfo.showFireGame = false"/>
    <BagModal
        @game-won="barrackGameWon"
        :game-end="gameInfo.barrackGame"
        v-if="gameInfo.showBarrackGame"
        @btn-out="gameInfo.showBarrackGame = false"/>
    <button @click="toggleFullScreen" class="btn-fullscreen">
      <img :src="!gameInfo.fullScreen ? inFull : outFull" alt="Pressione para alterar tela cheia">
    </button>
    <img
        class="game-background"
        src="@/assets/svg/main_screen.svg"
        alt="Imagem de fundo do jogo"
    >
    <img
        :class="{
      'showing-char': gameInfo.start,
        }"
        :style="{
          'left': gameInfo.xPosition + 'px',
        }"
        class="game-char"
        src="@/assets/images_essencial/personagem.png"
        alt="Personagem do jogo">
    <ButtonModal @btn-press="gameInfo.showMemoryGame = true" x-position="1550" y-position="620"/>
    <ButtonModal @btn-press="gameInfo.showBarrackGame = true" x-position="1350" y-position="320"/>
    <ButtonModal @btn-press="gameInfo.showFireGame = true" x-position="470" y-position="420"/>
  </main>
</template>

<style>
main {
  overflow: hidden;
}

.game-background {
  position: fixed;
  z-index: -99;
  bottom: 0;
  left: 0;
  width: 100vw;
}

.game-char {
  transform: translateY(-100px);
  opacity: 0;
  position: absolute;
  bottom: 10%;
  transition: 1s;
}

.showing-char {
  opacity: 1;
  transform: translateY(0px);
}

.btn-fullscreen {
  position: fixed;
  top: 10%;
  right: 5%;
  background: none;
  border: none;
  width: 150px;
  aspect-ratio: 1;

  img {
    width: 100%;
    height: 100%;
  }
}

</style>
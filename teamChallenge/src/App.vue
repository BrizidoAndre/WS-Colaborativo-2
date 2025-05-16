<script setup>
import {RouterLink, RouterView} from 'vue-router'
import logo from '@/assets/logo.png';
import {onMounted, onUnmounted, useTemplateRef} from "vue";

const headerRef = useTemplateRef('headerRef');
const heroRef = useTemplateRef('heroRef');
onMounted(() => {
  loadObserver()
})

function loadObserver() {
  const intersectionObserver = new IntersectionObserver((entries) => {
    // If intersectionRatio is 0, the target is out of view
    if (entries[0].intersectionRatio <= 0) {
      headerRef.value.classList.add('background-transparent')
    } else {
      headerRef.value.classList.remove('background-transparent')
    }
  });
  intersectionObserver.observe(heroRef.value);
}
</script>

<template>
  <header ref="headerRef" class="header-website a-center row j-between">
    <img class="logo logo-header" :src="logo" alt="Logotipo do site">
    <div class="row a-center">
      <input type="text" class="search rounded" placeholder="restaurantes">
      <nav>
        <ul>
          <li>
            <a href="#feedback" class="link">Feedback
              <hr class="header-line">
            </a>
          </li>
          <li>
            <a href="#restaurants" class="link">
              Restaurantes
              <hr class="header-line">
            </a>
          </li>
          <li>
            <a href="#plates" class="link">
              Pratos
              <hr class="header-line">
            </a>
          </li>
          <li>
            <a href="#home" class="link">
              Início
              <hr class="header-line">
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  <main>
    <section ref="heroRef" id="home" class="col a-center j-center">
      <img class="image-home-background" src="@/assets/restaurantes/background.jpg" alt="Hero background">
      <p class="title-helper bold">Conheça a culinária da</p>
      <h1 class="title">Cidade Gastronômica da França</h1>
      <a href="#plates" class="btn">Saiba mais</a>
    </section>
    <section id="plates">
      <div class="row j-between a-center">
        <div class="col plate-text">
          <h2 class="subtitle">Pratos típicos</h2>
          <p class="text">Lyon é considerada a capital da gastronomia francesa, com uma culinária bastante particular.
            Possui uma
            extensa lista de pratos e receitas típicas, muitas delas envolvendo carnes, terrines, linguiças, embutidos e
            as famosas pralines rosas.</p>
        </div>
        <img class="image-about half" src="@/assets/mapa.png" alt="Mapa de lyon">
      </div>
      <div class="container-plates">
        <div class="col rounded card-plate">
          <img src="@/assets/pratos/Grougères%20au%20fromage.jpg" alt="Boychons" class="img-plate">
          <div class="container-text">
            <h3 class="plate-title">
              Grougères au fromage
            </h3>
            <p class="plate-description">
              Folhados de queijo francês
            </p>
          </div>
        </div>
        <div class="col rounded card-plate">
          <img src="@/assets/pratos/rosette-de-lyon-263464.webp" alt="Boychons" class="img-plate">
          <div class="container-text">
            <h3 class="plate-title">
              Rosette de Lyon
            </h3>
            <p class="plate-description">
              Uma salsicha de porco curada conhecida pela sua cor vermelha brilhante
            </p>
          </div>
        </div>
        <div class="col rounded card-plate">
          <img src="@/assets/pratos/jesus.webp" alt="Boychons" class="img-plate">
          <div class="container-text">
            <h3 class="plate-title">
              Jésus
            </h3>
            <p class="plate-description">
              Outra salsicha de porco com diâmetro maior que a maioria
            </p>
          </div>
        </div>
        <div class="col rounded card-plate">
          <img src="@/assets/pratos/Potatoes_lyonnaise.jpg" alt="Boychons" class="img-plate">
          <div class="container-text">
            <h3 class="plate-title">
              À La Lyonnaise
            </h3>
            <p class="plate-description">
              Qualquer prato com "à la Lyonnaise" anexado refere-se à base saborosa por
              trás de melhores receitas.
            </p>
          </div>
        </div>
        <div class="col rounded card-plate">
          <img src="@/assets/pratos/gateay%20de%20foie.jpg" alt="Boychons" class="img-plate">
          <div class="container-text">
            <h3 class="plate-title">
              Gateau de Foie de Volaille
            </h3>
            <p class="plate-description">
              Um bolo de fígado feito com frango de Bresse, ovos, brioche e chalotas.
            </p>
          </div>
        </div>
      </div>
    </section>
    <section id="restaurants">
      <div class="container-text">
        <h2 class="subtitle">
          Restaurantes
        </h2>
        <p class="text">
          Lyon possuí inúmeros bons restaurantes, incluindo os famosos “Bouchons Lyonnais”, verdadeiras instituições
          francesas, servindo uma cozinha tão tradicional quanto deliciosa.
        </p>
      </div>
      <div class="row j-between a-center my">
        <div class="grid-restaurants">
          <div class="col restaurant-card">
            <h3 class="restaurant-title">Frazarin</h3>
            <div class="row a-center container-star">
              <img class='image-star' src="@/assets/estrela.png" alt="Estrela de revie">
              <p class="text bold">4.9</p>
            </div>
            <p class="text gray">
              Italiana, Francesa
            </p>
            <p class="text gray">
              $$ - $$$
            </p>
          </div>
          <div class="col restaurant-card">
            <h3 class="restaurant-title">La Source</h3>
            <div class="row a-center container-star">
              <img class='image-star' src="@/assets/estrela.png" alt="Estrela de revie">
              <p class="text bold">4.9</p>
            </div>
            <p class="text gray">
              Francesa, Saudável
            </p>
            <p class="text gray">
              $
            </p>
          </div>
          <div class="col restaurant-card">
            <h3 class="restaurant-title">Les Terrasses de Lyon</h3>
            <div class="row a-center container-star">
              <img class='image-star' src="@/assets/estrela.png" alt="Estrela de revie">
              <p class="text bold">4.3</p>
            </div>
            <p class="text gray">
              Francesa
            </p>
            <p class="text gray">
              $$$$
            </p>
          </div>
          <div class="col restaurant-card">
            <h3 class="restaurant-title">Chez Michele</h3>
            <div class="row a-center container-star">
              <img class='image-star' src="@/assets/estrela.png" alt="Estrela de revie">
              <p class="text bold">4.5</p>
            </div>
            <p class="text gray">
              Francesa, Europeia
            </p>
            <p class="text gray">
              $
            </p>
          </div>
        </div>
        <img src="@/assets/restaurantes.png" alt="Homem fazendo prato flambado" class="image-restaurant rounded">
      </div>
    </section>
    <section id="feedback">
      <div class="col">
        <h2 class="subtitle">Feedbacks</h2>
        <div class="text gray">
          Próximo à Lyon está localizado o famoso L’Auberge du Pont de Colognes, o restaurante de Paul Bocuse, que há 50
          anos conta com 3 estrelas Michelin. Além dele, o chef possui outros restaurantes na cidade, com preços menores
          e mais abordáveis.
        </div>
      </div>
      <div class="row container-perfil">
        <div class="col card-perfil">
          <div class="row a-center container-profile-name">
            <img class="image-profile" src="@/assets/perfil.png" alt="Imagem de perfil comum">
            <h3 class="perfil-title">Matias</h3>
          </div>
          <p class="text">
            Jornalista cultural, carioca, viaja para experimentar outras formas de ver o mundo, conhecer novos saberes e
            sabores. Gosta de procurar alternativas econômicas pra conhecer os destinos, mas sem abrir mão de comer bem.
            De tempos em tempos, fugir pro mato é essencial.
          </p>
        </div>
        <div class="col card-perfil">
          <div class="row a-center container-profile-name">
            <img class="image-profile" src="@/assets/perfil.png" alt="Imagem de perfil comum">
            <h3 class="perfil-title">Augustos</h3>
          </div>
          <p class="text">
            Olha, geralmente as reservas em restaurantes normais podem ser realizadas na véspera, ou até no próprio dia
            (se for para o jantar). Apenas restaurantes de Chef ou Estrelados pelo Guia Michelin costumam ter uma
            demanda maior e consequentemente precisam de reserva mais antecipada. Um abraço!
          </p>
        </div>
      </div>
    </section>
  </main>
  <footer>
    <div class="row j-between a-center">
      <ul>
        <li><a class="link-footer" href="#feedback">Feedbacks</a></li>
        <li><a class="link-footer" href="#restaurants">Resstaurantes</a></li>
        <li><a class="link-footer" href="#plates">Pratos</a></li>
        <li><a class="link-footer" href="#home">Início</a></li>
      </ul>
      <img src="@/assets/logo.png" alt="Logotipo do website" class="logo-footer">
    </div>
    <p class="direitos">@ Lyon Travel 2025</p>
  </footer>
</template>
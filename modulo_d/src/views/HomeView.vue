<script setup>

import Title from "@/components/Title.vue";
import BtnFull from "@/components/BtnFull.vue";
import {onMounted, reactive, ref, useId} from "vue";
import {request, requestWithoutHeaders, siteInfo} from "@/utils.js";
import Text from "@/components/Text.vue";
import SubSubTitle from "@/components/SubSubTitle.vue";
import {useRoute, useRouter} from "vue-router";

const router = useRouter();
const post = reactive({
  quantity: '',
  posts: [],
})
const newPost = reactive({
  creating: false,
  title: '',
  description: '',
  tags: [],
  content: '',
})
const sort = ref('recentes');

onMounted(() => {
  loadPosts()
})

async function loadPosts() {
  const res = await requestWithoutHeaders('posts')
  const data = await res.json();
  post.quantity = data.totalCount;
  post.posts = data.posts;
  console.log(data);
}

function openModal() {
  clearModal();
  if (siteInfo.userToken === null) {
    router.push('/login');
    return null;
  }
  newPost.creating = true;
}

async function handleModal() {
  const res = request('posts/create', {
    body: JSON.parse(newPost),
  }, {
    'Authorization': 'Bearer ' + siteInfo.userToken,
  })
  const data = res.json();
}

function clearModal() {
  newPost.creating = false;
  newPost.title = '';
  newPost.description = '';
  newPost.tags = [];
  newPost.content = '';
}

const ids = {
  nome: useId(),
  tags: useId(),
  description: useId(),
  content: useId()
}

function viewSingle(id) {
  router.push('/view-single?id=' + id)
}

function handleNewPost() {
  console.log('teste');
  console.log(siteInfo.userToken);
  if (siteInfo.userToken === undefined) {
    router.push('/login')
    return null;
  }
  newPost.creating = true;
}
</script>

<template>
  <main class="container">
    <div v-if="newPost.creating" class="modal-outline" @click="newPost.creating = false">
      <div class="modal-container p-5">
        <Title>Novo post</Title>
        <div class="mb-3 d-flex flex-column">
          <label :for="ids.nome" class="form-label">Nome</label>
          <input type="text" v-model="newPost.title" :id="ids.nome">
        </div>
        <div class="mb-3 d-flex flex-column">
          <label :for="ids.tags" class="form-label">Tags</label>
          <input type="text" v-model="newPost.tags" :id="ids.tags">
        </div>
        <div class="mb-3 d-flex flex-column">
          <label :for="ids.description" class="form-label">Descrição</label>
          <input type="text" v-model="newPost.description" :id="ids.description">
        </div>
        <div class="mb-3 d-flex flex-column">
          <label :for="ids.content" class="form-label">Conteúdo</label>
          <input type="text" v-model="newPost.content" :id="ids.content">
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-between">
      <Title>Home</Title>
      <BtnFull role="link" @click="handleNewPost">Novo post</BtnFull>
    </div>
    <div class="my-3 d-flex justify-content-between">
      <Text>{{ post.quantity }} posts</Text>
      <div class="d-flex">
        <BtnFull :disabled="sort === 'popular'">Recentes</BtnFull>
        <BtnFull :disabled="sort === 'popular'">Populares</BtnFull>
        <BtnFull :disabled="sort === 'popular'">Sem resposta</BtnFull>
      </div>
    </div>
    <a class="cur" @click="viewSingle(postSingle.id)" v-for="postSingle in post.posts">
      <SubSubTitle>{{ postSingle.title }}</SubSubTitle>
      <Text>{{ postSingle.description }}</Text>
      <Text>{{ postSingle.content }}</Text>
    </a>
  </main>
</template>

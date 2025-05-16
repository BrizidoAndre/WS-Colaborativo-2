<script setup>

import {useRoute} from "vue-router";
import {onMounted, reactive, useId} from "vue";
import {request, siteInfo} from "@/utils.js";
import Title from "@/components/Title.vue";
import Text from "@/components/Text.vue";
import Subtitle from "@/components/Subtitle.vue";
import BtnFull from "@/components/BtnFull.vue";
import SubSubTitle from "@/components/SubSubTitle.vue";

const route = useRoute();
const post = reactive({
  id: '',
  author: '',
  title: '',
  content: '',
  description: '',
  comments: []
})

const newComment = reactive({
  content: '',
})

const id = useId();

onMounted(() => {
  getSingle();
})

async function getSingle() {
  const res = await request('posts/' + route.query.id,{},{
    'Authorization': 'Bearer ' + siteInfo.userToken,
  });
  const data = await res.json();
  post.title = data.title;
  post.author = data.author;
  post.comments = data.comments;
  post.content = data.content;
  post.description = data.description;
  post.id = data.id;
}

async function handleSubmit() {
  const res = request('comments/create/' + post.id, {
    body: JSON.stringify(newComment),
    method: 'POST'
  }, {
    "Authorization": "Bearer " + siteInfo.userToken
  })
  if((await res).status === 201){
      newComment.content = '';
      getSingle();
  }
}
</script>

<template>
  <main class="container">
    <div>
      <Title>{{ post.title }}</Title>
      <Text>Por {{ post.author }}</Text>
      <Text>{{ post.description }}</Text>
      <Text>{{ post.content }}</Text>
    </div>
    <Subtitle class="my-4">Comentários</Subtitle>
    <form @submit.prevent="handleSubmit" class="mb-5">
      <div class="mb-3 d-flex flex-column">
        <label :for="id" class="form-label">Novo comentário</label>
        <input type="text" v-model="newComment.content" :id="id">
      </div>
      <BtnFull>Comentar</BtnFull>
    </form>
    <div class="comment" v-for="comments in post.comments">
      <div class="d-flex gap-2">
      <SubSubTitle>{{comments.author}}</SubSubTitle>
        <Text>Pontuação:  {{comments.score}}</Text>
      </div>
      <Text>{{comments.content}}</Text>
    </div>
  </main>
</template>

<style scoped>

</style>
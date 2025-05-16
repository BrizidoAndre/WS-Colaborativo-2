<script setup>


import {onMounted, reactive, ref} from "vue";
import {request, siteInfo} from "@/utils.js";
import {useRoute, useRouter} from "vue-router";
import Title from "@/components/Title.vue";
import Text from "@/components/Text.vue";
import BtnFull from "@/components/BtnFull.vue";
import SubSubTitle from "@/components/SubSubTitle.vue";

const route = useRoute();
const router = useRouter();
const post = reactive({
  posts: [],
  totalCount: 0,
})
const sort = ref('recents');
onMounted(() => {
  getSingle();
})

async function getSingle() {
  const res = await request('posts/mine', {}, {
    "Authorization": "Bearer " + siteInfo.userToken,
    'Access-Control-Allow-Origin': '*',
  });
  const data = await res.json()
  post.totalCount = data.totalCount;
  post.posts = data.posts;
  console.log(data);
}

function viewSingle(id) {
  router.push('/view-single?id=' + id)
}
</script>

<template>
  <div class="container">
    <div class="d-flex justify-content-between">
      <Title>MEUS POSTS</Title>
      <BtnFull role="link">Novo post</BtnFull>
    </div>
    <div class="my-3 d-flex justify-content-between">
      <Text>{{ post.totalCount }} posts</Text>
      <div class="d-flex">
        <BtnFull @click="sort = 'recents'" :class="{'disabled':sort !== 'recents'}">Recentes</BtnFull>
        <BtnFull @click="sort = 'popular'" :class="{'disabled': sort !== 'popular'}">Populares</BtnFull>
        <BtnFull @click="sort = 'no'" :class="{'disabled': sort !== 'no'}">Sem resposta</BtnFull>
      </div>
    </div>
    <a class="cur" @click="viewSingle(postSingle.id)" v-for="postSingle in post.posts">
      <SubSubTitle>{{ postSingle.title }}</SubSubTitle>
      <Text>{{ postSingle.description }}</Text>
      <Text>{{ postSingle.content }}</Text>
    </a>
  </div>
</template>

<style scoped>

</style>
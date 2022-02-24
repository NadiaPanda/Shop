<template>
    <div>
         <h1>{{pageTitle}}</h1>
  
        <div class="row"> 
         <categories-component 
         v-for='category in categories'
         :key="category.id"
         :category="category"
         :route-category="routeCategory"
         >
        </categories-component>
</div>  
</template>

<script>
export default {
    props: ['test', 'pageTitle', 'categories','routeAdminCategories', 'routeCategory'],
    mounted () {
        console.log(this.routeAdminCategories)
    }
}


</script>

<style scoped>

</style>
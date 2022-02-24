<template>
<div>
<div  class="col-3">
            <div class="card mb-4" style="width: 18rem;">
                <img :src="`/storage/${category.picture}`" class="card-img-top" :alt="category.name">
                <div class="card-body">
                    <h5 class="card-title">
                        {{category.name}}
                    </h5>
                    <p class="card-text">
                        {{ category.description }}
                    </p>
                    <a href="" class="btn btn-primary">Перейти</a>
                </div>
            </div>
        </div>
  </div>
  
</template>

<script>
export default {
    props: ['category']
}
</script>


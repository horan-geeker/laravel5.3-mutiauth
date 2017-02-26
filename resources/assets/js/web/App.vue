<template>
    <div>
        <v-nav></v-nav>
        <v-container></v-container>
        <v-foot></v-foot>
    </div>
</template>
<style>
</style>
<script>
    import nav from './components/nav/nav.vue'
    import container from './components/container/container.vue'
    import foot from './components/foot/foot.vue'

    export default{
        data () {
            return {
                msg: 'hello vue',
            }
        },
        components:{
            'v-nav': nav,
            'v-container': container,
            'v-foot': foot,
        }
    }
</script>

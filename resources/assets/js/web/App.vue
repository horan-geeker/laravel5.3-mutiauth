<template>
    <div>
        <v-nav></v-nav>
        <div style="min-height:400px">
            <keep-alive>
                <router-view :token="token"></router-view>
            </keep-alive>
        </div>
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
                token: window.Laravel.csrfToken,
            }
        },
        components:{
            'v-nav': nav,
            'v-container': container,
            'v-foot': foot,
        }
    }
</script>

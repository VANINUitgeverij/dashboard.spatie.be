<template>
    <div>
        <transition 
            appear 
            name="blur-background"
        >
            <div v-if="show" class="overlay__background"></div>
        </transition>
        <transition 
            appear 
            name="fade-overlay"
        >
            <div v-if="show" class="overlay__container">
                <slot></slot>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: {
            show: {
                type: Boolean,
                default: false,
            }
        }
    };
</script>
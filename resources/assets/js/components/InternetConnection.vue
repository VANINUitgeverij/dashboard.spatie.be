<template>
    <transition name="bounce">
        <section v-if="offline" class="internet-connection">
            <div class="internet-connection__alert">
                <span class="internet-connection__icon h-icon"></span>
                <span class="internet-connection__text">Internet connection</span>
            </div>
        </section>
    </transition>
</template>

<script>
    import { addClassModifiers } from '../helpers';

    export default {
        data() {
            return {
                offline: false,
            };
        },

        created() {
            window.addEventListener('online', this.updateStatus);
            window.addEventListener('offline', this.updateStatus);
            this.updateStatus();
        },

        methods: {
            addClassModifiers,

            updateStatus: function () {
                if (typeof window.navigator.onLine === 'undefined') {
                    this.offline = false;
                } else {
                    this.offline = !window.navigator.onLine;
                }
            },
        },
    };
</script>

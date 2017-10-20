<template>
    <section v-if="offline" class="internet-connection">
        <div class="internet-connection__alert">
            <span class="internet-connection__icon h-icon"></span>
            <span class="internet-connection__text">Internet connection</span>
        </div>
    </section>
</template>

<script>
    import echo from '../mixins/echo';
    import { addClassModifiers } from '../helpers';
    import moment from 'moment';

    export default {

        mixins: [echo],

        data() {
            return {
                offline: false,
                lastHeartBeatReceivedAt: moment(),
            };
        },

        created() {
            // if the browser supports navigator.online, we use that feature instead of using the interval.

            if (window.navigator.onLine) {
                window.addEventListener('online', this.updateStatus);
                window.addEventListener('offline', this.updateStatus);
            } else {
                setInterval(this.determineConnectionStatus, 1000);
            }
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

            determineConnectionStatus() {
                const lastHeartBeatReceivedSecondsAgo = moment().diff(this.lastHeartBeatReceivedAt, 'seconds');

                this.offline = lastHeartBeatReceivedSecondsAgo > 125;
            },

            getEventHandlers() {
                return {
                    'InternetConnection.Heartbeat': () => {
                        this.lastHeartBeatReceivedAt = moment();
                    },
                };
            },
        },
    };
</script>

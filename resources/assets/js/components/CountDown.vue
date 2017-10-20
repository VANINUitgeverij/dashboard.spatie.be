<template>
    <tile v-if='!showOverlay' :position="position">
        <section class="count-down">
            <div class="count-down__content">
                <div class="count-down__name">{{ name }}</div>
                <div class="count-down__group">
                    <div v-for="(value, key) in countDown" class="count-down__block">
                        <div class="count-down__value">{{ value }}</div>
                        <div class="count-down__name">{{ key }}{{ value == 1 ? '' : 's'}}</div>
                    </div>
                </div>
            </div>
        </section>
    </tile>

    <overlay v-else>
        <div class="count-down__content">
                <div class="count-down__name">{{ name }}</div>
                <div class="count-down__group">
                    <div v-for="(value, key) in countDown" class="count-down__block">
                        <div class="count-down__value">{{ value }}</div>
                        <div class="count-down__name">{{ key }}{{ value == 1 ? '' : 's'}}</div>
                    </div>
                </div>
            </div>
    </overlay>
</template>

<script>
    import Tile from './atoms/Tile';
    import Overlay from './atoms/Overlay';
    import moment from 'moment-timezone';

    export default {

        components: {
            Tile,
            Overlay
        },

        props: {
            name: {
                type: String,
            },
            cron: {
                type: String,
                default: '55 10 * * 1-5',
            },
            duration: {
                type: Number,
                default: 800, //15 minutes
            },
            position: {
                type: String,
            },
            overlay: {
                type: Number,
                default: -1
            }
        },

        data() {
            return {
                next: moment(),
                time: moment(),
            };
        },

        computed: {
            countDown: function () {
                var duration = moment.duration(this.next - this.time);
                return {
                    day: duration.days(),
                    hour: duration.hours(),
                    minute: duration.minutes(),
                    second: duration.seconds(),
                };
            },

            showOverlay: function () {
                if  (moment.duration(this.next - this.time).asMinutes() <= this.overlay) {
                    return true;
                }

                return false;
            }
        },

        created() {
            this.init();
            setInterval(this.refreshTime, 1000);
        },

        methods: {
            init() {
                var parser = require('cron-parser');
                var interval = parser.parseExpression(this.cron);
                this.next = moment(interval.next().toISOString());
            },

            refreshTime() {
                this.time = moment();
            },
        },
    };
</script>

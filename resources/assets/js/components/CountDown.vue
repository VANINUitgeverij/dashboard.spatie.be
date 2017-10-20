<template>
        <tile v-if='position' :position="position">
            <section class="count-down">
                <div class="count-down__content">
                    <div class="count-down__name">{{ name }} {{ timer ? 'finished' : ''}} in</div>
                    <div class="count-down__group">
                        <div v-for="(value, key) in countDown" class="count-down__block">
                            <div class="count-down__value">{{ value }}</div>
                            <div class="count-down__name">{{ key }}{{ value == 1 ? '' : 's'}}</div>
                        </div>
                    </div>
                </div>
            </section>
        </tile>

        <overlay v-else :show="showOverlay">
            <div class="count-down__content">
                    <div class="count-down__name">{{ name }} {{ timer ? 'finished' : ''}} in </div>
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
            position: {
                type: String,
            },
            overlayMinutes: {
                type: Number,
                default: -1
            },
            timerMinutes: {
                type: Number,
                default: -1
            }
        },

        data() {
            return {
                next: moment(),
                time: moment(),
                timer: false,
            };
        },

        computed: {
            countDown: function () {
                var duration = this.getDuration();
                var counter = {
                    day: duration.days(),
                    hour: duration.hours(),
                    minute: duration.minutes(),
                    second: duration.seconds(),
                };

                for (var key in counter) {
                    if (counter[key] == 0) {
                        delete counter[key];
                        continue;
                    }

                    break;
                }

                if (Object.keys(counter).length == 0) {
                    if(this.timerMinutes > 0) {
                        if (this.timer) {
                            this.init();
                        } else {
                            this.next = moment().add(this.timerMinutes, 'm');
                        }
                        this.timer = !this.timer;
                    }
                    
                }

                return counter;
            },

            showOverlay: function () {
                if  (
                    this.getDuration().asMinutes() <= this.overlayMinutes ||
                    this.timer
                ) {
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

            getDuration() {
                return moment.duration(this.next - this.time)
            }
        },
    };
</script>

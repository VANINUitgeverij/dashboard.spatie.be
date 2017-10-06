<template>
    <tile :position="position" modifiers="overflow" :alert="alert">
        <section class="statistics">
            <h1>GitHub: {{ project }}</h1>
            <ul>
                <li class="statistic">
                    <span class="statistic__label">Pull Requests</span>
                    <span class="statistic__count">{{ formatNumber(pullRequests.count) }}</span>
                </li>
                <li class="github-label" v-for="label in pullRequests.labels" :style="{ 'background-color': `#` +  label.color }">
                    <span class="github-label__label">{{ label.name }}</span>
                    <span class="github-label__count">{{ formatNumber(label.count) }}</span>
                </li>
            </ul>
        </section>
    </tile>
</template>

<script>
    import { formatNumber } from '../helpers';
    import echo from '../mixins/echo';
    import Tile from './atoms/Tile';
    import saveState from 'vue-save-state';

    export default {

        components: {
            Tile,
        },

        mixins: [echo, saveState],

        props: [
            'position',
            'project',
        ],

        data() {
            return {
                pullRequests: 0,
            };
        },

        computed: {
            alert: function () {
                switch (true) {
                    case this.pullRequests.count > 7:
                        return 'tile--red';
                    case this.pullRequests.count > 4:
                        return 'tile--orange';
                    default:
                        return '';
                }
            },
        },

        methods: {
            formatNumber,

            getEventHandlers() {
                return {
                    'GitHub.TotalsDetailFetched': response => {
                        this.pullRequests = response.totalDetails[this.project].pullRequests;
                    },
                };
            },

            getSaveStateConfig() {
                return {
                    cacheKey: 'githubProject-' + this.project,
                };
            },
        },
    };
</script>
<template>
    <div :class="[tileLook, alert]" :style="tilePosition">
        <slot></slot>
    </div>
</template>

<script>
import { addClassModifiers, positionToGridAreaNotation } from '../../helpers';

export default {

        props: ['position', 'modifiers', 'alert'],

    computed: {
        tilePosition() {
            return `grid-area: ${positionToGridAreaNotation(this.position)}`;
        },

        tileLook() {
            return addClassModifiers('tile', this.modifiers);
        },
    },
};
</script>

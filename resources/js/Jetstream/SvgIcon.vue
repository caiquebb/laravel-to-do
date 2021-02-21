<template>
    <svg
        :class="[
            size === 'xs' ? classes.xs : '',
            size === 'sm' ? classes.sm : '',
            size === 'md' ? classes.md : '',
            size === 'lg' ? classes.lg : '',
        ]"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
    >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="svgIcon[icon]" />
    </svg>
</template>

<script>
    export default {
        props: {
            icon: {
                type: String,
                required: true,
            },
            size: {
                type: String,
                default: 'md',
            },
        },

        data: function () {
            return {
                classes:{
                    xs: 'h-2 w-2',
                    sm: 'h-4 w-4',
                    md: 'h-6 w-6',
                    lg: 'h-8 w-8',
                },
                svgIcon: {
                    x: 'M6 18L18 6M6 6l12 12',
                    check: 'M5 13l4 4L19 7',
                    dotsVertical: 'M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z',
                    chevronDoubleDown: 'M19 13l-7 7-7-7m14-8l-7 7-7-7',
                    chevronDoubleUp: 'M5 11l7-7 7 7M5 19l7-7 7 7',
                    plus: 'M12 6v6m0 0v6m0-6h6m-6 0H6',
                    trash: 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
                    menuAlt3: 'M4 6h16M4 12h16m-7 6h7',
                    switchVertical: 'M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4',
                },
            }
        }
    }
</script>

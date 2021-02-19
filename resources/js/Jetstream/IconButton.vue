<template>
    <button
        :type="type"
        :class="[
            classes.btn,
            variant === 'link' ? classes.btnLink : '',
            variant === 'primary' ? classes.btnPrimary : '',
            variant === 'secondary' ? classes.btnSecondary : '',
            `text-${size}`
        ]"
    >
        <jet-svg-icon :icon="icon" :size="size"/>
    </button>
</template>

<script>
    import JetSvgIcon from '@/Jetstream/SvgIcon';

    export default {
        components: {
            JetSvgIcon,
        },

        props: {
            type: {
                type: String,
                default: "button",
            },
            variant: {
                type: String,
                default: "primary",
            },
            icon: {
                type: String,
                default: "check",
            },
            size: {
                type: String,
                default: 'md',
            },
        },

        data: function () {
            return {
                classes: {
                    btn: 'p-1.5 inline-flex items-center rounded-md font-semibold uppercase tracking-widest focus:outline-none transition ease-in-out duration-150',
                    btnLink: 'border border-transparent text-gray-700 hover:text-gray-700 focus:outline-none active:text-gray-800',
                    btnPrimary: 'bg-gray-800 border border-transparent text-white hover:bg-gray-700 active:bg-gray-900 focus:border-gray-900 focus:shadow-outline-gray',
                    btnSecondary: 'bg-white border border-gray-300 text-gray-700 shadow-sm hover:text-gray-500 focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50',
                },
            }
        },
    };
</script>

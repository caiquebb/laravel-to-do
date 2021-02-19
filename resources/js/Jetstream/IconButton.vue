<template>
    <button
        :type="type"
        :class="[
            classes.btn,
            variant === 'link' ? classes.btnLink : '',
            variant === 'primary' ? classes.btnPrimary : '',
            variant === 'secondary' ? classes.btnSecondary : '',
        ]"
    >
        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" :d="svgIcon[icon] || ''" clip-rule="evenodd" />
        </svg>
    </button>
</template>

<script>
    export default {
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
            }
        },

        data: function () {
            return {
                classes: {
                    btn: 'inline-flex items-center p-2 rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none transition ease-in-out duration-150',
                    btnLink: 'border border-transparent text-gray-700 hover:text-gray-700 focus:outline-none active:text-gray-800',
                    btnPrimary: 'bg-gray-800 border border-transparent text-white hover:bg-gray-700 active:bg-gray-900 focus:border-gray-900 focus:shadow-outline-gray',
                    btnSecondary: 'bg-white border border-gray-300 text-gray-700 shadow-sm hover:text-gray-500 focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50',
                },
                svgIcon: {
                    x: 'M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z',
                    check: 'M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z',
                    dotsVertical: 'M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z',
                    chevronDoubleDown: 'M15.707 4.293a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-5-5a1 1 0 011.414-1.414L10 8.586l4.293-4.293a1 1 0 011.414 0zm0 6a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-5-5a1 1 0 111.414-1.414L10 14.586l4.293-4.293a1 1 0 011.414 0z'
                },
            }
        },
    };
</script>

<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-2 sm:px-4 bg-white border-b border-gray-200">
            <div class="flex flex-row">
                <div class="flex-1">
                    <h2 class="text-lg font-bold">{{todo.description}}</h2>
                    <p>5 / 10 ITEMS</p>
                </div>
                <div class="flex-none self-center">
                    <button type="button" class="border-2 rounded-full p-1 hover:border-black focus:none">
                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            todo: Object
        }
    }
</script>

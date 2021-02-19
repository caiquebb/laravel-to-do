<template>
    <div>
        <div v-if="showingTodoItem" @click="hideTodoItem" class="border-t border-gray-200 flex justify-center py-1 px-2 hover:bg-gray-200 cursor-pointer">
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11l7-7 7 7M5 19l7-7 7 7" />
            </svg>
        </div>
        <div v-if="showingTodoItem" class="flex justify-center border-t border-gray-200 border-dashed p-4 space-x-2">
            <div v-if="addingTodoItem" :class="[addCardClass, 'space-x-2']">
                <div class="flex-1">
                    <jet-input class="w-full" type="text" placeholder="Description" v-model="form.description"/>

                    <jet-input-error :message="errors.description ? errors.description.join(' ') : ''" />
                </div>
                <div class="flex-none self-center">
                    <jet-icon-button type="submit" icon='check' @click.native="createTodo"></jet-icon-button>
                    <jet-icon-button icon='x' variant="secondary" @click.native="cancelTodoItem"></jet-icon-button>
                </div>
            </div>
            <div v-else @click="addTodoItem" :class="[!addingTodoItem ? newCardClass : '', addCardClass]">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>New To Do Item</span>
            </div>
        </div>
        <div v-else @click="showTodoItem" class="border-t border-gray-200 flex justify-center py-1 hover:bg-gray-200 cursor-pointer">
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
            </svg>
        </div>
    </div>
</template>

<script>
    import JetIconButton from '@/Jetstream/IconButton';
    import JetInput from '@/Jetstream/Input';
    import JetInputError from '@/Jetstream/InputError';

    export default {
        components: {
            JetIconButton,
            JetInput,
            JetInputError,
        },

        data: function () {
            return {
                addingTodoItem: false,
                showingTodoItem: false,
                addCardClass: 'flex w-full p-2 border-2 border-gray-500 border-dashed overflow-hidden shadow-xl sm:rounded-lg',
                newCardClass: 'justify-center hover:border-black hover:bg-gray-300 cursor-pointer',
                form: {},
                errors: {},
            }
        },

        methods: {
            addTodoItem: function (event) {
                if (this.addingTodoItem) {
                    return;
                }

                this.addingTodoItem = true;
            },

            cancelTodoItem: function () {
                this.addingTodoItem = false;
            },

            showTodoItem: function (event) {
                if (this.showingTodoItem) {
                    return;
                }

                this.showingTodoItem = true;
            },

            createTodoItem: async function () {
                const { user } = this.$page.props;

                try {
                    this.errors = {};

                    await axios.post(`/api/users/${user.id}/todos`, this.form);

                    this.$emit('createdTodo');

                    this.showingTodoItem = false;
                } catch (error) {
                    const { response } = error;

                    console.log(response);

                    if (response.status === 422) {
                        this.errors = response.data.errors;
                    }
                }


            },

            hideTodoItem: function(event) {
                this.showingTodoItem = false
            },
        },
    }
</script>

<template>
    <div>
        <div class="flex justify-center border-t border-gray-200 border-dashed p-4 space-x-2">
            <div v-if="addingTodoItem" :class="[addCardClass, 'space-x-2']">
                <div class="flex-1">
                    <jet-input class="w-full text-xs" type="text" placeholder="Description" v-model="form.description"/>

                    <jet-input-error :message="errors.description ? errors.description.join(' ') : ''" />
                </div>
                <div class="flex-none self-center">
                    <jet-icon-button type="submit" icon='check' size="sm" @click.native="createTodoItem"></jet-icon-button>
                    <jet-icon-button icon='x' size="sm" variant="secondary" @click.native="cancelTodoItem"></jet-icon-button>
                </div>
            </div>

            <div v-else @click="addTodoItem" :class="[!addingTodoItem ? newCardClass : '', addCardClass]">
                <jet-svg-icon icon="plus" size="sm"/>

                <span class="ml-2 text-sm">New To Do Item</span>
            </div>
        </div>
    </div>
</template>

<script>
    import JetIconButton from '@/Jetstream/IconButton';
    import JetInput from '@/Jetstream/Input';
    import JetInputError from '@/Jetstream/InputError';
    import JetCheckbox from '@/Jetstream/Checkbox';
    import JetSvgIcon from '@/Jetstream/SvgIcon';

    export default {
        components: {
            JetIconButton,
            JetInput,
            JetInputError,
            JetCheckbox,
            JetSvgIcon,
        },

        props: {
            todo: Object,
        },

        data: function () {
            return {
                addingTodoItem: false,
                addCardClass: 'flex flex-row items-center w-full p-2 border-2 border-gray-500 border-dashed overflow-hidden shadow-xl sm:rounded-lg',
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

            createTodoItem: async function () {
                const { id } = this.todo;

                try {
                    this.errors = {};

                    await axios.post(`/api/todos/${id}/todo-items`, this.form);

                    this.$emit('createdTodoItem');

                    this.form = {};

                    this.addingTodoItem = false;
                } catch (error) {
                    const { response } = error;

                    console.log(response);

                    if (response.status === 422) {
                        this.errors = response.data.errors;
                    }
                }


            },

            deleteTodoItem: async function (id) {
                await axios.delete(`/api/todo-items/${id}`);

                this.$emit('deletedTodoItem', this.todo);
            },
        },
    }
</script>

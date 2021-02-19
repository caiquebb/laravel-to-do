<template>
    <div>
        <div v-if="addingTodo" :class="[addCardClass, 'space-x-2']">
            <div class="flex-1">
                <jet-input class="w-full" type="text" placeholder="Description" v-model="form.description"/>

                <jet-input-error :message="errors.description ? errors.description.join(' ') : ''" />
            </div>
            <div class="flex-none self-center">
                <jet-icon-button type="submit" icon='check' @click.native="createTodo"></jet-icon-button>
                <jet-icon-button icon='x' variant="secondary" @click.native="cancelTodo"></jet-icon-button>
            </div>
        </div>
        <div v-else @click="addTodo" :class="[!addingTodo ? newCardClass : '', addCardClass]">
            <div class="inline-flex self-center">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span>New To Do</span>
            </div>
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
                addingTodo: false,
                addCardClass: 'flex p-4 border-2 border-gray-500 border-dashed overflow-hidden shadow-xl sm:rounded-lg',
                newCardClass: 'justify-center hover:border-black hover:bg-gray-300 cursor-pointer',
                form: {},
                errors: {},
            }
        },

        methods: {
            addTodo: function (event) {
                if (this.addingTodo) {
                    return;
                }

                this.addingTodo = true;
            },

            createTodo: async function () {
                const { user } = this.$page.props;

                try {
                    this.errors = {};

                    await axios.post(`/api/users/${user.id}/todos`, this.form);

                    this.$emit('createdTodo');

                    this.form = {};

                    this.addingTodo = false;
                } catch (error) {
                    const { response } = error;

                    console.log(response);

                    if (response.status === 422) {
                        this.errors = response.data.errors;
                    }
                }


            },

            cancelTodo: function(event) {
                this.addingTodo = false
            },
        },
    }
</script>

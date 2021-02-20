<template>
    <div>
        <div class="flex flex-col bg-white sm:rounded-lg shadow-xl">
            <div class="flex flex-row p-2 sm-:px-4">
                <div class="flex-1">
                    <h3 :class="[todo.deleted_at ? 'line-through' : '', 'text-lg font-bold']">{{todo.description}}</h3>
                    <p class="text-xs">Created At: {{dateTimeFormat(todo.created_at)}}</p>
                    <p v-if="todo.deleted_at" class="text-xs text-red-600">Deleted At: {{dateTimeFormat(todo.deleted_at)}}</p>
                </div>
                <div v-if="todo.user_id === user.id" class="flex-none self-center">
                    <jet-dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <jet-icon-button icon="dotsVertical" variant="link"></jet-icon-button>
                            </span>
                        </template>

                        <template #content>
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                Manage Todo
                            </div>

                            <template v-if="todo.deleted_at">
                                <jet-dropdown-link as="button" @click.native="restoreTodo">
                                    Restore
                                </jet-dropdown-link>

                                <div class="border-t border-gray-100"></div>

                                <jet-dropdown-link as="button" @click.native="forceDeleteTodo">
                                    Force Delete
                                </jet-dropdown-link>
                            </template>

                            <template v-else>
                                <jet-dropdown-link as="button" @click.native="shareTodoModal">
                                    Share
                                </jet-dropdown-link>

                                <div class="border-t border-gray-100"></div>

                                <jet-dropdown-link as="button" @click.native="deleteTodo">
                                    Delete
                                </jet-dropdown-link>
                            </template>
                        </template>
                    </jet-dropdown>

                    <!-- Share ToDo Modal -->
                    <jet-dialog-modal :show="showShareTodoModal" @close="closeModal">
                        <template #title>
                            Share To Do
                        </template>

                        <template #content>
                            Are you sure you want to share your to do? Once your todo is shared, all of its items will be available for users to edit or remove. Please enter the emails that you would like to share your to do separeted with comma (,).

                            <div class="mt-4">
                                <jet-input type="text" class="mt-1 block w-full" placeholder="Shared e-mails"
                                            ref="shared_emails"
                                            v-model="todo.shared_emails"
                                            @keyup.enter.native="shareTodo" />

                                <jet-input-error :message="form.errors.shared_emails ? form.errors.shared_emails.join(' ') : ''" class="mt-2" />
                            </div>
                        </template>

                        <template #footer>
                            <jet-secondary-button @click.native="closeModal">
                                Cancel
                            </jet-secondary-button>

                            <jet-button class="ml-2" @click.native="shareTodo" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Send Invitation
                            </jet-button>
                        </template>
                    </jet-dialog-modal>
                </div>
            </div>

            <template v-if="!todo.deleted_at">
                <div @click="toggleTodoItemCard" class="border-t border-gray-200 flex justify-center py-1 hover:bg-gray-200 cursor-pointer">
                    <jet-svg-icon v-if="showTodoItemCard" icon="chevronDoubleUp" size="sm"/>

                    <jet-svg-icon v-else icon="chevronDoubleDown" size="sm"/>
                </div>

                <todo-item-card v-if="showTodoItemCard" :todo="todo"/>
            </template>
        </div>
    </div>
</template>

<script>
    import JetIconButton from '@/Jetstream/IconButton';
    import JetDropdown from '@/Jetstream/Dropdown';
    import JetDropdownLink from '@/Jetstream/DropdownLink';
    import JetSvgIcon from '@/Jetstream/SvgIcon';
    import TodoItemCard from './TodoItemCard';
    import JetDialogModal from '@/Jetstream/DialogModal';
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetButton from '@/Jetstream/Button'

    import moment from 'moment';

    export default {
        components: {
            JetIconButton,
            JetDropdown,
            JetDropdownLink,
            JetSvgIcon,
            TodoItemCard,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetSecondaryButton,
            JetButton,
        },

        props: {
            todo: Object
        },

        data: function () {
            return {
                showShareTodoModal: false,
                showTodoItemCard: false,
                form: {
                    processing: false,
                    errors: {},
                },
                user: this.$page.props.user,
            }
        },

        methods: {
            toggleTodoItemCard: function () {
                this.showTodoItemCard = !this.showTodoItemCard;
            },

            restoreTodo: async function () {
                const { id } = this.todo;

                await axios.post(`/api/todos/${id}/restore`);

                this.$emit('restoredTodo', this.todo);
            },

            forceDeleteTodo: async function () {
                const { id } = this.todo;

                await axios.delete(`/api/todos/${id}/force`);

                this.$emit('deletedTodo', this.todo);
            },

            deleteTodo: async function () {
                const { id } = this.todo;

                await axios.delete(`/api/todos/${id}`);

                this.$emit('deletedTodo', this.todo);
            },

            dateTimeFormat: function (date) {
                return moment(date).format('L - LTS');
            },

            shareTodoModal: function () {
                this.showShareTodoModal = true;

                setTimeout(() => this.$refs.shared_emails.focus(), 250)
            },

            shareTodo: async function () {
                this.form.processing = true;

                const { id } = this.todo;

                try {
                    await axios.put(route('api.todos.share', { todo: id }), this.todo);

                    this.closeModal();
                } catch (error) {
                    console.error(error);

                    if (error.response) {
                        const { status, data } = error.response;

                        if (status === 422) {
                            this.form.errors = data.errors;
                        }
                    }
                }

                this.form.processing = false
            },

            closeModal: function () {
                this.showShareTodoModal = false
                this.form.errors = {};
            },
        },
    }
</script>

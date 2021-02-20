<template>
    <div>
        <div class="flex flex-col bg-white sm:rounded-lg shadow-xl">
            <div class="flex flex-row p-2 sm-:px-4">
                <div class="flex-1">
                    <h3 :class="[todo.deleted_at ? 'line-through' : '', 'text-lg font-bold']">{{todo.description}}</h3>
                    <p class="text-xs">Created At: {{dateTimeFormat(todo.created_at)}}</p>
                    <p v-if="todo.deleted_at" class="text-xs text-red-600">Deleted At: {{dateTimeFormat(todo.deleted_at)}}</p>
                </div>
                <div class="flex-none self-center">
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
                                <jet-dropdown-link as="button">
                                    Share
                                </jet-dropdown-link>

                                <div class="border-t border-gray-100"></div>

                                <jet-dropdown-link as="button" @click.native="deleteTodo">
                                    Delete
                                </jet-dropdown-link>
                            </template>
                        </template>
                    </jet-dropdown>
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

    import moment from 'moment';

    export default {
        components: {
            JetIconButton,
            JetDropdown,
            JetDropdownLink,
            JetSvgIcon,
            TodoItemCard,
        },

        props: {
            todo: Object
        },

        data: function () {
            return {
                showTodoItemCard: false
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
        },
    }
</script>

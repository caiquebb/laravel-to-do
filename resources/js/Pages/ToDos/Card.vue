<template>
    <div :class="[
        'flex flex-col',
        'bg-white',
        'sm:rounded-lg',
        'shadow-xl',
    ]">
        <div class="flex flex-row p-2 sm-:px-4">
            <div class="flex-1">
                <h3 class="text-lg font-bold">{{todo.description}}</h3>
                <p>5 / 10 ITEMS</p>
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

                        <jet-dropdown-link as="button">
                            Share
                        </jet-dropdown-link>

                        <div class="border-t border-gray-100"></div>

                        <jet-dropdown-link as="button" @click.native="deleteTodo">
                            Delete
                        </jet-dropdown-link>
                    </template>
                </jet-dropdown>
            </div>
        </div>
        <todo-add-item-card/>
    </div>
</template>

<script>
    import JetIconButton from '@/Jetstream/IconButton';
    import JetDropdown from '@/Jetstream/Dropdown';
    import JetDropdownLink from '@/Jetstream/DropdownLink';
    import TodoAddItemCard from './AddItemCard';

    export default {
        components: {
            JetIconButton,
            JetDropdown,
            JetDropdownLink,
            TodoAddItemCard,
        },

        props: {
            todo: Object
        },

        methods: {
            deleteTodo: async function () {
                const { id } = this.todo;

                await axios.delete(`/api/todos/${id}`);

                this.$emit('deletedTodo', this.todo);
            },
        },
    }
</script>

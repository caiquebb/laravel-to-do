<template>
    <div>
        <div class="border-t border-gray-200 border-dashed flex flex-col p-2 px-4">
            <div :key="key" v-for="(item, key) in todoItems" :class="[key % 2 ? 'bg-gray-200' : 'bg-white', 'p-1 flex flex-row space-x-2 items-center']">
                <label class="flex w-full items-center">
                    <jet-checkbox v-model="item.completed" @change="updateTodoItem(item.id, item.completed)"></jet-checkbox>
                    <span :class="[item.completed ? 'line-through' : '', 'ml-2 text-sm w-full']">{{ item.description }}</span>
                </label>
                <button @click="deleteTodoItem(item.id)" class="text-red-600">
                    <jet-svg-icon icon="trash" size="sm" />
                </button>
            </div>
        </div>

        <add-todo-item-card :todo="todo" @createdTodoItem="getTodoItems"/>
    </div>
</template>

<script>
    import JetCheckbox from '@/Jetstream/Checkbox';
    import AddTodoItemCard from './AddTodoItemCard';
    import JetSvgIcon from '@/Jetstream/SvgIcon';

    export default {
        components: {
            JetCheckbox,
            AddTodoItemCard,
            JetSvgIcon,
        },

        props: {
            todo: Object,
        },

        data: function () {
            return {
                todoItems: [],
            }
        },

        mounted: function() {
            this.getTodoItems();
        },

        methods: {
            getTodoItems: async function() {
                const { id } = this.todo;

                const { data } = await axios.get(`/api/todos/${id}/todo-items`);

                this.todoItems = data;
            },

            updateTodoItem: function(id, completed) {
                axios.put(`/api/todo-items/${id}`, { completed });
            },

            deleteTodoItem: async function (id) {
                await axios.delete(`/api/todo-items/${id}`);

                this.getTodoItems();
            },
        },
    }
</script>

<template>
    <app-layout>
        <template #header>
            <div class="flex flex-row items-center">
                <h2 class="w-full font-semibold text-xl text-gray-800 leading-tight">
                    To Do List
                </h2>

                <div class="flex flex-row items-center">
                    <label class="mr-2 font-bold">Filter:</label>

                    <select class="rounded-lg text-sm py-1" v-model="params.filter">
                        <option value="my-todos">My ToDos</option>
                        <option value="recycle-bin">Recycle Bin</option>
                    </select>
                </div>
            </div>
        </template>

        <div class="py-6">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <todo-card :key="todo.id" v-for="todo in todos" :todo="todo" @deletedTodo="getUserTodos" @restoredTodo="getUserTodos"></todo-card>

                    <add-todo-card v-if="params.filter === 'my-todos'" class="col-span-full" @createdTodo="getUserTodos"/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout';
    import TodoCard from './TodoCard';
    import AddTodoCard from './AddTodoCard';
    import JetNavLink from '@/Jetstream/NavLink';

    export default {
        components: {
            AppLayout,
            TodoCard,
            AddTodoCard,
            JetNavLink,
        },

        data: function() {
            return {
                todos: [],
                params: {
                    filter: 'my-todos',
                }
            }
        },

        watch: {
            'params.filter': function (newVal, oldVal) {
                this.getUserTodos();
            }
        },

        mounted: function () {
            this.getUserTodos();
        },

        methods: {
            getUserTodos: async function() {
                const { user } = this.$page.props;

                const { data } = await axios.get(`/api/users/${user.id}/todos`, { params: this.params });

                this.todos = data;
            }
        }
    }
</script>

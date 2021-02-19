<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My To Do Lists
            </h2>
        </template>

        <div class="py-6">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <todo-card :key="todo.id" v-for="todo in todos" :todo="todo" @deletedTodo="getUserTodos"></todo-card>

                    <add-todo-card class="col-span-full" @createdTodo="getUserTodos"/>
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
                todos: []
            }
        },

        mounted: function () {
            this.getUserTodos();
        },

        methods: {
            getUserTodos: async function() {
                const { user } = this.$page.props;

                const { data } = await axios.get(`/api/users/${user.id}/todos`);

                this.todos = data;
            }
        }
    }
</script>

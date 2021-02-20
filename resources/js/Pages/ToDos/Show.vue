<template>
    <app-layout>
        <template #header>
            <div class="flex flex-row items-center">
                <h2 class="w-full font-semibold text-xl text-gray-800 leading-tight">
                    To Do Show
                </h2>
            </div>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <todo-card :todo="todo" @deletedTodo="redirectTodos"></todo-card>
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

        props: {
            todo: {
                type: Object,
                required: true,
            },
        },

        methods: {
            redirectTodos: function () {
                window.location.href = route('todos.list');
            }
        },
    }
</script>
